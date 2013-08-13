<?php
class UserCenter{
	var $C;
	var $fp = null;
	var $CL;
	function __construct($C,$log='../log/usercenter.log'){
		$this->C = $C;
		$this->CL = new CURL($this->C->UC['urls']);
	}

	private function post($json){
		$res = $this->CL->post($json);
		$s = json_decode($res);
		if(!$s)return false;
		return $s;
	}
	private function https($json){
		$this->CL->set(CURLOPT_URL,$this->C->UC['urls']);
		$this->CL->set(CURLOPT_SSL_VERIFYPEER,false);
		$this->CL->set(CURLOPT_SSL_VERIFYHOST,false);
		return $this->post($json);
	}
	private function http($json){
		$this->CL->set(CURLOPT_URL,$this->C->UC['url']);
		return $this->post($json);
	}
	public function test($input,$type='1'){
		$json = '{"action":"CheckRegAvailable","user":{"input":"'.$input.'","type":"'.$type.'","huanid":""}}';
		return $this->https($json);
	}
	public function reg($username,$email,$pwd,$mobile='',$verifycode='',$phone='',$nickname='',$avatarid=1,$gender=1,$loginstatus=1,$birthday=''){
		$json = '{"action":"UserRegisterTC","locale":"zh_CN","device":{"devinfo":"'.$this->C->UC['devinfo'].'"},"user":{"pwd":"'.$pwd.'","phone":"'.$phone.'","mogile":"'.$mobile.'","logname":"'.$username.'","nickname":"'.$nickname.'","avatarid":"'.$avatarid.'","gender":"'.$gender.'","birthday":"'.$birthday.'","email":"'.$email.'","loginstatus":"'.$loginstatus.'","verifycode":"'.$verifycode.'"}}';
		return $this->https($json);
	}
	public function loggin($username,$pwd,$logintype=2){
		$json = '{"action":"UserLoginMT","device":{"dnum":"","didtoken":""},"user":{"logintype":'.$logintype.',"loginput":"'.$username.'","pwd":"'.$pwd.'","holdhuanid":0,"holdpwd":0,"autologin":0,"loginstatus":1}}';
		return $this->https($json);
	}
	public function getinfo($huanid,$token){
		$json = '{"action":"GetUserInfo","user":{"huanid":"'.$huanid.'","token":"'.$token.'"}}';
		return $this->http($json);
	}
	public function updatepwd($huanid,$token,$oldpass,$passwd){
		$json = '{"action":"UpdateUserPassword","user":{"huanid":"'.$huanid.'","token":"'.$token.'"},"param":{"oldpwd":"'.$oldpass.'","newpwd":"'.$passwd.'"}}';
		return $this->https($json);
	}
	public function updateprofile($huanid,$token,$username,$email){
		$s = new stdClass();
		$s->action = "UpdateUserProfile";
		$s->user = new stdClass();
		$s->user->huanid = $huanid;
		$s->user->token = $token;
		$p = new stdClass();
		$p->avatarid=0;
		$p->logname=$username;
		$p->nickname='';
		$p->gender=1;
		$p->birthday='';
		$p->mobile=0;
		$p->phone='';
		$p->email=$email;
		$p->sign='';
		$p->homeaddr='';
		$p->hobby='';
		$p->realname='';
		$p->citizenid='';
		$p->verifycode='';
		$p->otheraddr=array();
		$p->othercontact=array();
		$s->param = $p;
		return $this->http(GF::JSON($s));
	}

	public function lostpass($logname,$email){
		$json = '{"action":"GetPwdResetKey","user":{"huanid":"","logname":"'.$logname.'"},"param":{"type":"3","pwda":"","mobile":"0","email":"'.$email.'"}}';
		return $this->http($json);
	}
	public function resetpass($logname,$verify,$passwd){
		$json = '{"action":"ResetPwdByKey","user":{"huanid":"","logname":"'.$logname.'"},"param":{"resetkey":"'.$verify.'","newpwd":"'.$passwd.'"}}';
		return $this->http($json);
	}
}
?>