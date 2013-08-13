<?php
class GlobalMember extends GlobalClass{
	var $loginstate;
	public function __construct(){
		parent::__construct();
		if($this->C->PROJECT['closed']==1)GF::HD($this->url('logout','member',array('closed'=>1)));
		try{
			if(ACTION != "loggin"){
				if( !$this->U->check() )
					GF::HD($this->url("loggin","member"));

				if( $this->U->uid ){
					$this->uid = $this->U->uid;
				}

			}
			$this->loginstate="login";
			T::A("menu",$this->menu());
			T::A("nav",$this->menucur(ACTION));
			$s=parse_ini_file(TTROOT."/config/gateway.ini",true);
			T::A('remoteuploadurl',$s['SERVER']['url'].'/upload/developer/uploadfile');
		}catch(exception $e){
			exit($e->getMessage());
			GF::HD($this->url("loggin","member"));
		}
	}
	public function init($act,$mod){
		parent::init();
		T::A("frm",$this->A->mkFRM(true));
		T::A("formhash",$this->A->FormHash());
		T::A("wwwurl",$this->C->PROJECT['memberurl']);
		T::A("loginstate",$this->loginstate);
		T::A("devid",$this->uid);
		T::A("devname",$this->U->username);
	}

	public function memstate($state){
		$sarr = array('0'=>'未签约','200'=>'申请签约','800'=>'已签约','300'=>'未通过签约','400'=>'注销','500'=>'暂停');
		if( isset($sarr[$state]) )
			return $sarr[$state];
		else
			return '未知状态:'.$state;
	}


	public function menucur($act){
		$ret = new stdClass();
		$ret->title = '会员中心';
		$ret->sub = '首页';
		$ret->act = '';
		foreach($this->menuArr as $m){
			foreach($m['subc'] as $href => $title){
				if( $href == $act ){
					$ret->title = $m['title'];
					$ret->sub  = $title;
					$ret->act = $href;
					break;
				}
			}
		}
		return $ret;
	}


	public function repass(){
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$frm = $this->A->mkFRM();
			$passeold = $this->A->Post("passeold_".$frm);
			$password = $this->A->Post("password_".$frm);
			$passwdcp = $this->A->Post("passwdcp_".$frm);
			if( !$passeold ) GF::MSG("请填写原密码","back");
			if(!$password || !$passwdcp) GF::MSG("请填写新密码",$this->url("repass"));
			if( $password != $passwdcp ) GF::MSG("新填写的新密码不一致",$this->url("repass"));
			$o = $this->U->updatepasswd($passeold,$password,$passwdcp);
			$oArr = array("修改成功","二次输入的新密码不一致","原密码错误");
			if( $o == "0" )
				GF::MSG("修改成功",$this->url('repass'));
			else
				GF::MSG($oArr[$o]."_".$o,$this->url('repass'));
		}
	}
	public function emailchange(){
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$email = $this->A->Post("email");
			if( !$this->A->check($email,"email") )
				GF::MSG("邮箱格式不正确",$this->url("emailchange"));
			$tbl = ($this->U->devtype==0)?"indiextent":"comextent";

			$Q = DB::Q("select * from indiextent where email='{$email}'");
			if( DB::N($Q)>0 )GF::MSG("新邮箱已经被使用，请换一个",$this->url("emailchange"));

			$Q = DB::Q("select * from comextent where email='{$email}'");
			if( DB::N($Q)>0 )GF::MSG("新邮箱已经被使用，请换一个",$this->url("emailchange"));

			DB::Q("update developer set active='0' where devid='{$this->uid}'");
			DB::Q("update {$tbl} set email='{$email}' where developerid='{$this->uid}'");
			GF::MSG("请验证您的新邮箱",$this->url("resend"));
		}
	}

	public function index(){
	/*	if($this->U->devtype == "-1"){
			GF::MSG("您的会员类型还未确定，请选择",$this->url("select"));
		} */
		if($this->U->active != 1){
			$this->sendmail($this->uid,$this->U->devname,$this->U->email);
			GF::MSG("您的邮箱还未激活，请您先激活邮箱",$this->url("active"));
		}
	}
	/* public function select(){
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$membertype = $this->A->Post("membertype");
			if($membertype == "")
			{
				GF::MSG("请选择会员类型","back");
			}
			$Q = DB::Q("select * from developer where devid = '{$this->uid}'");
			$O = DB::O($Q);
			$email = $O->email;
			if($membertype == 0)
			{
				$sql = "insert indiextent(developerid,email) value('{$this->uid}','{$email}')";
				if(DB::Q($sql))
					$s = "update developer set devtype='0' where devid = '{$this->uid}'";
					DB::Q($s);
					GF::MSG("已选择会员类型，请填写详细资料",$this->url(""));
			}
			if($membertype == 1)
			{
				$sqle = "insert comextent(developerid,email) value('{$this->uid}','{$email}')";
				if(DB::Q($sqle))
					$sq = "update developer set devtype='1' where devid = '{$this->uid}'";
					DB::Q($sq);
					GF::MSG("已选择会员类型，请填写详细资料",$this->url(""));
			}

		}
	}*/

	public function active(){
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$frm = $this->A->mkFRM();
			$code = $this->A->Post("code_".$frm);
			$q = DB::Q("select * from emailcheck where devid='{$this->uid}'");
			if( DB::N($q)<1 )
				GF::MSG("数据错误，请重新激活",$this->url("resend"));
			$o = DB::O($q);
			if( $this->C->AccTimes - $o->dtime > 7200 )
				GF::MSG("您的验证码已经过期，请重新发送",$this->url("resend"));
			if( $o->code == $code ){
				DB::Q("delete from emailcheck where devid='{$this->uid}'");
				DB::Q("update developer set active='1' where devid='{$this->uid}'");
				GF::MSG("激活成功",$this->url("info"));
			}else{
				if( $o->err>4 )
					GF::MSG("错误次数太多，请重新发送验证码",$this->url("resend"));
				DB::Q("update emailcheck set err=err+1 where devid='{$this->uid}'");
				GF::MSG("验证码错误，请重新输入！",$this->url("active"));
			}
		}else{
			T::A("U",$this->U);
		}
	}

}
?>
