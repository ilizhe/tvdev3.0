<?php
error_reporting(E_ALL);
define("TT_DEBUG",true);

spl_autoload_register("autoload::loadcgi");
spl_autoload_register("autoload::loadcla");
spl_autoload_register("autoload::loadexc");
spl_autoload_register("autoload::loaderr");

$CONF = new Conf();
$ARGV = new Argv($CONF);
$CONF->GW = Conf::INI(TTROOT."/config/gateway.ini");


DB::init($CONF);
?>