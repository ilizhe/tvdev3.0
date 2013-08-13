<?php
chdir(dirname(__FILE__));
include "../cgi/runtime.inc.php";
include TTROOT."/config/ucenter.inc.php";
/*
define('UC_DBHOST', '127.0.0.1');
define('UC_DBUSER', 'ucenter');
define('UC_DBPW', 'ucenterpass');
define('UC_DBNAME', 'ucenter');
*/
$link = mysql_connect(UC_DBHOST,UC_DBUSER,UC_DBPW) or die("connect ucenter error:".mysql_error());
mysql_select_db(UC_DBNAME,$link) or die("select db error:".mysql_error());
mysql_query("set names 'UTF8'",$link);
$fp = fopen("tm.log","a+");
$tm=0;
$tb=0;
$btm=0;
$query = mysql_query("select * from uc_members ");
while ( $uc = mysql_fetch_object($query) ){
	$q = DB::Q("select * from developer where devname='{$uc->username}'");
	if( DB::N($q)<1 ){
		$tb++;
		DB::Q("insert developer(devname,password,devtype,clubtype,status,salt,email,isclub,active,operator) values ('{$uc->username}','{$uc->password}','-1','-1','0','{$uc->salt}','{$uc->email}','0','1','ucenter import')");
	}else{
		$O = DB::O($q);
		if( $uc->email == $O->email ){
			$tm++;
			DB::Q("update developer set salt='{$uc->salt}',password='{$uc->password}' where devid='{$O->devid}'");
		}else{
			$btm++;
			fwrite($fp,$uc->username."\t\t".$uc->email."\r\n");
		}
	}
}
fwrite($fp,"同步数据：{$tb}，重复数据：{$btm}，同名数据：".$tm."\r\n");
fclose($fp);
echo "同步数据：{$tb}，重复数据：{$btm}，同名数据：".$tm."\r\n";
?>