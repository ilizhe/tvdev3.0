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
$tagtable=DB::table('portal_hottag');
$sql="select name from `$tagtable` where isactived=1 order by searchnum desc limit 0,15";
$data=DB::fetch_all($sql);
if(!$data) {
	return FALSE;
}
foreach($data as $v) {
	$class='hottag'.rand(1,9);
	$v['name']=addslashes($v['name']);
	echo 'document.write(\'<a href="search.php?mod=portal&searchsubmit=true&source=hotsearch&srchtxt='.rawurlencode($v['name']).'" class="'.$class.'">'.$v['name'].'</a>\');';
}
?>