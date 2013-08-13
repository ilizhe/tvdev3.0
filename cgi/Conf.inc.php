<?php
class Conf
{
	//global set
	var $Debug = true;
	var $GPC   = false;
	var $CheckUserAgent=false;
	//Cleint info
	var $ClientIP = '0.0.0.0';
	var $AccTimes = 0;
	var $UserAgent = '';
	var $SessID = '';
	var $SocketKey = '!#31%^&IOKJHGFGDS';
	var $CacheTime = 3600;

	//Database Config
	var $dbType = "mysql";
	var $dbHost = "localhost";
	var $dbPort = "3306";
	var $dbName = "money_tt";
	var $dbUser = "root";
	var $dbPass = "";
	var $dbChar = "UTF8";

	//Cookie config
	var $CookieExpire = 0;
	var $CookiePath = '/';
	var $CookieDomain = '';

	//Smarty Configure:
	var $smart_temp = "templates";
	var $smart_comp = 'data/template';
	var $smart_cach = "data/cache";
	
	function __construct(){
		if(isset($_SERVER['REMOTE_ADDR']))
			$this->ClientIP = $_SERVER['REMOTE_ADDR'];
		if(isset($_SERVER['REQUEST_TIME']))
			$this->AccTimes = $_SERVER['REQUEST_TIME'];
		if(isset($_SERVER['HTTP_HOST']))
			$this->CookiePath = $_SERVER['HTTP_HOST'];
		$this->GPC = @ini_get("magic_quotes_gpc");
		$this->SessID = session_id();
		$this->load();
	}
	function load(){
		$file = defined("CONFIGINI")?CONFIGINI:TTROOT."/config/config.ini";
		$s = Conf::INI($file);
		foreach($s as $key => $val)
		{
			$this->$key = $val;
		}
	}
	public static function INI($file){
		$key = "CONF_INI_".md5($file);
		return parse_ini_file($file,true);
		$res = false;
		$res = MC::GET($key);
		if(!$res){
			if( file_exists($file) ){
				$res = parse_ini_file($file,true);
				MC::SET($key,$res,0);
			}
		}
		return $res;
	}
}
?>