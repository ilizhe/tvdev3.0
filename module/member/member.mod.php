<?php
if(!defined("MEMBER")) define("MEMBER",2);

class member extends GlobalClass {
	var $A;
	var $C;
	var $uid=0;
	var $verify=0;
	var $username='';
	function __construct(){
		parent::__construct();
		$this->msg='';
	}
	function check(){
		if(isset($_SESSION['sess_devid']) && $_SESSION['sess_devid']>'0')
			$this->uid = $_SESSION['sess_devid'];
		else
			GF::HD($this->url("loggin"));
	}
	function checkmem(){
		if( !$this->U->check() )GF::HD($this->url("loggin"));
	}
	
	function index(){
		$this->checkmem();
	}
	
	function init(){
		parent::init();
		T::A("loginurl",$this->url("loggin","member"));
		T::A("msg",$this->msg);
		T::A("formhash",$this->A->FormHash());
		T::A("frm",'');
		T::A("verify",isset($_SESSION['sess_login_error'])?$_SESSION['sess_login_error']:"");
		if( $this->U->check() ){
			if($this->C->PROJECT['closed']==1)GF::HD($this->url("logout","member",array('closed'=>1)));
			$this->uid = $this->U->uid;
			T::A("menu",$this->menu());
		}
	}
	function loginstate(){
		$ret = new stdClass();
		$ret->state = "logout";
		$str = '';
		if( $this->U->check() ){
			$ret->state = "login";
			$ret->uid = $this->U->devid;
			$ret->devname = $this->U->devtype=='0'?$this->U->username:$this->U->username;
			$str .= "devid='{$ret->uid}';\r\n";
			$str .= "devname='{$ret->devname}';\r\n";
		}
		$str .= "loginstate = '{$ret->state}';\r\n";
		$str .= "updateloginstate();\r\n";
		exit($str);
	}
	function logout(){
		$this->U->logout();
		$f = $this->A->Get("returnurl");
		$sync = uc_user_synlogout();
		$closed=$this->A->Get("closed");
		if($closed==1)
			GF::HD($this->url("loggin","member"));
		if( $f )
			GF::MSG("退出成功".$sync,GF::DeURL($f));
		else
			GF::MSG("退出成功".$sync,$this->url("loggin","member"));
	}
	function loggin(){
		if($this->C->PROJECT['closed']==1)GF::MSG($this->C->PROJECT['msg'],'','true',-1);
		$furl = $this->A->Get("returnurl");
		if( $furl != "" )$_SESSION["sess_returnurl"] = $furl;
		if( $_POST || $this->A->CheckForm($this->A->Post("formhash")) ){
			$frm='';
			$username = $this->A->Post("username_".$frm);
			$password = $this->A->Post("password_".$frm);
			$verifycd = $this->A->Post("verify_".$frm);
			$_SESSION['sess_username'] = $username;
			if( isset($_SESSION['sess_login_error']) && $_SESSION['sess_login_error']>3 ){
				if(isset($_SESSION['codeimgsrc']) && $verifycd != $_SESSION['codeimgsrc'] ){
					$this->msg  =  "验证码有误！";//.$verifycd;
					return ;
				}
			}

			unset($_SESSION['codeimgsrc']);
			try{
				$this->U = User::Cinit();
				$ret = $this->U->login($username,$password,false);
			}catch(Exception $e){
				exit('error :'.$e->getMessage());
			}
			switch($ret){
				case 0:
					$uu = '';
					unset($_SESSION['sess_login_error']);
					unset($_SESSION['sess_username']);
					if( isset($_SESSION["sess_returnurl"]) && $_SESSION["sess_returnurl"]){
						$uu = $_SESSION["sess_returnurl"];
						unset($_SESSION["sess_returnurl"]);
					}
					$sync = uc_user_synlogin($this->U->uid);
					$url = $uu==''?$this->url("index"):GF::DeURL($uu);
					GF::MSG($sync."登录成功",$url);
					break;
				case 4:
					$verify = md5($this->U->salt.$this->U->uid);
					$this->msg = "您的帐号尚未激活！您可以登录注册邮箱激活帐号！<br>	您可以<a href=\"".URL."?mod=register&act=resend&verify=".$verify."&id=".$this->U->uid."\" target=\"_blank\">重新发送激活邮件</a>或者<a href=\"".URL."?mod=member&act=emailchange\" target=\"_blank\">修改注册邮箱</a>";
					break;
				case 1:
					$this->msg = '请填写用户名和密码！ ';
					break;
				case 5:
					$this->msg = '系统故障！';
					break;
				case 2:
				case 3:
				default:
					$this->msg = "用户名或密码错误~！";
					isset($_SESSION["sess_login_error"])?$_SESSION["sess_login_error"]++:$_SESSION["sess_login_error"]=1;
					break;
			}
		}else{
			$furl = $this->A->Get("returnurl");
			if( $furl != "" )$_SESSION["sess_returnurl"] = $furl;
		}
	}
	function active(){
		$code = $this->A->Get("code");
		$Q = DB::Q("select * from emailcheck where code='{$code}'");
		if( DB::N($Q)<1 )GF::MSG("地址已经失效，请重新发送激活邮件",$this->url("loggin"));
		$o = DB::O($Q);
		if( $this->C->AccTimes - $o->edtime>86400 )GF::MSG("地址已经失效，请重新发送激活邮件!",$this->url("loggin"));
		if( $this->U->active == 0 ){
			DB::Q("update ".UC_DBTABLEPRE."members set active='1' where uid='{$o->devid}'");
		}else{
			DB::Q("update ".UC_DBTABLEPRE."members set email='{$o->email}' where uid='{$o->devid}'");
		}
		DB::Q("delete from emailcheck where devid='{$o->devid}'");
		GF::MSG("激活成功",$this->url("loggin"));
	}
	function repass(){
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$password = $this->A->Post("password");
			if(trim($password)=='')GF::MSG("请输入密码",$this->url("repass"));
			$passwd   = $this->A->Post("passwd");
			if(trim($passwd)=='')GF::MSG("请输入新密码",$this->url("repass"));
			$passwdcp = $this->A->Post("passwdcp");
			$msgArr = array('','二次输入的新密码不一致','原密码不正确');
			$ret = $this->U->updatepasswd($password,$passwd,$passwdcp);
			if($ret=="0")GF::MSG("修改成功",$this->url("index"));
			else
				GF::MSG($msgArr[$ret],$this->url("repass"));
		}
	}

	private function sendnote($email){
		$mailSET = $this->C->INI(TTROOT."/config/email.ini");
		$mailArr = $mailSET["EMAIL"];
		$exp = explode("@",$email);
		$mailserver = $mailexp = '';
		if( isset($exp[1]) ) $mailexp = strtolower($exp[1]);
		if( isset($mailArr[$mailexp]) )$mailserver = $mailArr[$mailexp];
		$subject='邮箱更改确认通知';
		$urls = $this->C->PROJECT['memberurl']."/?mod=member&act=active&code=".$code;
		$msg = '	<table style="width:700px;margin:0 auto;">
		<tr><td><img src="'.$this->C->PROJECT['memberurl'].'/templates/images/email.png" alt="智能电视开发者社区"/></td></tr>
		<tr><td>亲爱的 '.$this->U->username.' 您好！<td></tr>
		<tr><td>欢迎加入智能电视开发者社区！<td></tr>
		<tr><td>您在'.date('Y年m月d日',time()).' 申请了“邮箱更改”服务，现你在智能电视开发者社区帐户信息的Email地址将修改为'.$email.',请妥善保存，将来作为密码找回的凭证，谢谢<td></tr>
		<tr><td style="text-align: right;">智能电视开发者社区&nbsp;&nbsp;敬启</td></tr>
	</table>';
		$this->sendmail($email,$subject,$msg);
	}
	function emailchange(){
		$this->check();
		$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where uid='{$this->uid}'");
		if( DB::N($Q)<1 ) GF::MSG("您的登录已经超时，请重新登录",$this->url("loggin"));
		$U = DB::O($Q);
		$cm = 0;
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$email = $this->A->Post("email");
			$UC = new UserCenter($this->C);
			$res = $UC->updateprofile($_SESSION["huanid"],$_SESSION["token"],"",$email);
			if($res->error->code>0)GF::MSG($res->error->info,$this->url("emailchange"));

			DB::Q("update  ".UC_DBTABLEPRE."members set email='{$email}' where uid='{$this->uid}'");
			$s = new stdClass();
			$s->uid = $this->uid;
			$s->devname = $U->username;
			$s->email = $email;
			DB::Q("delete from emailcheck where devid='{$this->uid}'");
			$this->resendregmail($s);
			$cm=1;
			$this->msg = "修改成功";
			T::A("email",$email);
			T::A("U",$s);
			$verify = md5($U->salt.$this->uid);
			T::A('resendurl',$this->url("resend","register",array('id'=>$this->uid,'verify'=>$verify)));
		}else
			T::A("email",$U->email);
		T::A('cm',$cm);
	}


	public function resendregmail($U){
		$code = $this->A->random(8);
		$code = md5($U->uid.$this->C->SocketKey.$U->email.$this->C->AccTimes);
		$q = DB::Q("select * from emailcheck where devid='{$U->uid}'");
		if ( DB::N($q)>0 ){
			$o = DB::O($q);
			if($o->email !=$U->email){
				DB::Q("update emailcheck set email='{$U->email}', sdtime='{$this->C->AccTimes}',edtime='{$this->C->AccTimes}',code='{$code}',counts='1',dtime='{$this->C->AccTimes}' where devid='{$U->uid}'");
				$o->counts=1;
				$o->sdtime=$o->edtime=$o->dtime=$this->C->AccTimes;
			}
			if( ($this->C->AccTimes - 
				$o->sdtime ) > 86400){
				DB::Q("update emailcheck set sdtime='{$this->C->AccTimes}',edtime='{$this->C->AccTimes}',code='{$code}',counts='1',dtime='{$this->C->AccTimes}' where devid='{$U->uid}' and email='{$U->email}'");
			}else{
				if( $o->counts<3 ){
					DB::Q("update emailcheck set edtime='{$this->C->AccTimes}',code='{$code}',counts=counts+1,dtime='{$this->C->AccTimes}' where devid='{$U->uid}' and email='{$U->email}'");
				}else
				GF::MSG("抱歉，您在一天内最多只能重复发送 3 封邮件！",$this->url("","member"));
			}
		}else{
			DB::Q("insert emailcheck(devid,email,code,sdtime,edtime,counts,dtime) values ('{$U->uid}','{$U->email}','{$code}','{$this->C->AccTimes}','{$this->C->AccTimes}','1','{$this->C->AccTimes}')");
		}

		$mailSET = $this->C->INI(TTROOT."/config/email.ini");
		$mailArr = $mailSET["EMAIL"];
		$exp = explode("@",$U->email);
		$mailserver = $mailexp = '';
		if( isset($exp[1]) ) $mailexp = strtolower($exp[1]);
		if( isset($mailArr[$mailexp]) )$mailserver = $mailArr[$mailexp];
		$subject=$mailSET['ACTIVE']['SUBJECT'];
		$urls = $this->C->PROJECT['memberurl']."/?mod=member&act=active&code=".$code;
		$msg = '	<table style="width:700px;margin:0 auto;">
		<tr><td><img src="'.$this->C->PROJECT['siteurl'].'/images/email.png" alt="智能电视开发者社区"/></td></tr>
		<tr><td>亲爱的'.$U->devname.'：<td></tr>
		<tr><td>欢迎加入智能电视开发者社区！<td></tr>
		<tr><td>请点击以下链接激活账号：<td></tr>
		<tr><td><a href="'.$urls.'" style="color: #0653bd;">'.$urls.'</a><td></tr>
		<tr><td>(如果链接无法点击，请将它拷贝到浏览器的地址栏中)</td></tr>
		<tr><td style="text-align: right;">智能电视开发者社区&nbsp;&nbsp;敬启</td></tr>
	</table>';
		$this->sendmail($U->email,$subject,$msg);
		T::A("mailserver",$mailserver);
		T::A("U",$U);
		T::A('email','');
		
	}
	function email(){
		T::A('email',$this->U->email);
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$password = $this->A->Post("password");
			$email = $this->A->Post("email");
			if(trim($password)=='')GF::MSG("请输入密码",$this->url("email"));
			if(trim($email)=='')GF::MSG("请输入新邮箱",$this->url("email"));
			if(! $this->valid_email($email))GF::MSG("邮箱格式不正确",$this->url("email"));
			$ret = $this->U->updateemail($password,$email);
			$retMsg = array('','密码错误','相同的EMAIL地址已经存在');
			if( $ret ) GF::MSG(isset($retMsg[$ret])?$retMsg[$ret]:"未知错误：".$ret,$this->url("email"));
			$this->sendnote($email);
			GF::MSG("修改成功",$this->url("index"));
		}
	}
	
	function select(){
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$type = $this->A->Post("type");
			switch($type){
				case "0":
					$Q = DB::Q("select * from comextent where developerid='{$this->U->uid}'");
					if( DB::N($Q)>0 ) GF::MSG("您已经选择了开发商，无法更改成为开发者",$this->url("info","company"));
					DB::Q("update ".UC_DBTABLEPRE."members set devtype='{$type}' where uid='{$this->U->uid}'");
					$Q = DB::Q("select * from indiextent where developerid='{$this->U->uid}'");
					if( DB::N($Q)<1 ) DB::Q("insert indiextent(developerid) values ('{$this->U->uid}')");
					GF::HD($this->url("info","person"));
					break;
				case "1":
					$Q = DB::Q("select * from indiextent where developerid='{$this->U->uid}'");
					if( DB::N($Q)>0 ) GF::MSG("您已经选择了开发者，无法更改为开发商",$this->url("info","person"));
					DB::Q("update ".UC_DBTABLEPRE."members set devtype='{$type}' where uid='{$this->U->uid}'");
					$Q = DB::Q("select * from comextent where developerid='{$this->U->uid}'");
					if( DB::N($Q)<1 ) DB::Q("insert comextent(developerid) values ('{$this->U->uid}')");
					GF::HD($this->url("info","company"));
					break;
				case "2":GF::HD($this->url("active","personclub"));
					break;
				case "3":GF::HD($this->url("active","compclub"));
					break;
				default:
					GF::MSG("数据错误",$this->url("select"));
					break;
			}
		}else{
			if($this->U->devtype != '-1'){
				GF::HD($this->url("upgradeinfo",$this->U->devtype==1?"company":"person"));
			}
		}
	}

	public function valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

}

?>