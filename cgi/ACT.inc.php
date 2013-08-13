<?php
class ACT{
	private static $obj = null;
	var $ARGV;
	var $exp;
	var $mod;
	var $act;
	var $cm = null;
	var $ca = null;
	var $O = null;
	public static function Cinit(){
	}
	function __construct($A){
		$this->ARGV=$A;
		$s = parse_ini_file(TTROOT."/config/".(defined("CONFIG")?CONFIG:"module.ini"),true);
		foreach($s as $key => $mod){
			$this->mod[] = $key;
			$this->exp[$key] = $mod;
		}
	}
	public static function init($A){
		if( self::$obj == null )
			self::$obj = new self($A);
	}
	public static function A(){
		return self::$obj->getAction();
	}
	public static function M(){
		return self::$obj->getModule();
	}
	public static function RUN(){
		self::$obj->getModule();
		self::$obj->getAction();
		return self::$obj->setaction();
	}
	function getModule(){
		$module = $this->ARGV->Get("mod");
		$this->cm = in_array($module,$this->mod)?$module:(defined("MODULENAME")?MODULENAME:'');
		T::A('module',$this->cm);
		return $this->cm;
	}
	function getAction(){
		$action = $this->ARGV->Get("act");
		$this->ca = isset($this->exp[$this->cm][$action])?$action:"index";
		T::A("actname",isset($this->exp[$this->cm][$this->ca])?$this->exp[$this->cm][$this->ca]:"");
		return $this->ca;
	}
	function setAction(){
		global $CONF;
		T::A('siteurl',"http://".$_SERVER['HTTP_HOST']);
		T::A("action",$this->ca);
		T::A("mod",$this->cm);
		T::A('tvstoreurl',$CONF->PROJECT['tvstoreurl']);
		T::A('bbsurl',$CONF->PROJECT['bbsurl']);
		T::A('memberurl',$CONF->PROJECT['memberurl']);
		T::A('siteurl',$CONF->PROJECT['siteurl']);
		$referer = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

		if( $this->ca == "loggin" || $this->cm == "register" )$referer='';
		T::A('referer',$referer);

		$modfile = TTROOT."/module/".(defined('MODULENAME')?MODULENAME."/":"").$this->cm.".mod.php";
		if( !defined(strtoupper($this->cm)) && file_exists($modfile) ){
			include_once( $modfile );
			define('MODULE',$this->cm);
			define('ACTION',$this->ca);
			define("SHEILD","sheild.jpg");
			$o = new $this->cm();
			$this->O = $o;
			$cla = $this->ca;
			$o->$cla();
			$o->init($this->ca,$this->cm);
			T::A("obj",$o);
			T::A("sheild",SHEILD);
			T::P($this->cm.".htm");
		}else
			return false;
	}
}

?>
