<?php
error_reporting(E_ALL);
define('API_DELETEUSER', 1);
define('API_RENAMEUSER', 1);
define('API_GETTAG', 1);
define('API_SYNLOGIN', 1);
define('API_SYNLOGOUT', 1);
define('API_UPDATEPW', 1);
define('API_UPDATEBADWORDS', 1);
define('API_UPDATEHOSTS', 1);
define('API_UPDATEAPPS', 1);
define('API_UPDATECLIENT', 1);
define('API_UPDATECREDIT', 1);
define('API_GETCREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_UPDATECREDITSETTINGS', 1);
define('API_ADDFEED', 1);
define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '1');
define('TEMPSKIN','./');

include "../../cgi/runtime.inc.php";
include "../../config/member.ucenter.inc.php";

$LG = LOG::init($CONF,"uclss.log");
$get = $post = array();
$code = @$_GET['code'];
$LG->mw("get:".$code);
parse_str(authcode($code, 'DECODE', UC_KEY), $get);
if(time() - $get['time'] > 3600) {
	$LG->mw("time up");
	exit('Authracation has expiried');
}
if(empty($get)) {
	$LG->mw("get filed");
	exit('Invalid Request');
}

include_once '../../uc_client/lib/xml.class.php';
$post = xml_unserialize(file_get_contents('php://input'));
$LG->mw("post:".$post);
if(in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'synlogin', 'synlogout', 'updatepw'))) {
	$uc_note = new uc_note($CONF);
	$LG->mw("newuc:get:".print_r($get,true).":POST:".print_r($post,true));
	echo $uc_note->$get['action']($get, $post);
	exit();
} else {
	exit(API_RETURN_FAILED);
}


class uc_note {

	var $dbconfig = '';
	var $db = '';
	var $tablepre = '';
	var $appdir = '';
	var $c;
	function __construct($C){
		$this->C = $C;
		$this->U = new User();
	}
	function _serialize($arr, $htmlon = 0) {
		if(!function_exists('xml_serialize')) {
			include_once '../uc_client/lib/xml.class.php';
		}
		return xml_serialize($arr, $htmlon);
	}
	function uc_note() {
	}
	function test($get, $post) {
		return API_RETURN_SUCCEED;
	}
	function renameuser($get,$post){
		if(!API_RENAMEUSER) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function synlogin($get,$post){

		if(!API_SYNLOGIN) {
			return API_RETURN_FORBIDDEN;
		}
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	}
	function synlogout($get,$post){
		if(!API_SYNLOGOUT) {
			return API_RETURN_FORBIDDEN;
		}
		$this->U->logout();
	}
	function updatepw($get,$post){

	}
	function deleteuser($get,$post){

	}
}


function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key != '' ? $key : null);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}

function dsetcookie($var, $value = '', $life = 0, $prefix = 1, $httponly = false) {
	global $cookiedomain;
	$_COOKIE[$var] = $value;

	if($value == '' || $life < 0) {
		$value = '';
		$life = -1;
	}
	$path = '/';
	$secure = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
	if(PHP_VERSION < '5.2.0') {
		setcookie($var, $value, $life, $path, $cookiedomain, $secure);
	} else {
		setcookie($var, $value, $life, $path, $cookiedomain, $secure, $httponly);
	}
}
?>
