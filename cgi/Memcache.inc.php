<?php
if( !class_exists('Memcache') ){

	class Memcache{
		var $linkid;
		function __construct(){
		}
		function connect($host,$port){
			$this->linkid = memcache_connect($host,$port);
			if( !$this->linkid ) throw new exception("connect memcached faild");
		}
		function set($key,$val){
			memcache_set($this->linkid,$key,$val,0,86400);
		}
		function get($key){
			return memcache_get($this->linkid,$key);
		}
	}
}
?>