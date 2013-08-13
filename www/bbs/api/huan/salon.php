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
$fup=82;
$forum=DB::table('forum_forum');
$forumfield=DB::table('forum_forumfield');
$thread=DB::table('forum_thread');
$sql="select forum.fid,forum.`name`,forumfield.banner from `$forum` as forum 
left join `$forumfield` as forumfield
on forum.fid=forumfield.fid
where forum.fup=$fup order by forum.displayorder asc,forum.fid desc";
$results=DB::fetch_all($sql);
$data=array();
foreach($results as $key=>$row){
	//判断该板块下是否有活动贴，没有的话就过滤掉
	$rs=DB::fetch_first("select tid from `$thread` where fid={$row['fid']} and special=4 and displayorder>=0");
	if(!$rs){
		unset($results[$key]);
		continue;
	}
	$row['salon']=$rs['tid'];
	$data[]=$row;
}
unset($results);
$count=count($data);
$pagesize=isset($_GET['pagesize'])? ($_GET['pagesize']>0?intval($_GET['pagesize']):3) :3;
$page=isset($_GET['page'])? $_GET['page'] :1;
$totalpage=ceil($count/$pagesize);
$page=$page<1 ? 1 : ($page>$totalpage ? $totalpage: $page);
foreach($data as $k=>$v){
	if($k <($page-1)*$pagesize || $k >= ($page-1)*$pagesize+$pagesize){
		unset($data[$k]);
		continue;
	}
	$threads=DB::fetch_all("select tid,subject from `$thread` where fid={$v['fid']} and special=0 and displayorder>=0 order by tid desc limit 0,4");
	$data[$k]['threads']=$threads;
}
$salon=array();
$salon['count']=$count;
$salon['rows']=$data;
echo json_encode($salon);

?>