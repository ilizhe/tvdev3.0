<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$_GET = daddslashes($_GET);
$_POST = daddslashes($_POST);
foreach(array_merge($_POST, $_GET) as $k => $v) {
	$_G['gp_'.$k] = $v;
	$_GET[$k] = $v;
}
require_once DISCUZ_ROOT.'./source/discuz_version.php';
$VeRsIoN = DB::result_first("select version from ".DB::table('common_plugin')." WHERE identifier='huxdown'");
$sid = ($_G['gp_sid'] == '') ? 0 : intval($_G['gp_sid']);
$oid = ($_G['gp_oid'] == '') ? 0 : intval($_G['gp_oid']);
$atclass[$sid] = "class='a'";
$downsetting = $_G['cache']['plugin']['huxdown'];
$pluginname = $downsetting['pluginname'];
$qropen = $downsetting['qr'];
$star1 = intval($downsetting['star1']);
$star2 = intval($downsetting['star2']);
$star3 = intval($downsetting['star3']);
$star4 = intval($downsetting['star4']);
$star5 = intval($downsetting['star5']);
$star6 = intval($downsetting['star6']);
$star7 = intval($downsetting['star7']);
$star8 = intval($downsetting['star8']);
$star9 = intval($downsetting['star9']);
$star10 = intval($downsetting['star10']);
$star11 = intval($downsetting['star11']);
$star12 = intval($downsetting['star12']);
$star13 = intval($downsetting['star13']);
$star14 = intval($downsetting['star14']);
$star15 = intval($downsetting['star15']);
$startype = $downsetting['startype'];
$loadtype = $downsetting['loadtype'];
$loadfid = unserialize($downsetting['fid']);
$loadfid = array_unique($loadfid);
$loadfid = array_filter($loadfid);
$loadfid = dimplode($loadfid);
$sortid = $downsetting['sortid'];
$sortid = explode(',',$sortid);
$sortid = array_unique($sortid);
$sortid = array_filter($sortid);
$sortid = dimplode($sortid);
$allowgp = unserialize($downsetting['allowgp']);
$allowgp = array_unique($allowgp);
$allowgp = array_filter($allowgp);
$allowgp = dimplode($allowgp);
$addusermsg = lang('plugin/huxdown','add_user');
$addviewmsg = lang('plugin/huxdown','add_view');
$addremsg = lang('plugin/huxdown','add_re');
$addtypemsg = lang('plugin/huxdown','add_type');
$addtimemsg = lang('plugin/huxdown','add_time');
$starnonemsg = lang('plugin/huxdown','star_none');
$starxinmsg = lang('plugin/huxdown','star_xin');
$starzuanmsg = lang('plugin/huxdown','star_zuan');
$starguanmsg = lang('plugin/huxdown','star_guan');

$sqluid = DB::query("SELECT uid FROM ".DB::table('common_member')." WHERE groupid IN($allowgp)");
while($uidouts = DB::fetch($sqluid)) {
  $uidoutss[] = $uidouts['uid'];
}
$uidoutss = array_unique($uidoutss);
$uidoutss = array_filter($uidoutss);
$uidoutss = dimplode($uidoutss);

