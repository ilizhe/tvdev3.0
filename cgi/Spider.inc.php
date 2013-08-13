<?php
abstract class Spider {

	abstract function index();		//入口

	abstract function out();		//出口

	abstract function close();		//完成

	abstract function check();		//检测

	abstract function send($msg);		//发送JMS

	abstract function save($msg);
}
?>