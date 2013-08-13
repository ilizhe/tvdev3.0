<?php
chdir(dirname(__FILE__));
include "../cgi/runtime.inc.php";
$threadid = isset($argv[1])?intval($argv[1]):0;
$options = isset($argv[2])?$argv[2]:'off';
/*
$pidfile = isset($argv[3])?$argv[3]:'/var/run/devCmdServerDeamon.pid';
$pid = ftok(__FILE__,'t');
*/
$cs = new cmdserver($ARGV,$CONF,$threadid,$options);
$cs->run();

class cmdserver{
	var $A;
	var $C;
	var $T;
	var $threadid;
	var $logopt;
	function __construct($ARGV,$CONF,$tid,$logopt){
		$this->A = $ARGV;
		$this->C = $CONF;
		$this->threadid = $tid;
		$this->logopt = $logopt;
		$this->fp = fopen(TTROOT."/data/cmdserver.log","a+");
	}
	function __destruct(){
		fclose($this->fp);
	}
	function log($str){
		$s = date("Y-m-d H:i:s")."\t\t".$str."\r\n";
		if( $this->logopt == "on" )
			echo $s;
		fwrite($this->fp,$s);
		fflush($this->fp);
	}
	function send($obj,$url=''){
		$c = new CURL($this->C->GW['SERVER']['url'].$url);
		$this->log("send data:".$obj);
		$s = $c->post($obj);
		$ret = $c->info();
		$c->close();
		if( $ret['http_code'] != '200' ){
			$this->log("send data error:".$ret['http_code']);
			throw new Exception("send data error:".$ret['http_code']);
		}
		$this->log("recv:".$s);
		return json_decode($s);
	}
	function getAppKey(){
		$obj = new stdClass();
		$obj->title = 'APPKEY';
		$obj->apiversion="1.0";
		$s = $this->send(GF::JSON($obj),"/developer/getAppkey");
		if( $s->state == "0000" )
			return $s->appkey;
		else
			throw new exception("get appkey erorr".$s->state);
	}

	function getTask(){
		$Q = DB::Q("select * from gateway where state='0' limit 1");
		if( DB::N($Q)<1 )return false;
		$task = DB::O($Q);
		$obj = false;
		$app = 0;
		$this->log("get task :".sprintf("id=%s,type=%s",$task->id,$task->type));
		switch($task->type){
			case "app":
				$task->appkey = $this->getAppKey();
				$app=1;
				break;
			case "upgrade":
				break;
			case "upapp":
			case "offapp":
				$app=1;
				break;
			default:return false;
				break;
		}
		try{
			$this->T = new $task->type($this->C,$task,$app);
			$this->log("create object ".$task->type);
			$obj = $this->T->load();
		}catch(exception $r){
			$this->log("load task error:".$r->getMessage());
		}
		$this->log("get task success");
		if( !$obj )DB::Q("update gateway set state='2' where id='{$task->id}'");
		return $obj;
	}

	function save($obj,$ret){
		if(!isset($ret->note))$ret->note=$ret->status;
		DB::Q("update gateway set state='3',msg='{$ret->note}' where id='{$obj->gwid}'");
		$this->T->save($ret);
	}
	function run(){
		$times = array(0,0,5,5,10,10,20,20,30,30,60,120,180,240,300);
		$mo = -1;
		$mt = 0;

		while(true){
			$e=false;
			$obj=true;
			$mo++;
			try{
				$obj = $this->getTask();
				if( $obj ){
					$recv = $this->send(GF::JSON($obj->data),$obj->GateWay);
					$this->save($obj,$recv);
					$mt=0;
				}
			}catch(exception $e){
				$this->log("catch exception:".$e->getMessage());
			}
			if( !$obj || $e){
				$this->log("mt==".$mt);
				if( $mt<count($times)-1 )$mt++;
				sleep($times[$mt]);
				if( $mt>2 ) break;
			}
		}
	}
}
class globalcmdserver{
	var $C;
	var $T;
	public  $S;
	public  $D;
	function filter($file,$obj){
		$u = $this->C->GW['SERVER']['pichost'];
		if( $this->S->tasktype=="upgrade" ){
			return $u."?type=idcard&uid=".$obj->uid."&file=".$file;
		}else{
			return $u."?type=app&uid=".$obj->uid."&appid=".$this->S->appid."&file=".$file;
		}
	}
	function __construct($C,$T,$app){
		$this->C = $C;
		$this->T = $T;
		$this->fp = fopen(TTROOT."/data/cmdt.log","a+");
		if(!defined('UC_KEY'))
			include_once(TTROOT."/config/ucenter.inc.php");
		$this->init($app);
	}
	public function init($app){
		$this->S = new stdClass();
		$this->S->gwid = $this->T->id;
		$this->S->tasktype=$this->T->type;
		if( $app ){
			$q = DB::Q("select * from event where id='{$this->T->dataid}'");
			if( DB::N($q) < 1 ) throw new exception("app event none data");
			$e = DB::O($q);
			$this->S->eventid = $e->id;
			$this->S->appid = $e->appid;
			$this->S->apkid = $e->apkid;
			$this->S->appkey = $this->T->appkey;
		}else{
			$this->S->devid = $this->T->dataid;
		}
	}
	function log($str){
		$s = date("Y-m-d H:i:s")."\t\t".$str."\r\n";
		fwrite($this->fp,$s);
		fflush($this->fp);
	}
}

class upgrade extends globalcmdserver{
	function load(){
		$Q = DB::Q("select *,huanid as devid,username as devname from ".UC_DBTABLEPRE."members where uid='{$this->T->dataid}'");
		if( DB::N($Q)< 1 ) return false;
		$obj = DB::O($Q);
		$obj->tasktype="upgrade";
		$s = DB::Q("select * from ".($obj->devtype==0?"`indiextent`":"`comextent`")." where `developerid`='{$obj->uid}'");
		if( DB::N($s) < 1 ) return false;
		if( $obj->devtype == 0 ){
			$obj->indiDetailExtent = DB::O($s);
			//$obj->indiDetailExtent->certpicture = $this->filter($obj->indiDetailExtent->certpicture,$obj);
			$obj->indiDetailExtent->address = $obj->indiDetailExtent->pctaddr . $obj->indiDetailExtent->address;
			$obj->mobile = $obj->indiDetailExtent->mobile;
		}else{
			$obj->comDetailExtent = DB::O($s);
			$obj->comDetailExtent->address = $obj->comDetailExtent->pctaddr . $obj->comDetailExtent->address;
			//$obj->comDetailExtent->licensepic = $this->filter($obj->comDetailExtent->licensepic,$obj);
			$obj->mobile = $obj->comDetailExtent->mobile;
		}

		$this->S->GateWay = "/developer/regOrUpdateDevInfo";
		$this->S->data = $obj;
		return $this->S;
	}
	function save($ret){
		if( $ret->state != "0000" )
			DB::Q("update ".UC_DBTABLEPRE."members set refuseinfo='{$ret->note}',status='300' where huanid='{$this->S->devid}'");
		return true;
	}
}

?>
