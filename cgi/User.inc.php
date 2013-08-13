<?php
if(!defined('UC_KEY')){
	include_once(TTROOT."/config/www.ucenter.inc.php");
}

include_once(TTROOT."/uc_client/client.php");
class User extends GlobalClass
{
	var $C;
	var $A;
	var $fp = null;
	var $U = null;
	var	$uid    = 0;
	var	$huanid = 0;
	var	$token  = '';
	var	$email='';
	var	$salt='';
	var	$userstatus='0';
	var	$username = '';
	var	$password = '';

	public static $obj = null;

	public static function Cinit(){
		if(self::$obj == null)
			self::$obj = new self();
		return self::$obj;
	}
	function log($msg){
		if($this->fp == null)return ;
		$s = date('Y-m-d H:i:s',time()).' '.session_id().' '.$msg."\r\n";
		fwrite($this->fp,$s);
		fflush($this->fp);
	}
	function __construct()
	{
		global $ARGV,$CONF;
		$this->C = $CONF;
		$this->A = $ARGV;
		if($CONF->APP['loginlog'] != ''){
			$this->fp = fopen($CONF->APP['loginlog'],'a+');
		}
		$this->uid = $this->A->Cookie("uid");
		try{
			if($this->uid>0)
				$this->loaduser();
		}catch(Exception $e){
		}
	}
	function check()
	{
		$token = $this->A->Cookie('token');
		if( !$token ) $token = $this->A->Post("token");
		if( !$token ) return false;
		if( $this->uid>0 ){
			if( md5($this->U->uid.strtolower($this->U->username)."12esdf%refd") == $token ){
				return true;
			}
		}
		return false;
	}
	function synclogin($uid){
		$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where uid='{$uid}'");
		if(DB::N($Q)<1)return 1;
		$U = DB::O($Q);
		$token = md5($U->uid.strtolower($U->username)."12esdf%refd");
		$this->scookie("token",$token,$this->C->MEMBER['expires']);
		$this->scookie("uid",$U->uid,$this->C->MEMBER['expires']);
		$this->scookie("username",$U->username,$this->C->MEMBER['expires']);
		return 0;
	}
	function debug(){
		return "username=".$this->username.";password=".$password.
			";huanid=".$this->huanid.";token=".$this->token.
			";email=".$this->email.";passwd=".$this->passwd.
			";uid=".$this->uid.";status=".$this->status.
			";salt=".$this->salt.";active=".$this->active.
			"";
	}
	function login($username,$password,$savepass=false)
	{
		if ( !$username || !$password ) return 1;
		$this->username = $username;
		$this->password = $password;
		$UC = new UserCenter($this->C);
		$this->log("logname=".$this->username.",pass=".$this->password);
		$res = $UC->loggin($this->username,md5($this->password));
		$this->log("logres=".$res->error->code);
		if(!$res)return 5;
		if($res->error->code == 0){//UC登录成功
			$this->huanid = $res->user->huanid;
			$this->token = $res->user->token;
			$info = $UC->getinfo($res->user->huanid,$res->user->token);
			if($info->error->code > 0) return 2;
			$this->email = $info->user->email;
		}else{//UC登录失败
			$this->uc_dev_login();
			$this->log($this->debug());
			if ( md5(md5($this->password).$this->salt) != $this->passwd ) return 3;
			$this->log("uc reg start:");
			$res = $UC->reg($this->username,$this->email,md5($this->password));
			$this->log("uc reg res:".print_r($res,true));
			if(!$res)return 5;
			if($res->error->code>0) return 3;
				//GF::MSG("用户系统升级出错，CODE:501",$this->url("updatereg","register"));//向UCENTER注册时用户名重复
			$this->huanid = $res->user->huanid;
			$sec = $UC->loggin($this->username,md5($this->password));
			if(!$sec)return 5;
			if($sec->error->code > 0)return 3;
			$this->token = $sec->user->token;
		}
		$this->log($this->debug());
		$this->uc_update_userinfo();
		$this->log($this->debug());
		if(!$this->active){
			$_SESSION['token'] = $this->token;
			$_SESSION['huanid'] = $this->huanid;
			$_SESSION['sess_devid'] = $this->uid;
			return 4;
		}
		if( !$this->uc_reg_bbs() ){
			return 6;
		}
		$this->syncuserstatus();
		$c_token = md5($this->uid.strtolower($username)."12esdf%refd");
		$this->scookie("token",$c_token,$this->C->MEMBER['expires']);
		$this->scookie("uid",$this->uid,$this->C->MEMBER['expires']);
		$this->scookie("username",$username,$this->C->MEMBER['expires']);
		return 0;
	}
	function syncuserstatus(){
		$obj = new stdClass();
		$obj->callid = GF::MT();
		$obj->devid = 0;
		$obj->devname = $this->username;
		$obj->huanid = $this->huanid;
		$obj->apiversion = "1.0";
		//查询是否老用户
		$Q = DB::Q("select * from developer where devname='{$this->username}'");
		if(DB::N($Q)>0){
			$O = DB::O($Q);
			if($O->memo!='sync')
				$obj->devid = $O->devid;
		}
		$config = Conf::INI(TTROOT."/config/gateway.ini");
		$c = new CURL($config['SERVER']['url'].'/developer/updateDevidByHuanid');

		$this->log("send data:".GF::JSON($obj));
		$s = $c->post(GF::JSON($obj));
		$ret = $c->info();
		$c->close();
		if( $ret['http_code'] != '200' ){
			$this->log("send data error:".$ret['http_code']);
		}
		$this->log("recv:".$s);
		$res = json_decode($s);
		$devstatus = 0;
		if(isset($res->state)){
			switch($res->state){
				case "0000":
					$devstatus = $res->devStatus;
					break;
				case "9018":
					$devstatus = '0';
					break;
			}
			$this->log("query devuser status succ:".$devstatus);
			DB::Q("update developer set memo='sync' where devname='{$this->username}'");
		}
		DB::Q("update ".UC_DBTABLEPRE."members set status='{$devstatus}' where huanid='{$this->huanid}'");
	}

