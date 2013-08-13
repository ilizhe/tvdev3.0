<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_common_banned.php 27876 2012-02-16 04:28:02Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_help extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_help';
		$this->_pk    = 'id';

		parent::__construct();
	}
	
	public function getlist(){
		return DB::fetch_all('SELECT * FROM %t order by id asc ',array($this->_table));
	}
	public function gethelps($categoryID){
		$count = (int) DB::result_first("SELECT count(*) FROM ".DB::table('common_help')." where categoryID='$categoryID' and title=''");
		return $count;
	}
}

?>