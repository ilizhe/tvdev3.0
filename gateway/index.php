<?php
define("URL","./");
define("GATEWAY","1");
include "../cgi/runtime.inc.php";
include_once(TTROOT."/config/member.ucenter.inc.php");
$s = new gwinput($CONF);
$res = $s->run();
echo $res;
unset($s);

class gwinput{
	var $C;
	var $D;
	var $fp;
	var $ret;
	function __construct($CONF){
		$this->C = $CONF;
		$this->ret = new stdClass();
		$this->fp = fopen(TTROOT."/data/gateway.log","a+");
	}
	function __destruct(){
		fclose($this->fp);
	}

	function log($str){
		$s = date("Y-m-d H:i:s")."\t\t".$str."\r\n";

		fwrite($this->fp,$s);
		fflush($this->fp);
	}
	function back($state=''){
		if($state)
			$this->ret->state=$state;
		$this->ret->servertime = time();
		$this->ret->apiversion="1.0";
		$s = GF::JSON($this->ret);
		$this->log("send data:".$s);
		return $s;
	}
	function app($obj){
		$this->log("app info :".$obj->appkey);
		$q = DB::Q("select * from app where appkey='{$obj->appkey}'");
		if( DB::N($q)<1 ) return "app data is none";
		$APP = DB::O($q);
		$E = new stdClass();
		$E->type=0;
		if($APP->eventid>0){
			$qe = DB::Q("select * from event where id='{$APP->eventid}'");
			if( DB::N($qe)<1 ) return "event data is not found";
			$E = DB::O($qe);
			$this->log("etype:".$E->type);
		}
		$dsql = '';
		$sarr = array();
		if( $obj->datachange=="1" ){
			$sarr['name'] = ck($obj,'name');
			$sarr['apptype'] = ck($obj,"apptype");
			$sarr['shopinshop'] = ck($obj,"shopinshop");
			$sarr['category'] = ck($obj,'category');
			$sarr['subcategory'] = ck($obj,'subcategory');
			$sarr['deviceseq'] = ck($obj,'deviceseq');
			$sarr['fee'] = ck($obj,'fee');
			$sarr['desci'] = ck($obj,'desci');
			$sarr['memo'] = ck($obj,"memo");
			$sarr['resratio'] = ck($obj,"resratio");
			$sarr['level'] = ck($obj,'level');
			$sarr['operatetype'] = ck($obj,'operatetype');
			$sarr['addon'] = ck($obj,'addon');
			$sarr['attribute'] = ck($obj,'attribute');
			$sqlarr = array();
			foreach($sarr as $key => $a){
				if($a)$sqlarr[] = $key."='{$a}'";
			}
			if( count($sqlarr)>0 )
				DB::Q("update app set ".implode(",",$sqlarr) ." where id='{$APP->id}'");
		}

//		'0'=>'待审核','100'=>'已上线','200'=>'已提测','300'=>'测试完毕','400'=>'审核打回','500'=>'申请发布','600'=>'申请下线','650'=>'停用','700'=>'审核中','750'=>'下线审核中','850'=>'申请上线打回','900'=>'已下线','950'=>'下线打回'
		$this->log("state:".$obj->state.";appid:".$APP->id.";apkid:".$APP->apkid.";testapkid:".$APP->testapkid);
		switch($obj->state){
			case "100"://上线
				DB::Q("update app set apkid='{$APP->testapkid}',testapkid='0',status='{$obj->state}',refuseinfo='{$obj->msg}' where id='{$APP->id}'");
				if( $APP->apkid >0 )DB::Q("update appversion set status='900' where id='{$APP->apkid}'");
				DB::Q("update appversion set status='{$obj->state}',submit='2' where id='{$APP->testapkid}'");
				break;
			case "400"://审核打回
				if($E->type=="1"){
					DB::Q("update app set apkid='0',testapkid='0',status='400',refuseinfo='{$obj->msg}' where id='{$APP->id}'");
					DB::Q("update appversion set status='400',submit='0' where id='{$APP->testapkid}'");
				}else{
					DB::Q("update appversion set status='400',submit='0' where id='{$APP->testapkid}'");			
				}
				break;
			case "900"://下线
				DB::Q("update app set status='{$obj->state}',refuseinfo='{$obj->msg}' where id='{$APP->id}'");
				DB::Q("update appversion set status='{$obj->state}' where id='{$APP->apkid}'");
				break;
			case "850":
			case "750":
			case "700":
			case "650"://停用
			case "500":
			case "300":
				if( $E->type=="1" )
					DB::Q("update app set status='{$obj->state}',refuseinfo='{$obj->msg}' where id='{$APP->id}'");
				DB::Q("update appversion set status='{$obj->state}' where id='{$APP->testapkid}'");
				break;
			case "950":
				DB::Q("update app set status='100',refuseinfo='{$obj->msg}' where id='{$APP->id}'");
				break;
			default:
				break;
		}
		DB::Q("update event set status='{$obj->state}',refuseinfo='{$obj->msg}' where id='{$APP->eventid}'");
		return $this->back("200OK");
	}
	function user($obj){
		/*
		申请签约：200,APPLY
		已签约：800,SIGN
		未通过签约：300,NOTPASS
		暂停：500,PAUSE
		注销：400,DEPRECATED
		*/

		$this->ret->devid = $obj->devid;
		if( !isset($obj->msg) )$obj->msg='';
		$this->log("user info :".$obj->devid);
		$q = DB::Q("select * from ".UC_DBTABLEPRE."members where huanid='{$obj->devid}'");
		if( DB::N($q)<1 ){
			$this->ret->state = "500";
			$this->ret->note = ' devid not data';
			return $this->back();
		}
		$O = DB::O($q);
		if( $obj->state == '400' ){
			$Q = DB::Q("select * from ".UC_DBTABLEPRE."members where huanid='{$O->devid}'");
			if(DB::N($Q)<1){
				$this->ret->state="200OK";
				return $this->back();
			}
			$M = DB::O($Q);
//			DB::Q("delete from developer where devid='{$M->uid}'");
			DB::Q("delete from ".UC_DBTABLEPRE."members where huanid='{$M->uid}'");
			$this->ret->state="200OK";
			return $this->back();
		}
		if( $obj->datachange == '0' ){
			$d = explode(",",$obj->devid);
			$sd = array();
			foreach($d as $idd){
				$sd[] = intval($idd);
			}
			$obj->devid = implode(",",$sd);
			if(DB::Q("update ".UC_DBTABLEPRE."members set status='{$obj->state}',refuseinfo='{$obj->msg}' where huanid in ({$obj->devid})"))
				$this->ret->state = "200OK";
			else{
				$this->ret->state = "500";
				$this->Ret->note='update db error';
			}
		}else{
			$sql1 = "update ".UC_DBTABLEPRE."members set status='{$obj->state}',refuseinfo='{$obj->msg}' where huanid='{$obj->devid}'";
			$sql2 = array();
			$sql2['email'] = ck($obj,'email');
			$sql2['mobile'] = ck($obj,'mobile');

			$tblname = ( $O->devtype=='0' )?"indiextent":"comextent";
			$qe = DB::Q("select * from {$tblname} where developerid='{$O->uid}'");
			$oe = DB::O($qe);
			if( isset($obj->indiDetailExtent) ){
				foreach($obj->indiDetailExtent as $key => $val){
					if( isset($oe->$key) && $val )
						$sql2[$key] = $val;
				}
				if( $sql2['certpicture'] && strtolower(substr($sql2['certpicture'],0,7))=="http://"){
					$expArr= explode(".",$sql2['certpicture']);
					$exp = ".".$expArr[count($expArr)-1];
					$eee = "cert_".$O->uid."_".time();
					$this->log("found pic url:".$sql2['certpicture']);
					$cl = new CURL($sql2['certpicture']);
					$data = $cl->get($sql2['certpicture']);
					$this->log("data length:".strlen($data));
					$info = $cl->info();
					$cl->close();
					$this->log("download pic :".$info['http_code']);
					$this->log(print_r($info,true));
					if( $info['size_download']>0 ){
						$sql2['certpicture'] = $eee.$exp;
						if( $info['http_code'] == '200'  ){
							$path = TTROOT."/userdata/".$O->devid."/";
							$this->log("rewrite file:".$path.$eee.$exp);
							$fp = fopen($path.$eee.$exp,"w+");
							fwrite($fp,$data);
							fclose($fp);
							$this->log("rewrite file success");
							//@unlink($path.$oe->certpicture);
						}
					}
				}else
					unset($sql2['certpicture']);

			}elseif (isset($obj->comDetailExtent)){

				foreach($obj->comDetailExtent as $key => $val){
					if( isset($oe->$key) && $val )
						$sql2[$key] = $val;
				}
				if( $sql2['licensepic'] && strtolower(substr($sql2['licensepic'],0,7))=="http://"){
					$expArr= explode(".",$sql2['licensepic']);
					$exp = ".".$expArr[count($expArr)-1];
					$eee = "lic_".$O->devid."_".time();
					$this->log("found pic url:".$sql2['licensepic']);
					$cl = new CURL($sql2['licensepic']);
					$data = $cl->get($sql2['licensepic']);
					$this->log("data length:".strlen($data));
					$info = $cl->info();
					$cl->close();
					$this->log("download pic :".$info['http_code']);
					$this->log(print_r($info,true));
					if( $info['size_download']>0 ){
						$sql2['licensepic'] = $eee.$exp;
						if( $info['http_code'] == '200'  ){
							$path = TTROOT."/userdata/".$O->devid."/";
							$this->log("rewrite file:".$path.$eee.$exp);
							$fp = fopen($path.$eee.$exp,"w+");
							fwrite($fp,$data);
							fclose($fp);
							$this->log("rewrite file success");
							//@unlink($path.$oe->licensepic);
						}
					}
				}else
					unset($sql2['licensepic']);
			}else{
				$this->ret->state = "500";
				$this->ret->note = 'input data error :indiDetailExtent ';
				return $this->back();
			}
			$sqlarr = array();
			if(isset($sql2['mobile']) && strlen($sql2['mobile'])>11)$sql2['mobile'] = substr($sql2['mobile'],0,11);
			foreach($sql2 as $key => $a){
				if($a)$sqlarr[] = $key."='{$a}'";
			}
			
			$sql2 = "update ".$tblname." set ";
			$sql2 .= implode(",",$sqlarr);
			$sql2 .= " where developerid='{$O->uid}'";
			$q1 = DB::Q($sql1);
			$q2 = DB::Q($sql2);
			if( $q1 && $q2 ){
				$this->ret->state='200OK';
				$this->ret->note = 'success';
			}else{
				$this->ret->state = "500";
				$this->ret->note = ' faild:update db error';
			}
		}
//		DB::Q("update developer set status='{$obj->state}',refuseinfo='{$obj->msg}' where devid='{$obj->devid}'");
		return $this->back();
	}
	function run(){
		$data = file_get_contents("php://input");
		$this->log("recv data:".$data);
		if( !$data ) return $this->back('500 no data');
		$obj = json_decode($data);
//		$this->log("json:".json_last_error());
		$this->log(print_r($obj,true));
		$this->ret->sn=isset($obj->sn)?$obj->sn:'';
		return $this->user($obj);
		/*
		if( !isset($obj->type) ) return $this->back('500 no type1');
		switch($obj->type){
			case "APP":
				return $this->app($obj);
				break;
			case "USER":
				return $this->user($obj);
				break;
			default:
				return $this->back("500 err type");
				break;
		}*/
	}
}
function ck($obj,$name){
	if( isset($obj->$name) && $obj->$name )
		return $obj->$name;
	else
		return "";
}
?>
