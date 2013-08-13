<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_forum_threadextend extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_threadextend';
		$this->_pk    = 'id';
		parent::__construct();
	}
	
	public function getlist($type,$start = 0, $limit = 10){
		return DB::fetch_all('SELECT * FROM %t WHERE type=%d  ORDER BY creationUTC DESC '.DB::limit($start, $limit),
				array($this->_table, $type));
	}
}	