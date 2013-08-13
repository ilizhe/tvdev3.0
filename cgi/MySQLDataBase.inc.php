<?php
class MySQLDataBase extends DataBase
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
		$this->Link_ID = mysql_connect($this->dbHost.":".$this->dbPort,$this->dbUser,$this->dbPass);
		if ( !$this->Link_ID )
		{
			exit('Access DataBase denied:'.mysql_error());
		}
		$serverset = "character_set_connection=".$this->dbChar.", character_set_results=".$this->dbChar.", character_set_client=binary,sql_mode=''";
		mysql_query("set names '{$this->dbChar}'",$this->Link_ID);
		mysql_select_db($this->dbName,$this->Link_ID);
	}

	function Query($sql)
	{
		$this->Query_ID = mysql_query($sql,$this->Link_ID);
		if ( $this->Query_ID == false ) $this->Halt($sql);
		return $this->Query_ID;
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
		$this->Records = $records->num;
		$this->PageCount = ($records->num % $this->Size == 0 ) ? $records->num / $this->Size : intval($records->num / $this->Size) +1;
		if($this->PageCount==0)$this->PageCount=1;
		$page = ($page>$this->PageCount)?1:$page;
		$page = ($page<1)?$this->PageCount:$page;
		$this->Page = $page;
		$this->UrlOpt = $urlopt;
		$limit = ( $page - 1 ) * $this->Size;
		$sql = "select {$field} from {$tblname} where {$where} order by {$ord} {$dc} limit {$limit},{$this->Size}";
		$ret = $this->Query($sql);
		$this->NumRows = $this->NumRows($ret);
		return $ret;
	}
	function LQuery($tblname,$where,$field,$urlopt='',$ord='id',$dc='desc',$defield='id',&$page=1,$size=10)
	{
		$this->Size = $size>0?$size:10;
		$page = !$page?1:$page;
		$query_id = $this->Query("select count({$defield}) as num from {$tblname} where {$where}");
		$records = $this->FetchObj($query_id);
		$this->Records = $records->num;
		$this->PageCount = ($records->num % $this->Size == 0 ) ? $records->num / $this->Size : intval($records->num / $this->Size) +1;
		$page = ($page>$this->PageCount&&$this->PageCount>0)?$this->PageCount:$page;
		$page = ($page<0&&$this->PageCount>0)?$this->PageCount:$page;
		$this->Page = $page;
		$this->UrlOpt = $urlopt;
		$limit = ( $page - 1 ) * $this->Size;
		$sql = "select {$field} from {$tblname} where {$where} order by {$ord} {$dc} limit {$limit},{$this->Size}";
		$ret = $this->Query($sql);
		$this->NumRows = $this->NumRows($ret);
		return $ret;
	}
	function InsertID()
	{
		$id = mysql_insert_id($this->Link_ID);
		if ( $id > 0 ) return $id;

		$q = mysql_query("SELECT last_insert_id()",$this->Link_ID);
		$r = mysql_fetch_array($q);
		return $r[0];
	}
	function affected($q=''){
		return mysql_affected_rows($this->Link_ID);
	}
	function Halt($sql='')
	{
		throw new Exception(mysql_error().$sql);
	}

}
class MYSQLException extends Exception {
	
}
?>