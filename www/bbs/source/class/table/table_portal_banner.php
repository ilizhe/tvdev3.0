<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_portal_banner extends discuz_table
{
	public function __construct() {

		$this->_table = 'portal_banner';
		$this->_pk    = 'id';
		parent::__construct();
	}
	
	public function getlist($type,$start = 0, $limit = 10){
		return DB::fetch_all('SELECT * FROM %t WHERE type=%d  ORDER BY displayorder asc,updateUTC DESC '.DB::limit($start, $limit),
				array($this->_table, $type));
	}
	
	public function displayorder($order){
		$table = DB::table('portal_banner');
		if(!is_array($order) && empty($order)) {
			return FALSE;
		}
		foreach ($order as $k=>$v){
			$sql= "update `$table` set `displayorder`={$v} where `id`={$k}";
			DB::query($sql);
		}
		return TRUE;
	}
}	