	public function uc_dev_login(){
		$this->log("start dev login");
		$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where username='{$this->username}'");
		if ( DB::N($Q) < 1 ){
			$this->log("uc not user");
			$Q = DB::Q("select * from developer where devname='{$this->username}'");
			if(DB::N($Q)>0){
				$P = DB::O($Q);
				$this->log("dev has use id:".$P->devid);
				$this->passwd = $P->password;
				$this->status = $P->status;
				$this->huanid = '';
				$this->token  = '';
				$this->email  = $P->email;
				$this->salt   = $P->salt;
				$this->uid    = '';
			}else{
				$this->passwd = '';
				$this->status = '0';
				$this->huanid = '';
				$this->token  = '';
				$this->email  = '';
				$this->salt   = '';
				$this->uid    = '';
			}
		}else{
			$M = DB::O($Q);
			$this->log("uc has user id=".$M->uid);
			$this->passwd = $M->password;
			$this->status = $M->status;
			$this->huanid = $M->huanid;
			$this->token  = $M->token;
			$this->email  = $M->email;
			$this->salt   = $M->salt;
			$this->uid    = $M->uid;
		}

		if( !$this->uid ){
			$this->log("uid not ");
			$this->salt = $this->A->random(6,2);
			$pass = md5(md5($this->password).$this->salt);
			$sql = "insert ".UC_DBTABLEPRE."members(username,password,email,myid,myidkey,regip,regdate,lastloginip,lastlogintime,salt,secques,huanid,active,token,status,isclub) values('{$this->username}','{$pass}','{$this->email}','','','{$this->C->ClientIP}','{$this->C->AccTimes}','0','0','{$this->salt}','','{$this->huanid}','1','{$this->token}','{$this->status}','{$this->C->APP['clubid']}')";
			$Q = DB::Q($sql);
			$this->uid = DB::ID();
		}
		$this->log("pswd:".$this->passwd.";salt:".$this->salt.";");
		$this->log("exit dev login uid=".$this->uid);
		return 0;
	}
	public function uc_update_userinfo(){
		$this->log("start update user info");
		$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where huanid='{$this->huanid}'");
		if(DB::N($Q)<1){//本地无存储HUANID
			$this->log("huanid ====");
			$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where username='{$this->username}'");
			$this->active=0;
			if( DB::N($Q)>0 ){//检查USERNAME是否存在
				$OD = DB::O($Q);
				$pass = md5(md5($this->password).$OD->salt);
				if( $OD->password != $pass ) return 3;//检查密码是否正确
				$Q = DB::Q("select active from developer where devname='{$this->username}'");
				if(DB::N($Q)>0){
					$D = DB::O($Q);
					$this->active = $D->active;
				}
				DB::Q("update ".UC_DBTABLEPRE."members set password='{$pass}',huanid='{$this->huanid}',token='{$this->token}',email='{$this->email}',active='{$this->active}' where uid='{$OD->uid}'");
				$this->uid = $OD->uid;
				$this->userstatus=$OD->status;
				$this->salt = $OD->salt;
			}else{
				$this->log("localhost no username");
				$this->salt = $this->A->random(6,2);
				$pass = md5(md5($this->password).$salt);
				$sql = "insert ".UC_DBTABLEPRE."members(username,password,email,myid,myidkey,regip,regdate,lastloginip,lastlogintime,salt,secques,huanid,active,token,status,isclub) values('{$this->username}','{$pass}','{$this->email}','','','{$this->C->ClientIP}','{$this->C->AccTimes}','0','0','{$this->salt}','','{$this->huanid}','1','{$this->token}','0','{$this->C->APP['clubid']}')";
				$this->log("add user :".$sql);
				$Q = DB::Q($sql);
				$this->log($Q?"ss":"dd");
				$this->uid = DB::ID();
				$this->active=1;
				$this->userstatus='0';
			}
		}else{
			$this->log("has huanid");
			$O = DB::O($Q);
			$this->salt = $O->salt;
			$this->uid = $O->uid;
			$this->active = $O->active;
			$pass = md5(md5($this->password).$O->salt);
			$this->log($this->debug());
			$this->log("query active status form user:".$this->username);
			if(!$this->active){
				$Q = DB::Q("select active from developer where devname='{$this->username}'");
				if(DB::N($Q)>0){
					$D = DB::O($Q);
					$this->active = $D->active;
					$this->log("active status:".$this->active);
				}
			}
			if( strlen($O->huanid)>3 ){
				$sql = "update  ".UC_DBTABLEPRE."members set password='{$pass}',active='{$this->active}',email='{$this->email}',token='{$this->token}' where huanid='{$this->huanid}'";
			}else{
				$sql = "update  ".UC_DBTABLEPRE."members set password='{$pass}',email='{$this->email}',active='{$this->active}',token='{$this->token}',huanid='{$this->huanid}' where username='{$this->username}'";
			}
			$Q = DB::Q($sql);
			$this->userstatus=$O->status;
		}
		$this->log($this->debug());
		$this->log("exit update func,uid=".$this->uid);
	}
	public function uc_reg_bbs(){
		include_once($this->C->BBS['path']."/config/config_global.php");
		$this->bbsinfo = 0;
		$bbstbl = "`".$_config['db']['1']['dbname']."`.".$_config['db']['1']['tablepre'];
		$this->log("bbs query uid:".$this->uid);
		$B = DB::Q("select * from ".$bbstbl."common_member where uid='{$this->uid}' and username='{$this->username}'");
		if(DB::N($B)>0){
			return true;
		}else{
			$this->log("bbs no uid:".$this->uid);
			$BU = DB::Q("select * from ".$bbstbl."common_member where username='{$this->username}'");
			if( DB::N($BU)>0 ){
				$BD = DB::O($BU);
				$this->log("bbs has username=".$this->username);
				return $this->updateuid($BD);
			}else{
				$Q = DB::Q("select * from ".$bbstbl."common_member where uid='{$this->uid}'");
				if(DB::N($Q)>0){
					return false;
				}
			}
		}
		if($this->bbsinfo==0){
			$this->log("bbs reg user...");
			$sql = "insert into ".$bbstbl."common_member(uid,email,username,password,emailstatus,regdate) values('{$this->uid}','{$this->email}','{$this->username}','','1','{$this->C->AccTimes}')";
			DB::Q($sql);
			DB::Q("insert into ".$bbstbl."common_member_profile(uid,bio,interest,field1,field2,field3,field4,field5,field6,field7,field8) values('{$this->uid}','','','','','','','','','','')");
			DB::Q("insert into ".$bbstbl."common_member_status(uid,lastip,lastvisit) values('{$this->uid}','{$this->C->ClientIP}','{$this->C->AccTimes}')");
			DB::Q("insert into ".$bbstbl."common_member_count(uid) values('{$this->uid}')");
			DB::Q("insert into ".$bbstbl."common_member_field_forum(uid,medals,sightml,groupterms,groups) values('{$this->uid}','','','','')");
			DB::Q("insert into ".$bbstbl."common_member_field_home(uid,spacecss,blockposition,recentnote,spacenote,privacy,feedfriend,acceptemail,magicgift,stickblogs) values('{$this->uid}','','','','','','','','','')");
		}
		return true;
	}

