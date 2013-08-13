<?php
if(!defined('REGISTER'))define('REGISTER','1');

class register extends GlobalClass{

	function init(){
		parent::init();
		T::A("formhash",$this->A->FormHash());
		T::A("frm",$this->A->mkFRM(true));
	}

	function index(){
		if($this->C->PROJECT['closed']==1)GF::MSG($this->C->PROJECT['msg'],'','true',-1);
	}
	function testing(){
		global $ARGV,$CONF;
		$type = $ARGV->Get("type");
		$data = $ARGV->Get("value");
		$ret = 0;
		include_once( TTROOT."/config/ucenter.inc.php" );
		if( $type == '1' ){
			$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where username='{$data}'");
			if( DB::N($Q)>0 ){
				exit("相同的用户名已经存在");
			}
		}
		if( $type == '3' ){
			$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where email='{$data}'");
			if( DB::N($Q)>0 ){
				exit("相同的邮箱已经存在");
			}
		}
		if( $type == "4" ){
			exit(( $data != $_SESSION["codeimgsrc"] )?"验证码错误":'0');
		}

		$UC = new UserCenter($CONF);
		$s = $UC->test($data,$type);
		if($s->error->code > 0 )exit($s->error->info);
		$ret = $s->result;
		if($ret===1)$ret='相同的 '.($type==1?'用户名':'邮箱')." 已经存在";
		if($ret==='')$ret='邮箱地址格式不正确';
		exit((string)$ret."");
	}
	function preson(){
	}
	function company(){
	}
	function reg(){
		global $ARGV,$CONF;
		$verifyimg= $ARGV->Post("verifyimg");
		if( $verifyimg != $_SESSION["codeimgsrc"] )
			GF::MSG("您输入的验证码不正确！","back");
		$devname = $ARGV->Post("devname");
		if( !$ARGV->check($devname,"username")  )
			GF::MSG("用户名不符合规范","back");
		$password = $ARGV->Post("password");
		$passwdcp = $ARGV->Post("passwdcp");
		if( $password == "" )
			GF::MSG("请输入密码！","back");
		if( $password != $passwdcp )
			GF::MSG("二次输入的密码不一致！","back");
		$passwd   = md5($password);
		$email    = $ARGV->Post("email");
		$salt = $this->A->random(6,2);
		$pass = md5($passwd.$salt);
		$UC = new UserCenter($CONF);
		$ret = $UC->reg($devname,$email,$passwd);
		$reg='0';
		if( $ret->error->code == 0 ){
			include_once( TTROOT."/config/ucenter.inc.php" );
			$sqlu = "insert ".UC_DBTABLEPRE."members(username,password,email,myid,myidkey,regip,regdate,lastloginip,lastlogintime,salt,secques,huanid,isclub) values('{$devname}','{$pass}','{$email}','','','{$CONF->ClientIP}','{$CONF->AccTimes}','0','0','{$salt}','','{$ret->user->huanid}','{$this->C->APP['clubid']}')";
			$Q = DB::Q($sqlu);
			if( $Q ){
				$devid = DB::ID();
				$reg='1';
				$U = new stdClass();
				$U->devname = $devname;
				$U->email = $email;
				$U->uid = $devid;
				$this->resendregmail($U);
				T::A('U',$U);
				T::A('resendurl',$this->url("resend",'',array('id'=>$devid,'verify'=>md5($salt.$devid))));
			}else{
				GF::MSG("注册出错，请联系管理员。CODE：0210");
			}
		}else{
			GF::MSG($ret->error->info,$this->url(""));
		}
		T::A("loginurl",$this->url("loggin","member"));
		T::A("regsuccess",$reg);
	}

	function resend(){
		$verify = $this->A->Get("verify");
		$devid = $this->A->Get("id");
		$random = $this->A->Get("rand");
		try{
			$U = User::Cinit();
			$U->uid = $devid;
			$U->loaduser();
		}catch(Exception $e){
			GF::MSG("用户数据读取出错:".$e->getMessage());
		}

		T::A("U",$U);
		if($verify == md5($U->salt.$devid)){
			if($U->active==1)GF::MSG("您的账号已经激活，请登录",$this->url("loggin","member"));
			$this->resendregmail($U);
		}
	}

