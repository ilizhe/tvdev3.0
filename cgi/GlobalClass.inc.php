<?php
class GlobalClass{
	var $C;
	var $A;
	function __construct(){
		global $CONF,$ARGV;
		$this->A = $ARGV;
		$this->C = $CONF;
		$this->U = User::Cinit();
		$uid = 0;
		$username='';
		$userinfo='';
		if($this->U->uid>0 && $this->U->check()){
			$uid = $this->U->uid;
			$username = $this->U->username;
			$userstatus = $this->U->status==800?1:0;
			$userinfo->name = $this->U->name;
			$userinfo->mobile = $this->U->mobile;
		}
		T::A('uid',$uid);
		T::A('username',$username);
		T::A('userstatus',$userstatus);
		T::A('userinfo',$userinfo);
		T::A('loginurl','?mod=member&act=loggin');

	}
	public function init(){
		$appstore=AppStore::init($this->C);
		$rows=$appstore->getHuanHelp('tvdev_help_1',1);
		T::A('rows',$rows->about);
		T::A('bbname',$rows->bbname);
		T::A('keywords',str_replace('|',',',$rows->bbname));
	}
	public function obj($o,$tp=false){
		if(empty($o))return false;
		foreach($o as $k => $v){
			if(isset($this->$k) && $tp ) continue;
			$this->$k = $v;
		}
	}

	public function initmemcache(){
		$this->MC = new Memcache();
		$ret = @$this->MC->connect($this->C->MEMCACHE['host'],$this->C->MEMCACHE['port']);
		if( $ret === false )throw new exception("connect memcached server failed!");
	}
	public function mset($key,$val,$expires=0){
		return $this->MC->set($key,serialize($val),0,$expires>0?$expires:$this->C->MEMCACHE['expires']);
	}
	public function mkey($key){
		return @$this->MC->add($key,'true');
	}
	public function mget($key){
		$ret = $this->MC->get($key);
		if( !$ret ) return false;
		$ret = unserialize($ret);
//		$this->R = json_last_error();
//		if($this->R != JSON_ERROR_NONE ) throw new exception("json decode error:".$this->R.print_r($ret,true));
		return $ret;
	}
	public function mdel($key){
		return $this->MC->delete($key);
	}
	public function scookie($key,$val,$expires=0){
		setcookie($key,$val,$expires==0?0:(time()+$expires),'/',$this->C->PROJECT['host'],false,false);
	}
	public function getClientType(){
		$data = '{"action":"GetDevBrandList"}';
		$ret = $this->sendex($data,$this->C->GW['SERVER']['deviceuri']);

	}
	public function getucenterid($username){
		include_once(TTROOT."/config/ucenter.inc.php");
		$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where username='{$username}'");
		if( DB::N($Q)<1 )return 0;
		$O = DB::O($Q);
		return $O->uid;
	}
	public function menu(){
		$ret = array();
		$e=-1;
		if( isset($this->uid) && isset($this->U->active) && $this->uid && $this->U->active == '1'){
			if($this->U->devtype == '0'){
				$ret[++$e] = array('title'=>'我的资料','mod'=>'person','subc'=>array());
				$ret[$e]['subc']['info']="基本资料修改";
				$ret[$e]['subc']['info']="基本资料修改";
				if( $this->U->status>'0' ){
					switch($this->U->status){
						case "800":
							$ret[$e]['subc']['bankinfo'] = '支付信息修改';
							$ret[$e]['subc']['upgrade'] = "签约资料";
							break;
						case "300":
							$ret[$e]['subc']['upgrade'] = "签约资料";
							$ret[$e]['subc']['upgradeinfo'] = "申请签约";
							break;
						case "500":
						case "400":
						case "200":
							$ret[$e]['subc']['upgrade'] = "签约资料";
							break;
					}
				}else
					$ret[$e]['subc']['upgradeinfo'] = '申请签约';
			}
			if($this->U->devtype == '1'){
				$ret[++$e] = array('title'=>'我的资料','mod'=>'company','subc'=>array());
				$ret[$e]['subc']['info']="基本资料修改";
				if( $this->U->status>'0' ){
					switch($this->U->status){
						case "800":
							$ret[$e]['subc']['bankinfo'] = '支付信息修改';
							$ret[$e]['subc']['upgrade'] = "签约资料";
							break;
						case "300":
							$ret[$e]['subc']['upgrade'] = "签约资料";
							$ret[$e]['subc']['upgradeinfo'] = "申请签约";
							break;
						case "500":
						case "400":
						case "200":
							$ret[$e]['subc']['upgrade'] = "签约资料";
							break;
					}

				}else
					$ret[$e]['subc']['upgradeinfo'] = '申请签约';
			}
			if($this->U->devtype == '-1')
			{
			$ret[++$e] = array('title'=>'我的资料','mod'=>'member','subc'=>array());
			$ret[$e]['subc']['select'] ="申请签约";
			}

			$ret[++$e] = array('title'=>'APPKEY管理','mod'=>'appkey','subc'=>array());
			$ret[$e]['subc']['appexplain'] = '申请appkey';
			$ret[$e]['subc']['appkeymanage'] = 'appkey管理';

			$ret[++$e] = array('title'=>'我的应用','mod'=>'app','subc'=>array());
			$ret[$e]['subc']['newapp'] = '提交作品';
			$ret[$e]['subc']['myapp'] = "待审核作品";
			$ret[$e]['subc']['testing'] = "审核中作品";
			$ret[$e]['subc']['myback'] = "打回的作品";
			$ret[$e]['subc']['online'] = "已上线作品";
			$ret[$e]['subc']['offapp'] = "申请下线作品";
			$ret[$e]['subc']['offline'] = "已下线作品";

			$ret[++$e] = array('title'=>'工具','mod'=>'tools','subc'=>array());
			$ret[$e]['subc']['config'] = '模拟器配置文件';

			$ret[++$e] = array('title'=>'系统安全','mod'=>'member','subc'=>array());
			$ret[$e]['subc']['email'] = '修改邮箱';
			$ret[$e]['subc']['repass'] = '修改密码';
			$ret[$e]['subc']['logout'] = '安全退出';
		}else{
			$ret[++$e] = array('title'=>'系统安全','mod'=>'member','subc'=>array());
			if( $this->U->active != 1 )
				$ret[$e]['subc']['resend'] = '重发激活邮件';
			$ret[$e]['subc']['email'] = '修改邮箱';
			//$ret[$e]['subc']['repass'] = '修改密码';
			$ret[$e]['subc']['logout'] = '安全退出';
		}
		$this->menuArr = $ret;
		return $ret;
	}
	public function url($act,$mod='',$argv=array()){
		$u  = URL."?mod=";
		$u .= ($mod=='')?MODULE:$mod;
		$u .= "&act=".$act;
		foreach($argv as $k => $v){
			$u .= "&".$k."=".$v; 
		}
		return $u;
	}
	public function verify(){
		$code = $this->A->Post("verify");
		$s = isset($_SESSION['codeimgsrc'])?$_SESSION['codeimgsrc']:'';
		if( !$s )
			return false;
		if( $code != $s ){
			unset($_SESSION['codeimgsrc']);
			return false;
		}
		return true;
	}

