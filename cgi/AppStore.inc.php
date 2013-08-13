<?php
class AppStore {
	private $C;
	private $fp = null;
	private static $obj = null;
	public static function init($c){
		if(!(self::$obj instanceof self)){
			self::$obj = new self($c);
		}
		return self::$obj;
	}
	private function __construct($c){
		$this->C = $c;
		$this->server = $this->C->GW['server'];
		$log = $this->C->GW['log'];
		if($log)$this->fp = fopen($log,'a+');
	}
	
	private function log($msg){
		if($this->fp == null)return ;
		$s = date('Y-m-d H:i:s',time()).$msg ."\r\n";
		fwrite($this->fp,$s);
		fflush($this->fp);
	}
	private function send($url,$msg){
		$msg->callid = GF::MT();
		$msg->devmodel = $this->C->GW['devmodel'];
		$msg->apiversion = '3.0';
		$json = GF::JSON($msg);
		$cl = new CURL('');
		$this->log("interface:".$this->server.$url);
		$this->log(" send :".$json);
		$cl->set(CURLOPT_URL,$this->server.$url);
		$ret = $cl->post($json);
		$this->log("sendpost:".$ret);
		$this->log('------------');
		return json_decode($ret);
	}
	private function recv($mkey,$url,$msg){
		$obj = false;
		if( $mkey ){
			$obj =MC::GET($mkey);
		}
		if(!$obj){
			$obj = $this->send($url,$msg);
			if( isset($obj->state) && ($obj->state == '0000' || $obj->state == '2000') ){
				MC::SET($mkey,$obj);
				return $obj;
			}else{
				$logmsg  = "ALERT:mkey=".$mkey."\r\nurl=".$url."\r\ndata=".$msg;
				$logmsg .= "result:".$obj."\r\n";
				if( ($fp = @fopen(TTROOT."/log/appstore_error.log",'a+')) !== false){
					fwrite(date("Y-m-d H:i:s",time())." -- ".$logmsg."\r\n-----------------------------");
					fclose($fp);
				}
				$S = new SMTP($this->C->email['server'],$this->C->email['port'],true,$this->C->email['user'],$this->C->email['pass'],$this->C->email['helo'],$this->C->email['log'],$this->C->email['debug']);
				$altmsg = Conf::INI(TTROOT."/config/alertmsg.ini");
				$subject = "接口调用失败：".$url;
				$email = implode(",",$altmsg->mailto);
				$ret = $S->sendmail($email,$this->C->email['from'],$subject,$logmsg,'html');
			}
		}
		return $obj;
	}
	public function getSmartTV($mkey,$page,$size){
		$msg = new stdClass();
		$msg->title = 'TV_SMRAT';
		$msg->start = $page;
		$msg->count = $size;
		return $this->recv($mkey,'/appstore/developer/getSmartTV',$msg);
	}
	public function getTVRecommandAndRank($mkey,$title,$page,$size,$ord='N'){
		$titleArr = array('game'=>'TV_GAME_RANK','soft'=>'TV_SOFTWARE_RANK','tj'=>'TV_GAME_SOFTWARE_RECOMMAND');
		if(!in_array($title,$titleArr))return $this->back(2,'title error');
		$msg = new stdClass();
		$msg->title = $title;
		$msg->start = $page;
		$msg->count = $size;
		$msg->orderFlg = $ord;
		return $this->recv($mkey,'/appstore/developer/getTVRecommandAndRank',$msg);
	}
	/*
	$page  ---  class page
	$size ----  class size
	$flg ----   取得第一个分类的数据
	$ord ----	排序
	cpage --- 分类启始数
	csize ---- 分类数量
	*/
	public function getAppClasses($mkey,$page,$size,$flg=false,$ord='N',$cpage=1,$csize=8){
		$msg = new stdClass();
		$cls = new stdClass();
		$msg->start = $cpage;
		$msg->count = $csize;
		$cls->start = $page;
		$cls->count = $size;
		$cls->orderFlg = $ord;
		if($flg)$msg->appClass = $cls;
		return $this->recv($mkey,'/appstore/developer/getAppClasses',$msg);
	}
	public function getAllAppInfos($mkey,$page,$size,$ord='N'){
		$msg = new stdClass();
		$msg->start = $page;
		$msg->count = $size;
		$msg->orderFlg = $ord;
		return $this->recv($mkey,'/appstore/developer/getAllAppInfos',$msg);
	}
	public function getAppClass($mkey,$clsid,$page,$size,$ord='N'){
		$msg = new stdClass();
		$cls = new stdClass();
		$cls->start = $page;
		$cls->count = $size;
		$cls->orderFlg = $ord;
		$cls->classid = $clsid;
		$msg->appClass = $cls;
		return $this->recv($mkey,'/appstore/developer/getAppClass',$msg);
	}
	public function getAppDetail($mkey,$appkey){
		$msg = new stdClass();
		$msg->appkey = $appkey;
		$cls= new stdClass();
		$cls->start=1;
		$cls->count=9;
		$msg->recommand=$cls;
		return $this->recv($mkey,'/appstore/developer/getAppDetail',$msg);
	}
	public function searchAppInfos($mkey,$title,$page,$size){
		$msg = new stdClass();
		$msg->title = $title;
		$msg->start = $page;
		$msg->count = $size;
		return $this->recv($mkey,'/appstore/developer/searchAppInfos',$msg);
	}
	public function saveFavoriteApp($huanid,$appkey){
		$msg = new stdClass();
		$msg->huanid = $huanid;
		$msg->appkey = $appkey;
		return $this->recv('','/appstore/developer/saveFavoriteApp',$msg);
	}
	public function getFavoriteAppInfosByHuanid($huanid,$page,$size){
		$msg = new stdClass();
		$msg->huanid = $huanid;
		$msg->page   = $page;
		$msg->count  = $size;
		return $this->recv('','/appstore/developer/getFavoriteAppInfosByHuanid',$msg);
	}

