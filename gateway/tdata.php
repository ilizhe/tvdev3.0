<?php
define('GATEWAY',true);
include "../cgi/runtime.inc.php";


$file = $ARGV->Get("file");
$uid   = $ARGV->Get("uid");
$type = $ARGV->Get("type");

$out = '';
if($type=="idcard"){
	header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" );
	header( "Cache-Control: no-cache, must-revalidate" );
	header( "Pragma: no-cache" );
	header( "Content-type:image/jpeg" );
	$pd = TTROOT."/userdata/".$uid."/".$file;
	if( file_exists($pd) ){
		$fp = fopen($pd,"r");
		$out = fread($fp,filesize($pd));
		fclose($fp);
	}
}
if( $type == "app" ){
	$appid = $ARGV->Get("appid");
	header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" );
	header( "Cache-Control: no-cache, must-revalidate" );
	header( "Pragma: no-cache" );
	header( "Content-type:application/octet-stream" );
	header( "Content-Disposition:attachment;filename=".$file );
	$pd = TTROOT."/static/temp/".$file;
	if( file_exists($pd) ){
		$fp = fopen($pd,"r");
		$out = fread($fp,filesize($pd));
		fclose($fp);
	}
}
header( "Content-length:".strlen($out) );
echo $out;
?>