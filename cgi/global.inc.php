<?php
error_reporting(E_ALL);
session_start();
define("TT_DEBUG",true);

spl_autoload_register("autoload::loadcgi");
spl_autoload_register("autoload::loadcla");
spl_autoload_register("autoload::loadlan");
spl_autoload_register("autoload::loadexc");
spl_autoload_register('autoload::loadsmt');
spl_autoload_register("autoload::loaderr");

$CONF = new Conf();
$ARGV = new Argv($CONF);

DB::init($CONF);
T::init($CONF);


$CONF->REGEX = Conf::INI(TTROOT."/config/regex.ini");
$f = new Focus();
$defocus = $f->C($ARGV);

T::A("REGEX",$CONF->REGEX['RegExs']);
?>