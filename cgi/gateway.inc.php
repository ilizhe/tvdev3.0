<?php
error_reporting(E_ALL);

spl_autoload_register("autoload::loadcgi");
spl_autoload_register("autoload::loadcla");
spl_autoload_register("autoload::loaderr");

$CONF = new Conf();
$ARGV = new Argv($CONF);
$CONF->GW = Conf::INI(TTROOT."/config/gateway.ini");
DB::init($CONF);

if( !in_array($CONF->ClientIP,$CONF->GW['CLIENT']['ip']) ){
	exit('Access Denied Error: '.$CONF->ClientIP.' is not allow');
}

?>