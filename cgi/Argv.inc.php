<?php
class Argv
{
	var $C      = array();
	var $GET    = array();
	var $POST   = array();
	var $COOKIE = array();
	var $REGEXS = array();
	var $SWITCH = array();
	function __construct($c)
	{
		$this->C = $c;
		$this->init();
	}
	function init()
	{
		$this->GET    = !$this->C->GPC?self::daddslashes($_GET):$_GET;
		$this->POST   = !$this->C->GPC?self::daddslashes($_POST):$_POST;
		$this->COOKIE = !$this->C->GPC?self::daddslashes($_COOKIE):$_COOKIE; 
		$tmp = Conf::INI(TTROOT."/config/regex.ini");
		$this->REGEXS = $tmp['RegExs'];
		$this->SWITCH = $tmp['Switch'];
	}
	function check($str,$type){
		if( isset($this->REGEXS[$type]) )
		{
			return preg_match($this->REGEXS[$type],$str);
		}
		else
			return false;
	}

	public static function daddslashes($str){
		if ( is_array($str) ){
			foreach($str as $key => $val){
				$str[$key] = self::daddslashes($val);
			}
		}else{
			$str = htmlspecialchars(trim($str));
			$str = addslashes($str);
		}
		return $str;
	}
	public function Get($key)
	{
		if ( $key=="" ) return $this->GET;
		return isset($this->GET[$key])?$this->GET[$key]:"";
	}
	public function Post($key)
	{
		if ( $key=='' ) return $this->POST;
		return isset($this->POST[$key])?$this->POST[$key]:"";
	}
	public function Cookie($key)
	{
		if ( $key=='' ) return $this->COOKIE;
		return isset($this->COOKIE[$key])?$this->COOKIE[$key]:"";
	}
	public function setCK($name,$value)
	{
		setcookie($name,$value,$this->C->CookieExpire,$this->C->CookiePath,$this->C->CookieDomain);
	}
	public function random($num,$type='')
	{
		$arr = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','!','@','#','%','^','&','*','(',')','~','`','_','-','+','=','|',':',';','<','?',',','.','?','/');
		$max = count($arr)-1;
		switch($type)
		{
			case 1:
				$min=0;
				$max=9;
				break;
			case 2:
				$min=10;
				$max=36;
				break;
			case 3:
				$min=37;
				break;
			default:
				$min=0;
				break;
		}
		$ret = '';
		for ($i=0;$i<$num;$i++)
		{
			$ret .= $arr[rand($min,$max)];
		}
		return $ret;
	}
	public function FormHash()
	{
		$r = $this->random(6,2);
		$str = $this->C->ClientIP."@#!EDF&^%TFD".session_id()."|||".$r;
		if( isset($_SESSION['sess_rand']) )
		{
			unset($_SESSION['sess_rand']);
		}
		$_SESSION['sess_rand'] = $r;
		return md5($str);
	}
	public function CheckForm($FormHash)
	{
		return isset($_SESSION['sess_rand']) && md5($this->C->ClientIP."@#!EDF&^%TFD".session_id()."|||".$_SESSION['sess_rand']) == $FormHash;
	}
	public function mkFRM($type=false)
	{
		if( $type )
		{
			$_SESSION['sess_form'] = $this->random(6);
		}
		return $_SESSION['sess_form'];
	}
	public function lenstr($str,$len,$start=0)
	{
		if($start < 0)
			$start = strlen($str)+$start;
		$retstart = $start+$this->getOfFirstIndex($str,$start);
		$retend = $start + $len -1 + $this->getOfFirstIndex($str,$start + $len);
		return substr($str,$retstart,$retend-$retstart+1);
	}
	private function getOfFirstIndex($str,$start)
	{
		$char_aci = ord(substr($str,$start-1,1));
		if(223<$char_aci && $char_aci<240)
			return -1;
		$char_aci = ord(substr($str,$start-2,1));
		if(223<$char_aci && $char_aci<240)
			return -2;
		return 0;
	}
	public function CheckUpFile($pic,$size,$wid,$hig)
	{
		if( $pic['error'] > 0 ) return 1;
		if( $pic['size'] < 1 ) return 2;
		if( $pic['size'] > $size *1024 ) return 3;
		$info = getimagesize($pic['tmp_name']);
		if( $info[0]==0 ) return 4;
		if( $info[1]==0 ) return 5;
		if( $info[0]!=$wid ) return 6;
		if( $info[1]!=$hig ) return 7;
		if( $info[2]==2 )
		{
			if ( $info['channels'] == 4 ) return 8;
		}
		switch($pic['type'])
		{
			case "image/gif":
				$ext = ".gif";
				break;
			case "image/png":
				$ext = ".png";
				break;
			case "image/pjpeg":
			case "image/jpeg":
				$ext = ".jpg";
				break;
			default:
				return 9;
				break;
		}
		return 0;
	}
	public function upfile($pic,$id,$dpath,&$file,$size,$wid,$hig)
	{
		if( $pic['error'] > 0 ) return 1;
		if( $pic['size'] < 1 ) return 2;
		if( $pic['size'] > $size * 1024 ) return 3;
		$info = getimagesize($pic['tmp_name']);
		if( $info[0]==0 ) return 4;
		if( $info[1]==0 ) return 5;
		if( $info[0]>$wid ) return 6;
		if( $info[1]>$hig ) return 7;
		if( $info[2]==2 )
		{
			if ( $info['channels'] == 4 ) return 8;
		}
		switch($pic['type'])
		{
			case "image/gif":
				$ext = ".gif";
				break;
			case "image/png":
				$ext = ".png";
				break;
			case "image/pjpeg":
			case "image/jpeg":
				$ext = ".jpg";
				break;
			default:
				return 9;
				break;
		}
		$file = $id.$ext;
		$fn = $dpath."/".$file;
		if (move_uploaded_file($pic['tmp_name'],$fn) )
		{
			return 0;
		}
		else
		{
			return 10;
		}
	}
	public static function clearhtml($str,$stg=''){
		$str = strtolower($str);
		$str = preg_replace("/\<br.*?\>/","{#BR#}",$str);
		$str = preg_replace("/\<p.*?\>/","{#P#}",$str);
//		$str = preg_replace('/(<img).+(src=\"?.+)(.+\.(jpg|gif|bmp|bnp|png)\"?).+>/i',"{#IMG \${2}\${3} #}",$str);
		$str = strip_tags($str);
//		$str = preg_replace('/({#IMG).+(src=\"?.+)(.+\.(jpg|gif|bmp|png|bnp)\"?).+#}/i',"<img \${2}\${3} >",$s);
		$str = str_replace("{#BR#}","<br/>",$str);
		$str = str_replace("{#P#}","<p>",$str);
		return $str;
	}
	function lenstr2($str,$num){
		if( mb_strlen($str,"UTF-8")>$num )
			return mb_substr($str,0,$num,"UTF-8");
		else
			return $str;
	}
	public static function  rs(){
		$gentime = microtime(); 
		$gentime = explode(' ',$gentime); 
		echo "". $gentime[1] + $gentime[0]."<br>"; 
	}
}
?>