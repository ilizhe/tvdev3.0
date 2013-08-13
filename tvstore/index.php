<?php
define('MODULENAME',"tvstore");
define('CONFIG','tvmodule.ini');
define("TEMPSKIN","tvstore");
include "../cgi/runtime.inc.php";
ACT::init($ARGV);
ACT::RUN();
?>