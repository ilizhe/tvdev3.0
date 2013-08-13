<?php
class DB
{
	var $C = array();
	var $obj = null;
	var $Link_ID = null;
	static $objid = null;
	static $OBJ = null;
	function __construct($c)
	{
		$this->C = $c;
		$this->connect();
	}
	public static function init($c)
	{
		if( self::$objid == null )
		{
			self::$objid = new DB($c);
		}
		return self::$objid;
	}

	function connect()
	{
		$objname = "";
		switch($this->C->dbType)
		{
			case "mysql":
				$objname = "MySQLDataBase";
				break;
			case "msssql":
				$objname = "MsSQLDataBase";
				break;
			default:
				$this->Halt("DataBase Driver error: can not found ".$this->C->DB['type']);
		}
		self::$OBJ = new $objname($this->C->DB['host'],$this->C->DB['port'],$this->C->DB['user'],$this->C->DB['pass'],$this->C->DB['name'],$this->C->DB['char']);
	}

	public static function Q($sql)
	{
		return self::$OBJ->Query($sql);
	}
	public static function N($Query_ID)
	{
		return self::$OBJ->NumRows($Query_ID);
	}
	public static function O($Query_ID)
	{
		return self::$OBJ->FetchObj($Query_ID);
	}
	public static function A($Query_ID)
	{
		return self::$OBJ->FetchArr($Query_ID);
	}
	public static function F($Query_ID){
		return self::$OBJ->affected($Query_ID);
	}
	public static function R($Query_ID)
	{
		return self::$OBJ->FetchRow($Query_ID);
	}
	public static function P($tblname,$where,$field,$urlopt='',$ord='id',$dc='desc',$defield='id',$page=1,$size=10)
	{
		return self::$OBJ->PQuery($tblname,$where,$field,$urlopt,$ord,$dc,$defield,$page,$size);
	}
	public static function L($tblname,$where,$field,$urlopt='',$ord='id',$dc='desc',$defield='id',$page=1,$size=10)
	{
		return self::$OBJ->LQuery($tblname,$where,$field,$urlopt,$ord,$dc,$defield,$page,$size);
	}
	public static function ID()
	{
		return self::$OBJ->InsertID();
	}
	public static function M($opt=false)
	{
		return self::$OBJ->Pagination($opt);
	}
}
?>