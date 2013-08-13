<?php
chdir(dirname(__FILE__));
include "../cgi/runtime.inc.php";
include TTROOT."/config/ucenter.inc.php";
$u = new reset($CONF);
$a = $u->run();
class reset{
	var $C;
	function __construct($CONF){
		echo "Clear up developer >>>>>>>";
	}
	function run(){
		$nowtime = time();
		$time = $nowtime-86400;
		DB::Q("delete from developer where active='0' and regdate<'{$time}'");
	}
}

?>