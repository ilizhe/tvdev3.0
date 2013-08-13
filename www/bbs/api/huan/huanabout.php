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
$url=$_G['config']['url']['www'];
$t_help=DB::table('common_help');
$data=DB::fetch_all("select id,title from `$t_help` where categoryID=0 order by sort");
foreach ($data as $row){
	echo 'document.write(\'<a href="'.$url.'/about-'.$row['id'].'.html" target="_blank">'.$row['title'].'</a>\');';
}
echo 'document.write(\'<a href="'.$url.'/friendlink.html" target="_blank" class="last">友情链接</a>\')';
?>