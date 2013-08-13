<?php
class Language {

}
class L{
	var $C;
	static $obj = null;
	private function __construct($c){
		$this->C = $c;
	}
	public static function init(){
		$lang = "ZH_CN";
		$charset = "UTF8";
		$classname = $charset."_".$lang;
		echo $classname;

		if(self::$obj == null)
			self::$obj = new $classname();
	}
	public static function A($s){
		return self::$obj->$s();
	}
	function __call($method,$opt){
		return self::$obj->$method;
	}
}
?>