//start 
$search='<script>var pinpai=Array(); var xpfa=Array(); var rjbb=Array();';
$rs=DB::fetch_first("select optionid from ".DB::table('forum_typeoption')." WHERE identifier='PP'");
if($rs)
{
	$ppID=$rs['optionid'];
	$rs=DB::fetch_all("select DISTINCT(A1.`value`) from ".DB::table('forum_typeoptionvar')." AS A1 WHERE A1.optionid=$ppID");
	$xpk=$ppk=$rjbbk=$k=0;
	foreach ($rs as $ppv)
	{
		if(!$ppv['value'])continue;
		$k++;$pid=$k;
		$search.='pinpai['.$ppk.']=new Array("'.$k.'","'.$ppv['value'].'");';
		$xpID=DB::fetch_first("select optionid from ".DB::table('forum_typeoption')." WHERE identifier='XP'");
		if(!$xpID) continue;
		$id=$xpID['optionid'];//Ð¾Æ¬ID
		$xprs=DB::fetch_all("select DISTINCT(A2.`value`) from ".DB::table('forum_typeoptionvar')." AS A1
					JOIN ".DB::table('forum_typeoptionvar')." AS A2
					ON A1.tid=A2.tid
					AND A2.optionid=$id
					WHERE A1.optionid=$ppID AND A1.`value`='{$ppv['value']}'");
		foreach($xprs as $xpv)
		{
			if(!$xpv['value'])continue;
			$k++;$xid=$k;
			$search.='xpfa['.$xpk.']=new Array("'.$k.'","'.$xpv['value'].'","'.$pid.'");';
			$rjbb=DB::fetch_first("select optionid from ".DB::table('forum_typeoption')." WHERE identifier='RJ'");
			if(!$rjbb) continue;
			$rjbbID=$rjbb['optionid'];//Èí¼þ°æ±¾ID
			$rjbbrs=DB::fetch_all("select DISTINCT(A2.`value`) from ".DB::table('forum_typeoptionvar')." AS A1
					JOIN ".DB::table('forum_typeoptionvar')." AS A2
					ON A1.tid=A2.tid
					AND A2.optionid=$rjbbID
					WHERE A1.optionid=$id AND A1.`value`='{$xpv['value']}'");
			
			foreach($rjbbrs as $rjbbv)
			{
				if(!$rjbbv['value'])continue;
				$k++;$rid=$k;
				$search.='rjbb['.$rjbbk.']=new Array("'.$k.'","'.$rjbbv['value'].'","'.$xid.'","'.$pid.'");';
				$rjbbk++;
			}
			$xpk++;
		}
		$ppk++;
	}
}
$search.='</script>';

//end

if ($loadtype == '1') {
	$sortsql = DB::query("SELECT fid AS typeid,name FROM ".DB::table('forum_forum')." WHERE fid IN({$loadfid}) ORDER BY displayorder ASC");
	$lt = "AND fid IN({$loadfid})";
} else {
	$sortsql = DB::query("SELECT typeid,name FROM ".DB::table('forum_threadtype')." WHERE typeid IN({$sortid}) ORDER BY displayorder ASC");
	$lt = "AND T1.sortid IN({$sortid})";
}
while($sortids = DB::fetch($sortsql)) {
  $sortidss[] = $sortids;
}
	$where = '';
	$exc = '';
	$order = '';
	$excc = '';
	if ($sid == 0) {
		$where = ($loadtype == '1') ? "" : " AND T1.sortid<>'0'";
		$exc = "";
	} else {
		$where = ($loadtype == '1') ? " AND fid='$sid'" : " AND T1.sortid='$sid'";
		$exc = "&sid=$sid";
	}
	if ($oid == 1) {
		$order = "ORDER BY dateline ASC";
		$excc = "&oid=1";
	} elseif ($oid == 2) {
		$order = "ORDER BY dateline DESC";
		$excc = "&oid=2";
	} elseif ($oid == 3) {
		$order = "ORDER BY views ASC";
		$excc = "&oid=3";
	} elseif ($oid == 4) {
		$order = "ORDER BY views DESC";
		$excc = "&oid=4";
	} elseif ($oid == 5) {
		$order = "ORDER BY replies ASC";
		$excc = "&oid=5";
	} elseif ($oid == 6) {
		$order = "ORDER BY replies DESC";
		$excc = "&oid=6";
	} else {
		$order = "ORDER BY tid DESC";
		$excc = "";
	}
	
	//start
	$join='';
	if(isset($_GET['pp']))
	{
		$excc.="&pp=".urlencode($_GET['pp']);
		$join=" JOIN ".DB::table('forum_typeoptionvar')." as T2 ON T1.tid=T2.tid AND T2.value='".$_GET['pp']."' AND T2.optionid=$ppID";
		if(isset($_GET['xp'])){
			$excc.="&pp=".urlencode($_GET['pp'])."&xp=".urlencode($_GET['xp']);
			$join.=" JOIN ".DB::table('forum_typeoptionvar')." as T3 ON T3.tid=T2.tid AND T3.value='".$_GET['xp']."' AND T3.optionid=$id";
			if(isset($_GET['bb'])){
				$excc.="&pp=".urlencode($_GET['pp'])."&xp=".urlencode($_GET['xp'])."&bb=".urlencode($_GET['bb']);
				$join.=" JOIN ".DB::table('forum_typeoptionvar')." as T4 ON T4.tid=T3.tid AND T4.value='".$_GET['bb']."' AND T4.optionid=$rjbbID";
			}
		}
	}
	//end

	$perpage = $downsetting['nums'];
	$n = DB::query("select T1.* from ".DB::table('forum_thread')." as T1 ".$join." WHERE displayorder<>'-1' AND displayorder<>'-2' AND displayorder<>'-3' AND displayorder<>'-4' AND authorid>'0' $lt AND authorid IN({$uidoutss})$where");
	$fnum = DB::num_rows($n);
	$page = max(1, $_G['gp_page']);
	
	$start = ($page-1)*$perpage;	
	
	$fquery = DB::query("select T1.* from ".DB::table('forum_thread')." as T1 ".$join." WHERE displayorder<>'-1' AND displayorder<>'-2' AND displayorder<>'-3' AND displayorder<>'-4' $lt AND authorid>'0' AND authorid IN({$uidoutss})$where $order limit $start,$perpage");
	
	$flist = "<tr>";
	$i = 0;
	$rqID=DB::fetch_first("select optionid from ".DB::table('forum_typeoption')." WHERE identifier='RQ'");
	$ppID=DB::fetch_first("select optionid from ".DB::table('forum_typeoption')." WHERE identifier='PP'");
	while($fresult = DB::fetch($fquery)){
		$i++;
		if (!($i % 2)) {
			$pright = "";
		} else {
			$pright = " style='padding-right:10px;'";
		}
		$wurl = 'forum.php?mod=viewthread&tid='.$fresult['tid'].'&extra=page%3D1';
		$starnum = ($startype == '1') ? $fresult['replies'] : $fresult['views'];
		if ($starnum < $star1) {$starpic = "static/image/traderank/seller/0.gif";}
		if ($starnum >= $star1) {$starpic = "static/image/traderank/seller/1.gif";}
		if ($starnum >= $star2) {$starpic = "static/image/traderank/seller/2.gif";}
		if ($starnum >= $star3) {$starpic = "static/image/traderank/seller/3.gif";}
		if ($starnum >= $star4) {$starpic = "static/image/traderank/seller/4.gif";}
		if ($starnum >= $star5) {$starpic = "static/image/traderank/seller/5.gif";}
		if ($starnum >= $star6) {$starpic = "static/image/traderank/seller/6.gif";}
		if ($starnum >= $star7) {$starpic = "static/image/traderank/seller/7.gif";}
		if ($starnum >= $star8) {$starpic = "static/image/traderank/seller/8.gif";}
		if ($starnum >= $star9) {$starpic = "static/image/traderank/seller/9.gif";}
		if ($starnum >= $star10) {$starpic = "static/image/traderank/seller/10.gif";}
		if ($starnum >= $star11) {$starpic = "static/image/traderank/seller/11.gif";}
		if ($starnum >= $star12) {$starpic = "static/image/traderank/seller/12.gif";}
		if ($starnum >= $star13) {$starpic = "static/image/traderank/seller/13.gif";}
		if ($starnum >= $star14) {$starpic = "static/image/traderank/seller/14.gif";}
		if ($starnum >= $star15) {$starpic = "static/image/traderank/seller/15.gif";}
		if ($starnum < $star1) {
			$starpingjia = $starnonemsg;
		}
		if ($starnum >= $star1) {
			$starpingjia = $starxinmsg;
		}
		if ($starnum >= $star6) {
			$starpingjia = $starzuanmsg;
		}
		if ($starnum >= $star11) {
			$starpingjia = $starguanmsg;
		}
		if ($qropen) {
			//include_once DISCUZ_ROOT.'./source/plugin/huxdown/huxdown.func.php';
			$urlToEncode = str_replace('plugin.php',str_replace('&','%26',$wurl),'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
			//$sortpic = generateQRfromGoogle($urlToEncode);
			$sortpic = '<img src="'.$_G['config']['url']['www'].'/qrcode/?data='.urlencode($urlToEncode).'" width="80px" height="80px"/>';
		} else {
			if (DISCUZ_VERSION == 'X1.5') {
				$sortpic = "&nbsp;";
			} else {
				$ffquery = DB::result_first("select attachment from ".DB::table('forum_threadimage')." WHERE tid='".$fresult['tid']."'");
				$sortpic = !$ffquery ? "&nbsp;" : "<img src='data/attachment/forum/".$ffquery."' width='80' height='80' />";
			}
		}
		//if ($loadtype == '1') {
		//	$sortname = DB::result_first("SELECT name FROM ".DB::table('forum_forum')." WHERE fid='".$fresult['fid']."'");
		//} else {
		//	$sortname = DB::result_first("SELECT name FROM ".DB::table('forum_threadtype')." WHERE typeid='".$fresult['sortid']."'");
		//}
		if($ppID) {
			$rq=DB::fetch_first("select value from ".DB::table('forum_typeoptionvar')." WHERE optionid=".$ppID['optionid']." AND tid=".$fresult['tid']);
			$sortname=$rq ? $rq['value'] : '';
		}
		$addsubject = cutstr($fresult[subject],36,'');
		$addtime = dgmdate($fresult['dateline']);
		if($rqID) {
			$rq=DB::fetch_first("select value from ".DB::table('forum_typeoptionvar')." WHERE optionid=".$rqID['optionid']." AND tid=".$fresult['tid']);
			$addtime=$rq ? $rq['value'] : $addtime;
		}
		$flist .= "<td width='50%' valign='top'$pright><div class='bm bmw fl'><div class='bm_h cl'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td><h2 style='font-size:14px;'><a href='$wurl' target='_blank' title='$fresult[subject]'>$addsubject</a></h2></td><td align='right'><img src='$starpic' align='abcmiddle' title='$starpingjia' /></td></tr></table></div><div class='bm_c'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td>$addusermsg:$fresult[author]<br>$addviewmsg:$fresult[views]<br>$addremsg:$fresult[replies]<br>$addtypemsg:$sortname<br>$addtimemsg:$addtime</td><td align='right'>$sortpic</td></tr></table></div></div></td>";
		if (!($i % 2)) {
			$flist .= "</tr><tr>";
		}
	}
	if($i==1) {
		$flist .= '<td width="50%" valign="top" ></td>';
	}
	$flist .= "</tr>";
	$multi = multi($fnum, $perpage, $page, "plugin.php?id=huxdown:huxdown$exc$excc");
include template('huxdown:huxdown');
?>