	function updateuid($BD){
		$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where uid='{$BD->uid}'");
		if(DB::N($Q)<1){
			$this->log("updateuid no uid:".$BD->uid);
			$Q = DB::Q("update ".UC_DBTABLEPRE."members set uid='{$BD->uid}' where username like '{$BD->username}'");
			$this->uid = $BD->uid;
		}else{
			$this->log("updateuid has uid=".$BD->uid);
			return false;
		}
		return true;
	}
	function logout()
	{
		$this->scookie("uid",'',-1);
		$this->scookie("username",'',-1);
		$this->scookie("token",'',-1);
	}
	function loaduser($username='')
	{
		$where = $username==''?"uid='{$this->uid}'":"username='{$username}'";
		$q = DB::Q("select * from ".UC_DBTABLEPRE."members where ".$where);
		if ( DB::N($q) < 1 ) 
		{
			throw new Exception("system error:code 1".$where);
		}
		$this->U = DB::O($q);
		$this->obj($this->U);
		$sql  = "select * from ";
		$sql .= ($this->devtype=="0")?"indiextent":"comextent";
		$sql .= " where developerid='{$this->uid}'";

		$qe = DB::Q($sql);
		$this->obj(DB::O($qe),true);
	}

	function updatepasswd($password,$passwd,$passcp)
	{
		if( $passwd != $passcp ) return 1;
		$pw = md5(md5($password).$this->salt);
		$np = md5(md5($passwd).$this->salt);
		if ( $pw != $this->password ) return 2;
		$UC = new UserCenter($this->C);
		$res = $UC->updatepwd($this->U->huanid,$this->U->token,md5($password),md5($passwd));
		if($res->error->code>0)return 3;
		DB::Q("update ".UC_DBTABLEPRE."members set password='{$np}' where uid='{$this->uid}'");
		return 0;
	}
	function updateemail($password,$email){
		$pass = md5(md5($password).$this->U->salt);
		if($pass != $this->U->password )return 1;
		$UC = new UserCenter($this->C);
		$res = $UC->updateprofile($this->U->huanid,$this->U->token,"",$email);
		if($res->error->code>0)return 2;
		$Q = DB::Q("update ".UC_DBTABLEPRE."members set email='{$email}' where uid='{$this->uid}'");
		return 0;
	}
}
?>