	function resetpass(){
		if(!isset($_SESSION['lostpass']) || !$_SESSION['lostpass'])GF::MSG("页面超时，请重新操作",$this->url("lostpass"));
		if($_POST){
			$verifycode = $this->A->Post("verifycode");
			$passwd = $this->A->Post("passwd");
			$passcp = $this->A->Post("passcp");
			if( !$verifycode )GF::MSG("请填写验证码",$this->url("resetpass"));
			if( !$passwd || !$passcp )GF::MSG("请填写新密码",$this->url("resetpass"));
			if( $passwd != $passcp ) GF::MSG("二次输入的新密码不一致" , $this->url("resetpass"));
			$UC = new UserCenter($this->C);
			$res = $UC->resetpass($_SESSION['lostpass'],$verifycode,md5($passwd));
			if($res->error->code > 0 )GF::MSG($res->error->info,$this->url("resetpass"));
			GF::MSG("密码重置成功",$this->url("loggin","member"));
		}
	}

	function lostpass(){
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$username = $this->A->Post("muser");
			$email = $this->A->Post("email");
			$verifyimg = $this->A->Post("verifyimg");
			if( $verifyimg != $_SESSION['codeimgsrc'] )GF::MSG("验证码错误",$this->url("lostpass"));
			try{
				$UC = new UserCenter($this->C);
				$res = $UC->lostpass($username,$email);
				if($res->error->code > 0 ){
					$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where username='{$username}' and email='{$email}'");
					if(DB::N($Q)<1){
						$W = DB::Q("select *,devid as uid,devname as username from developer where devname='{$username}' and email='{$email}'");
						if(DB::N($W)<1){
							GF::MSG("此账户不存在 ",$this->url("lostpass"));
						}
						$L = DB::O($W);
					}else{
						$L = DB::O($Q);
					}
					if($L->email == $email){
						$this->resendpswmail($L);
						T::A('a','a');
//						GF::MSG("操作成功，已经给您的邮箱发送了邮件，请登录邮箱查收");
					}else{
						GF::MSG($res->error->info,$this->url("lostpass"));
					}
				}else{
					$_SESSION['lostpass'] = $username;
					GF::MSG("操作成功，已经给您的邮箱发送了验证码，请登录邮箱查收",$this->url("resetpass"));
				}
			}catch(Exception $e){
				GF::MSG("用户数据读取出错:".$e->getMessage());
			}
		}else
			T::A("msg","");
	}
	function checkverify(){
		if($_POST){
			$passwd = $this->A->Post("passwd");
			$passcp = $this->A->Post("passcp");
			$verify = $this->A->Post("verify");
			if(!$verify)GF::HD($this->url("lostpass"));
			if(!$passwd || !$passcp)GF::MSG("请填写新密码",$this->url("checkverify",'',array('code'=>$verify)));
			if( $passwd != $passcp )GF::MSG("二次填写的新密码不一致",$this->url("checkverify",'',array('code'=>$verify)));
			$Q = DB::Q("select * from emailcheck where code='{$verify}'");
			if( DB::N($Q) < 1 )GF::MSG("连接1已经失效",$this->url("lostpass"));
			$O = DB::O($Q);
			if( $this->C->AccTimes - $O->edtime>86400 )GF::MSG("连接4 已经失效，请重新发送激活邮件!",$this->url("lostpass"));
			$pass = md5($passwd);
			$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where uid='{$O->devid}'");
			$res = 0;
			if(DB::N($Q)>0){
				$O = DB::O($Q);
				$pw = md5($pass.$O->salt);
				DB::Q("update  ".UC_DBTABLEPRE."members set password='{$pw}' where uid='{$O->uid}'");
				$res++;
			}
			$Q = DB::Q("select * from developer where devid='{$O->devid}'");
			if(DB::N($Q)>0){
				$O = DB::O($Q);
				$pw = md5($pass.$O->salt);
				DB::Q("update developer set password='{$pw}' where devid='{$O->devid}'");
				$res++;
			}
			if($res>0){
				DB::Q("delete from emailcheck where code='{$verify}'");
				GF::MSG("密码重置成功",$this->url("loggin","member"));
			}
		}else{
			$code = $this->A->Get("code");
			if(!$code)GF::HD($this->url("lostpass"));
			$Q = DB::Q("select * from emailcheck where code='{$code}'");
			if( DB::N($Q) < 1 )GF::MSG("连接2已经失效",$this->url("lostpass"));
			$O = DB::O($Q);
			if( $this->C->AccTimes - $O->edtime>86400 )GF::MSG("连接3 已经失效，请重新发送激活邮件!",$this->url("lostpass"));
			T::A('verify',$code);
		}
	}

	function resendpswmail($U){
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
				GF::MSG("抱歉，您在一天内最多只能重复发送 3 封邮件！",$this->url("lostpass"));
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
		$subject='开发者社区重置密码';
		$urls = $this->C->PROJECT['memberurl']."/?mod=register&act=checkverify&code=".$code;
		$msg = '	<table style="width:700px;margin:0 auto;">
		<tr><td><img src="'.$this->C->PROJECT['memberurl'].'/templates/images/email.png" alt="智能电视开发者社区"/></td></tr>
		<tr><td>亲爱的'.$U->username.'：<td></tr>
		<tr><td>欢迎加入智能电视开发者社区！<td></tr>
		<tr><td>请点击以下链接重置密码：<td></tr>
		<tr><td><a href="'.$urls.'" style="color: #0653bd;">'.$urls.'</a><td></tr>
		<tr><td>(如果链接无法点击，请将它拷贝到浏览器的地址栏中)</td></tr>
		<tr><td style="text-align: right;">智能电视开发者社区&nbsp;&nbsp;敬启</td></tr>
	</table>';
		$this->sendmail($U->email,$subject,$msg);
		T::A("mailserver",$mailserver);
		T::A("U",$U);
		T::A('email','');
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
		<tr><td><img src="'.$this->C->PROJECT['memberurl'].'/templates/images/email.png" alt="智能电视开发者社区"/></td></tr>
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
	function activecode(){
		$code = $this->A->Get("code");
		$Q = DB::Q("select * from emailcheck where code='{$code}'");
		if( DB::N($Q)<1 )GF::MSG("地址1已经失效，请重新发送激活邮件",$this->url("lostpass"));
		$o = DB::O($Q);
		if( $this->C->AccTimes - $o->edtime>86400 )GF::MSG("地址2已经失效，请重新发送激活邮件!",$this->url("lostpass"));
		$_SESSION["sess_uid"] = $o->devid;
		$_SESSION['sess_lostpass'] = $this->C->AccTimes;
		DB::Q("delete from emailcheck where code='{$code}'");
		GF::HD($this->url("updatepass",'',array('verify'=>md5($o->devid.$this->C->AccTimes))));
	}
	function updatepass(){
		if(!isset($_SESSION["sess_uid"]) || !isset($_SESSION['sess_lostpass']))GF::MSG("操作有误 CODE:3001",$this->url("lostpass"));
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$verify = $this->A->Post("verifyimg");
			if( $verify != $_SESSION['codeimgsrc'] )GF::MSG("验证码错误",$this->url("updatepass"));
			if( !isset($_SESSION["sess_uid"]) || !$_SESSION["sess_uid"] ) GF::MSG("地址3已经失效，请重新发送激活邮件!",$this->url("lostpass"));
			$passwd = $this->A->Post("passwd");
			$passcp = $this->A->Post("passwdcp");
			if( $passwd != $passcp ) GF::MSG("二次新密码不一致，请重新输入",$this->url("updatepass"));
			try{
				$U = User::Cinit();
				$U->uid = $_SESSION['sess_uid'];
				$U->loaduser();
				$res = $U->updatepasswd($passwd);

				unset($_SESSION['sess_uid']);
				unset($_SESSION['sess_lostpass']);
				GF::MSG("密码重置成功，请使用新密码登录",$this->url("loggin","member"));
			}catch(Exception $e){
				unset($_SESSION['sess_uid']);
				unset($_SESSION['sess_lostpass']);
				GF::MSG("取回密码操作出错，请联系管理员 CODE:4010");
			}
		}else{
			$verify = $this->A->Get("verify");
			if( $verify != md5($_SESSION["sess_uid"].$_SESSION['sess_lostpass']) )GF::MSG("操作超时，请重新取回密码",$this->url("lostpass"));
		}
	}

	function mailto($email){
	
	}
}
?>