<?php
define('MODULENAME',"www");
define('CONFIG','wwwmodule.ini');
define("TEMPSKIN","www");
include "../cgi/runtime.inc.php";
ACT::init($ARGV);
ACT::RUN();
?>