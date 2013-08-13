<?php
class T
{
	var $C;
	private static $objid = null;
	private static $OBJ = null;
	function __construct($c)
	{
		$this->C = $c;
		self::$OBJ = new Smarty();
		self::$OBJ->template_dir = TTROOT.'/template/'.TEMPSKIN;
		self::$OBJ->compile_dir  = TTROOT."/".$c->smart_comp;
		self::$OBJ->cache_dir    = TTROOT."/".$c->smart_cach;
		self::$OBJ->debugging    = false;//$c->Debug;
		self::$OBJ->assign("objdir",$c->PROJECT['template']);
		
	}

	public static function P($tpl,$tp=false)
	{
		return self::$OBJ->display($tpl);
	}
	public static function A($var,$val)
	{
		return self::$OBJ->assign($var,$val);
	}
	public static function SKIN($k,$c)
	{
		self::$OBJ->assign("objdir",URI."/".$c->smart_temp);
	}
	public static function init($c)
	{
		if ( self::$objid == null )
		{
			self::$objid = new T($c);
		}
		self::A("project",$c->PROJECT['name']);
		self::A("version",$c->PROJECT['version']);
	}
}
?>