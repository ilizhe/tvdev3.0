<?php
class GlobalAvatar {

	public function check(){
		if( !$this->token ) throw new AVAException(1,'token not fount');
		$this->U = $this->mget($this->token);
		$this->log(print_r($this->U,true));
		if(!$this->U)  throw new AVAException(2,'token verify error');
		if($this->U->id != $this->uid) throw new AVAException(3,'token and uid verify error');
	}

	public function __call($ss,$pp){
		return "Access Denied~!";
	}

	public function getkey(){
		$mkey = "api_avatar_upload_".$this->uid;
		return $this->mkey($mkey);
	}


	public function uploadavatar(){
		list($width, $height, $type, $attr) = getimagesize($_FILES['Filedata']['tmp_name']);
		$imgtype = array(1 => '.gif', 2 => '.jpg', 3 => '.png');
		$filetype = $imgtype[$type];
		if(!$filetype) $filetype = '.jpg';
		$tmpavatar = './tmp/upload'.$this->uid.$filetype;
		file_exists($tmpavatar) && @unlink($tmpavatar);
		if(@copy($_FILES['Filedata']['tmp_name'], $tmpavatar) || @move_uploaded_file($_FILES['Filedata']['tmp_name'], $tmpavatar)) {
			@unlink($_FILES['Filedata']['tmp_name']);
			list($width, $height, $type, $attr) = getimagesize($tmpavatar);
			if($width < 170 || $height < 170 || $type == 4) {
//				@unlink($tmpavatar);
//				return '<root><message type="error" value="-2" /></root>';
			}
		} else {
			@unlink($_FILES['Filedata']['tmp_name']);
			return -4;
		}
		$avatarurl = 'http://'.$_SERVER['HTTP_HOST'].'/tmp/upload'.$this->uid.$filetype;
		return $avatarurl;
	}

	public function rectavatar(){
		$pic = $this->flashdata_decode($this->A->Post("avatar1"));
		$this->log("get pic data");
		if(!$pic)return '<root><message type="error" value="-2" /></root>';
		$path = $this->makepath($this->uid);
		$this->log("make path".$this->uid);
		if(file_put_contents($path."src.jpg",$pic)) {
			$this->log("write src file in:".$path);
			$this->makeface($path);
			return '<?xml version="1.0" ?><root><face success="1"/></root>';
		} else {
			return '<?xml version="1.0" ?><root><face success="0"/></root>';
		}
	}

	public function makeface($path){
		if( !file_exists($path."src.jpg") )return false;
		$info = getimagesize($path."src.jpg");
		$srcW = $info[0];
		$srcH = $info[1];
		$mime = strtolower($info['mime']);
		if ( strpos($mime,"gif")>0 )
			$source=imagecreatefromgif($path."src.jpg");
		else if(strpos($mime,"png"))
			$source=imagecreatefrompng($path."src.jpg");
		else
			$source=imagecreatefromjpeg($path."src.jpg");
		$this->log(print_r($info,true));
		$n170 = imagecreatetruecolor(170,170);
		$n112 = imagecreatetruecolor(112,112);
		$n90  = imagecreatetruecolor(90 ,90 );
		imagecopyresampled($n170,$source,0,0,0,0,170,170,$srcW,$srcH);
		imagecopyresampled($n112,$source,0,0,0,0,112,112,$srcW,$srcH);
		imagecopyresampled($n90 ,$source,0,0,0,0, 90, 90,$srcW,$srcH);
		imagejpeg($n170,$path."170.jpg",85);
		imagejpeg($n112,$path."112.jpg",85);
		imagejpeg($n90 ,$path."90.jpg" ,85);
		imagedestroy($n170);
		imagedestroy($n112);
		imagedestroy($n90 );
		chmod($path."170.jpg",0644);
		chmod($path."112.jpg",0644);
		chmod($path."90.jpg" ,0644);
		return true;
	}

	public function makepath($uid){
		$path = './avatar/';
		for($i=0;$i<strlen($uid);$i=$i+4){
			$path .= substr($uid,$i,4);
			if(@mkdir($path)){
				;
			}
			$path .= "/";
		}
		return $path;
	}
	public function getpath($uid,$file=''){
		$path = './avatar/';
		for($i=0;$i<strlen($uid);$i=$i+4){
			$path .= substr($uid,$i,4)."/";
		}
		return $path.$file;
	}
	private function call(){
		$uri = $_SERVER['REQUEST_URI'];
		$exp = explode("/",$uri);
		$file = $exp[count($exp)-1];
		return $file;
	}

	public function flashdata_decode($s) {
		$r = '';
		$l = strlen($s);
		for($i=0; $i<$l; $i=$i+2) {
			$k1 = ord($s[$i]) - 48;
			$k1 -= $k1 > 9 ? 7 : 0;
			$k2 = ord($s[$i+1]) - 48;
			$k2 -= $k2 > 9 ? 7 : 0;
			$r .= chr($k1 << 4 | $k2);
		}
		return $r;
	}
	public function back($id,$str){
		$ret = new stdClass();
		$ret->response=$id;
		$ret->msg=$str;
		return GF::JSON($ret);
	}
	public function log($s){
		$str = date('Y-m-d H:i:s');
		$str .= "---".$s."\r\n";
		fwrite($this->fp,$str);
		fflush($this->fp);
	}
	public function initmemcache(){
		$this->MC = new Memcache();
		$ret = @$this->MC->connect($this->C->MEMCACHE['host'],$this->C->MEMCACHE['port']);
		if( $ret === false )throw new exception("connect memcached server failed!");
	}
	public function mset($key,$val,$expires=0){
		return $this->MC->set($key,GF::JSON($val),0,$expires>0?$expires:$this->C->MEMCACHE['expires']);
	}
	public function mkey($key){
		return @$this->MC->add($key,'true');
	}
	public function mget($key){
		$ret = $this->MC->get($key);
		if( !$ret ) return false;
		$this->log($ret);
		$rets = json_decode($ret);
		return $rets;
	}
	public function mdel($key){
		return $this->MC->delete($key);
	}
}
class AVAException extends Exception {
	var $id;
	var $msg;
	function __construct($id,$msg){
		$this->id = $id;
		$this->msg = $msg;
	}
	function getMsg(){
		return $this->msg;
	}
}
?>