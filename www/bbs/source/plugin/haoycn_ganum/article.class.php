<?php

/*------ About the Plugin ------
* Versin: 1.0
* Copyright By: Haoycn
* QQ: 614385985
* This is a free software!
------*/

if(!defined('IN_DISCUZ')) exit('Access Denied');

class plugin_haoycn_ganum{
	function global_header(){
		function get_article_num($aid,$type){
			global $_G;
			loadcache('plugin');
			$isopen = $_G['cache']['plugin']['haoycn_ganum']['isopen'];
			if($isopen == 1){
				$aid = intval($aid);
				$type = trim($type);
				$typearray = array('viewnum','commentnum','favtimes','sharetimes');
				if($aid == 0 || !in_array($type,$typearray)){
					return false;
				}else{
					return DB::result_first("SELECT $type FROM ".DB::table('portal_article_count')." WHERE aid = '$aid'");
				}
			}else{
				return false;
			}
		}
	}

}

class plugin_haoycn_ganum_portal extends plugin_haoycn_ganum{}

?>