<?php
error_reporting(E_ALL);

spl_autoload_register("autoload::loadcgi");
spl_autoload_register("autoload::loadcla");
spl_autoload_register("autoload::loadlan");

spl_autoload_register("autoload::loadexc");
spl_autoload_register("autoload::loaderr");

$CONF = new Conf();
$ARGV = new Argv($CONF);

//$ref = $_SERVER['HTTP_REFERER'];

//print_r(parse_url($ref));
?>