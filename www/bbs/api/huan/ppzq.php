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
$fup=69;
$forum=DB::table('forum_forum');
$forumfield=DB::table('forum_forumfield');

$sql="select forum.fid,forum.`name`,forumfield.icon from `$forum` as forum 
left join `$forumfield` as forumfield
on forum.fid=forumfield.fid
where forum.fup=$fup order by forum.fid desc limit 0,8";
$results=DB::fetch_all($sql);
echo json_encode($results);

?>