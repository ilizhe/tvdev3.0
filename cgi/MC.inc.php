<?php
class MC {
	private static $obj = null;
	private $MC = null;
	private $servlist = null;
	public static function GET($key){
		if(!(self::$obj instanceof self)) self::$obj = new self();
		$res = self::$obj->mget($key);
		return $res?unserialize($res):$res;
	}
	public static function SET($key,$val,$exp=0){
		if(!(self::$obj instanceof self)) self::$obj = new self();
		return self::$obj->mset($key,serialize($val),$exp);
	}
	public static function DEL($key){
		if( self::$obj == null ) self::$obj = new self();
		return self::$obj->mdel($key);
	}
	
	private function __construct(){
		global $CONF;
		$this->C = $CONF;
		$this->servlist = parse_ini_file(TTROOT."/config/memcache.ini",true);
		$this->MC = new Memcached();
		foreach($this->servlist as $serv => $s){
			$this->MC->addServer($s['host'],$s['port'],$s['weight']);
		}
	}
	private function mset($key,$val,$exp){
		return $this->MC->set($key,$val,$exp);
	}
	private function mget($key){
		return $this->MC->get($key);
	}
	private function mdel($key){
		return $this->MC->delete($key);
	}
}

?>