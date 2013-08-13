<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: javascript.php 25246 2011-11-02 03:34:53Z zhangguosheng $
 */

header('Expires: '.gmdate('D, d M Y H:i:s', time() + 60).' GMT');

if(!defined('IN_API')) {
	exit('Access Denied');
}

loadcore();

$t_help=DB::table('common_help');
if(isset($_GET['type']) && !empty($_GET['type'])){
	if(isset($_GET['id']) && !empty($_GET['id'])){
		$about=DB::fetch_first("select * from `$t_help` where id={$_GET['id']}");
	}else{
		$about=DB::fetch_all("select * from `$t_help` where categoryID=0 order by sort");	
	}

}else{
	$t_helpcate=DB::table('common_helpcate');
	$cates=DB::fetch_all("select * from `$t_helpcate` order by sort");
	$about=array();
	foreach($cates as $cate){
		$about[$cate['category']]=DB::fetch_all("select * from `$t_help` where categoryID={$cate['id']} order by sort");
	}
}
$data=array();
$data['about']=$about;
$t_setting=DB::table('common_setting');
$bbname=DB::fetch_first("select svalue from `$t_setting` where `skey`='bbname'");
$data['bbname']=$bbname['svalue'];
echo json_encode($data);

?>