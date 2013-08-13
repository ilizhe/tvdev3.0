<?php
header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
$pd = TTROOT."/userdata/".$uid."/".$file;
$out = '';
if( file_exists($pd) ){
	$fp = fopen($pd,"r");
	$out = fread($fp,filesize($pd));
	fclose($fp);
	echo $out;
}
?>