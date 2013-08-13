<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function generateQRfromGoogle($chl,$widhtHeight ='80',$EC_level='L',$margin='0') {
	$url = urlencode($url);
	return '<img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$chl.'" alt="QR CODE" widhtHeight="'.$size.'" widhtHeight="'.$size.'"/>';
}
?>