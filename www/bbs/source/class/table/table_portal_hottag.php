<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_portal_hottag extends discuz_table
{
	public function __construct() {

		$this->_table = 'portal_hottag';
		$this->_pk    = 'id';
		parent::__construct();
	}
	
	public function getlist($page=1,$order='searchnum',$sort='desc'){
		$pageNum=15;
		$count=(int) DB::result_first('SELECT count(*) FROM '.DB::table('portal_hottag'));
		if($count==0) return false;
		$totalPages=ceil($count/$pageNum);
		$page=$page>$totalPages ? $totalPages : ($page <1 ? 1 : $page);
		$data=array();
		$data['count']=$count;
		$data['pageNum']=$pageNum;
		$data['currentPage']=$page;
		$data['totalPages']=$totalPages;
		$data['rows']=DB::fetch_all('SELECT * FROM '.DB::table('portal_hottag').' ORDER BY isActived desc,'.$order.' '.$sort.' limit '.($page-1)*$pageNum.','.$pageNum);
		return $data;
	}
	
	public function hastag($name){
		return (int) DB::result_first("SELECT count(*) FROM ".DB::table('portal_hottag')." WHERE name='{$name}'");
	}
	
	public function inserttag($data) {
		return DB::insert(DB::table('portal_hottag'),$data,TRUE);
	}
	
	public function gettag($name) {
		return DB::fetch_first("SELECT id,searchnum FROM ".DB::table('portal_hottag')." WHERE name='{$name}'");
	}
}	