<?php
abstract class Spider {

	abstract function index();		//���

	abstract function out();		//����

	abstract function close();		//���

	abstract function check();		//���

	abstract function send($msg);		//����JMS

	abstract function save($msg);
}
?>