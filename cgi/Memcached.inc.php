<?php
class Memcached {
	private $MC = null;
	function __construct(){
		$this->MC = new Memcache();
	}

	function addServer($host,$port,$w=0){
		return $this->MC->addServer($host,$port,$w);
	}
	function get($key){
		return $this->MC->get($key);
	}
	function set($key,$val,$exp=0){
		return $this->MC->set($key,$val,$exp);
	}
	function delete($key){
		return $this->MC->delete($key);
	}
}
?>