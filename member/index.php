<?php
define("URL","./");
define('MODULENAME',"member");
define('CONFIG','membermodule.ini');
define("TEMPSKIN","member");
include "../cgi/runtime.inc.php";
try{
ACT::init($ARGV);
ACT::RUN();
}catch(Exception $r){
print_r($r);
}
?>