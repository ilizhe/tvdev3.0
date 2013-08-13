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

$table=DB::table('portal_banner');
$type=($_GET['type']==1) ? 1 :2;
$results=DB::fetch_all("SELECT * FROM `$table` where type=$type order by displayorder asc,updateUTC desc limit 0,5");
echo json_encode($results);
?>