<?php
abstract class DataBase
{
	var $dbHost;
	var $dbPort;
	var $dbUser;
	var $dbPass;
	var $dbName;
	var $dbChar;

	var $Link_ID;
	var $Query_ID;
	var $Records;

	var $Page;
	var $Size;
	var $NumRows;
	var $PageCount;
	var $UrlOpt;

	/*connect to database*/
	abstract function Connect();

	/*execute sql query*/
	abstract function Query($sql);

	abstract function NumRows($Query_ID);
	/*fetch rows*/
	abstract function FetchObj($Query_ID);
	abstract function FetchArr($Query_ID);
	abstract function FetchRow($Query_ID);
	abstract function Halt();
	abstract function InsertID();

	/*
	$tblname	: table name
	$where		: 
	$field		:
	$urlopt		:
	*/
	abstract function PQuery($tblname,$where,$field,$urlopt='',$ord='id',$dc='desc',$defield='id',&$page=1,$size=10);
	abstract function LQuery($tblname,$where,$field,$urlopt='',$ord='id',$dc='desc',$defield='id',&$page=1,$size=10);

	function Pagination($opt='')
	{
		if($opt)$this->UrlOpt = $opt;
		$pp = $this->Page-1;
		$pn = $this->Page+1;

		$obj = new stdClass();
		if($this->PageCount ==0)$this->PageCount=1;
		$obj->NextMark  = ( ( $this->Page < $this->PageCount ) && ( $this->PageCount > 1 ) && ( $this->NumRows > 0 ) );
		$obj->PrevMark  = ( ( $this->Page > 1 ) && ( $this->NumRows > 0 ) && ( $this->PageCount > 1 ) ) ;
		$obj->Records   = $this->Records;
		$obj->PageCount = $this->PageCount;
		$obj->Page      = $this->Page;
		$obj->Size      = $this->Size;
		$obj->NumRows   = $this->NumRows;
		$obj->frist     = $this->UrlOpt."&page=1";
		$obj->prev      = $this->UrlOpt."&page=".$pp;
		$obj->next      = $this->UrlOpt."&page=".$pn;
		$obj->end       = $this->UrlOpt."&page=".$this->PageCount;
		return $obj;
	}
}
?>