	public function gateway($uid){
		$Q = DB::Q("select *,huanid as devid,username as devname from ".UC_DBTABLEPRE."members where uid='{$uid}'");
		if( DB::N($Q)< 1 ) return false;
		$obj = DB::O($Q);
		$obj->tasktype="upgrade";
		$s = DB::Q("select * from ".($obj->devtype==0?"`indiextent`":"`comextent`")." where `developerid`='{$obj->uid}'");
		if( DB::N($s) < 1 ) return false;
		if( $obj->devtype == 0 ){
			$obj->indiDetailExtent = DB::O($s);
			$obj->indiDetailExtent->address = $obj->indiDetailExtent->pctaddr . $obj->indiDetailExtent->address;
			$obj->mobile = $obj->indiDetailExtent->mobile;
		}else{
			$obj->comDetailExtent = DB::O($s);
			$obj->comDetailExtent->address = $obj->comDetailExtent->pctaddr . $obj->comDetailExtent->address;
			$obj->mobile = $obj->comDetailExtent->mobile;
		}
		return $obj;
	}
	
	public function sendmail($email,$subject,$msg,$from='',$mailtype='HTML'){
		$S = new SMTP($this->C->email['server'],$this->C->email['port'],true,$this->C->email['user'],$this->C->email['pass'],$this->C->email['helo'],$this->C->email['log'],$this->C->email['debug']);
		$ret = $S->sendmail($email,$from==''?$this->C->email['from']:$from,$subject,$msg,$mailtype);
	}
}
?>