<?php


spl_autoload_register("autoload::loadcgi");
spl_autoload_register("autoload::loadcla");
spl_autoload_register("autoload::loadexc");
spl_autoload_register('autoload::loadsmt');
spl_autoload_register("autoload::loaderr");

$CONF = new Conf();
$ARGV = new Argv($CONF);
DB::init($CONF);
$file = $ARGV->Get("file");

//$uid   = $ARGV->Get("uid");
$U = User::Cinit();
if(!$U->check())exit();

$uid = $U->uid;
$type = $ARGV->Get("type");
$modf = TTROOT."/module/".MODULENAME."/".$type.".tdata.php";
if ( file_exists($modf) ){
	include $modf;
}
?>