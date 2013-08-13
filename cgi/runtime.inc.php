<?php
define("URI",".");
define('TTROOT',str_replace(DIRECTORY_SEPARATOR."cgi","",dirname(__FILE__)));

if( file_exists("../config/config.ini") ){
	define("CONFIGINI","../config/config.ini");
}

function dump($var)
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

class autoload
{
	public static function loadcgi($class){
		if ( file_exists(TTROOT."/cgi/".$class.".inc.php") ){
			include TTROOT."/cgi/".$class.".inc.php";
		}
	}
	public static function loadcla($class){
		if ( file_exists(TTROOT."/class/".$class.".class.php") ){
			include TTROOT."/class/".$class.".class.php";
		}
	}
	public static function loadlan($class){
		if ( file_exists(TTROOT."/language/".$class.".lang.php") ){
			include TTROOT."/language/".$class.".lang.php";
		}
	}
	public static function loadexc($class){
		if ( file_exists(TTROOT."/exception/".$class.".exc.php") ){
			include TTROOT."/exception/".$class.".exc.php";
		}
	}
	public static function loaderr($class){
		if ( !class_exists($class) ){
			self::halt($class);
		}
	}

	public static function loadsmt($class){
	    $_class = strtolower($class);
	    if (substr($_class, 0, 16) === 'smarty_internal_' || $_class == 'smarty_security') {
		    include SMARTY_SYSPLUGINS_DIR . $_class . '.php';
	    }
	}

	public static function halt($class){
		$msg = "load class ".$class." failure: can not found this class file!";
		exit($msg);
	}
}


if( defined('TDATA') ){
	include TTROOT."/cgi/tdata.inc.php";
}elseif (defined("GATEWAY")){
	include TTROOT."/cgi/gateway.inc.php";
}elseif( isset($argv[0]) ){
	include TTROOT."/cgi/cli.inc.php";
}elseif( defined('RESOURCE') ){
	include TTROOT."/cgi/resource.inc.php";
}else{
	include TTROOT."/cgi/global.inc.php";
}
?>