	public function getHuanAbout($mkey){
		return $this->getcurl($mkey,'/api.php?mod=huanabout');
	}
	public function getHotTag($mkey){
		return $this->getcurl($mkey,'/api.php?mod=hottag');
	}
	public function getHuanType($mkey,$type){
		return $this->getcurl($mkey,'/api.php?mod=huan&type='.$type);
	}
	public function getHuanAds($mkey,$type){
		return $this->getcurl($mkey,'/api.php?mod=huanads&type='.$type);
	}
	public function getHuanHelp($mkey,$type='',$id=''){
		return $this->getcurl($mkey,'/api.php?mod=huanhelp&type='.$type.'&id='.$id);
	}
	public function getFriendLink($mkey){
		return $this->getcurl($mkey,'/api.php?mod=friendlink');
	}
	public function getInfoList($mkey,$id){
		$url='/api.php?mod=js&bid='.$id;
		$obj = false;
		if($mkey){
			$obj = MC::GET($mkey);
		}
		if(!$obj){
			$c = new CURL('');
			$o = $c->get($this->C->PROJECT['bbsurl'].$url);
			$obj=str_replace("document.write('",'',$o);
			$obj=str_replace("');",'',$obj);
			$obj=str_replace('\\n','',$obj);
			if($obj){
				MC::SET($mkey,$obj);
				return $obj;
			}
		}
		return $obj;
	}
	public function getSalon($mkey,$page,$pagesize=3){
		return $this->getcurl($mkey,"/api.php?mod=salon&pagesize=$pagesize&page=$page");
	}
	public function getPpzq($mkey){
		return $this->getcurl($mkey,'/api.php?mod=ppzq');
	}
	private function getcurl($mkey,$url){
		$obj = false;
		if($mkey){
			$obj = MC::GET($mkey);
		}
		if(!$obj){
			$c = new CURL('');
			$o = $c->get($this->C->PROJECT['bbsurl'].$url);
			$obj = json_decode($o);
			if($obj){
				MC::SET($mkey,$obj);
				return $obj;
			}
		}
		return $obj;
	}
}
?>