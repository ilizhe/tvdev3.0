<?php
class MonGoDataBase extends DataBase
{
	function __construct($host,$port,$user,$pass,$name,$char)
	{
		$this->dbHost = $host;
		$this->dbPort = $port;
		$this->dbUser = $user;
		$this->dbPass = $pass;
		$this->dbName = $name;
		$this->dbChar = $char;
		$this->Connect();
	}
	function Connect()
	{
		
	}

	function Query($sql)
	{
		
	}

	function NumRows($Query_ID)
	{
		return mysql_num_rows($Query_ID);
	}

	function FetchObj($Query_ID)
	{
		return mysql_fetch_object($Query_ID);
	}
	function FetchArr($Query_ID)
	{
		return mysql_fetch_array($Query_ID,MYSQL_ASSOC);
	}
	function FetchRow($Query_ID)
	{
		return mysql_fetch_row($Query_ID);
	}
	function PQuery($tblname,$where,$field,$urlopt='',$ord='id',$dc='desc',$defield='id',&$page=1,$size=10)
	{
		$this->Size = $size>0?$size:10;
//		$page = $page<0?1:$page;
		$query_id = $this->Query("select count({$defield}) as num from {$tblname} where {$where}");
		$records = $this->FetchObj($query_id);
		$this->NumRows = $records->num;
		$this->PageCount = ($records->num % $this->Size == 0 ) ? $records->num / $this->Size : intval($records->num / $this->Size) +1;
		$page = ($page>$this->PageCount-1)?0:$page;
		$page = ($page<0)?$this->PageCount-1:$page;
		$this->Page = $page;
		$this->UrlOpt = $urlopt;
		$limit = ( $page - 0 ) * $this->Size;
		$sql = "select {$field} from {$tblname} where {$where} order by {$ord} {$dc} limit {$limit},{$this->Size}";
		return $this->Query($sql);
	}
	function LQuery($tblname,$where,$field,$urlopt='',$ord='id',$dc='desc',$defield='id',&$page=1,$size=10)
	{
		$this->Size = $size>0?$size:10;
		$page = !$page?1:$page;
		$query_id = $this->Query("select count({$defield}) as num from {$tblname} where {$where}");
		$records = $this->FetchObj($query_id);
		$this->NumRows = $records->num;
		$this->PageCount = ($records->num % $this->Size == 0 ) ? $records->num / $this->Size : intval($records->num / $this->Size) +1;
		$page = ($page>$this->PageCount&&$this->PageCount>0)?$this->PageCount:$page;
		$page = ($page<0&&$this->PageCount>0)?$this->PageCount:$page;
		$this->Page = $page;
		$this->UrlOpt = $urlopt;
		$limit = ( $page - 1 ) * $this->Size;
		$sql = "select {$field} from {$tblname} where {$where} order by {$ord} {$dc} limit {$limit},{$this->Size}";
		return $this->Query($sql);
	}
		
	function InsertID()
	{
		$id = mysql_insert_id($this->Link_ID);
		if ( $id > 0 ) return $id;

		$q = mysql_query("SELECT last_insert_id()",$this->Link_ID);
		$r = mysql_fetch_array($q);
		return $r[0];
	}

	function Halt()
	{
		throw new Exception(mysql_error());
	}

}
?>