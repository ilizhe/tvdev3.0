<?php
define("APPKEY",true);
class appkey extends GlobalMember {
	function __construct(){
		parent::__construct();
		$str = $this->memstate($this->U->status);
		if( $this->U->status != '800' )
			GF::MSG("您的账号状态为：".$str."，暂时无法使用本系统",$this->url("","member"));
	}
	function appexplain(){
		
	}
	function applyappkey(){
		
	}
	function send($obj,$url=''){
		global $CONF,$CURL;
		$CONF = new Conf();
		$CONF->GW = Conf::INI(TTROOT."/config/gateway.ini");
		$c = new CURL($CONF->GW['SERVER']['url'].$url);
		$s = $c->post($obj);
		$ret = $c->info();
		$c->close();
		if( $ret['http_code'] != '200' ){
			throw new Exception($ret['http_code']);
		}
		return json_decode($s);
	}
	function sendex($obj){
		global $CONF,$CURL;
		$CONF = new Conf();
		$CONF->GW = Conf::INI(TTROOT."/config/gateway.ini");
		$c = new CURL($CONF->GW['SERVER']['deviceuri']);
		$s = $c->post($obj);
		$ret = $c->info();
		$c->close();
		if( $ret['http_code'] != '200' ){
			throw new Exception($ret['http_code']);
		}
		return json_decode($s);
	}
	function getappkey(){
			$appname = $this->A->Post("appname");
			$cappname = $this->A->Post("cappname");
			if($appname=="" || $cappname=="")
			{
				GF::MSG("应用名不能为空","back");
			}
			if($appname!=$cappname)
			{
				GF::MSG("两次输入作品名称不同，请核对","back");
			}
			try{
				$e = false;
				$obj = new stdClass();
				$obj->callid = time();
				$obj->appname = $appname;
				$obj->devid= $this->U->huanid;
				$obj->apiversion = "1.0";
				$s = $this->send(GF::JSON($obj),"/developer/getAppkey");
				if($s->state != "0000")
				{
					GF::MSG($s->note,$this->url("appkey","getAppkey"));
				}
				$appkey = $s->appkey;
				GF::MSG("申请成功,请开通相关权限",$this->url("appkeymanage","appkey"));
			}catch(exception $e){											
				GF::MSG("网络错误:".$e->getMessage(),"back");
			}
			
	}
	function appkeymanage(){
		$appname = $this->A->Post("appname");
		try{
				$e = false;
				$obj = new stdClass();
				$obj->callid = time();
				$obj->devid= $this->U->huanid;
				$obj->start = "1";
				$obj->count = "100";
				$obj->apiversion = "1.0";
				$app = $this->send(GF::JSON($obj),"/developer/getAppkeyListByDevid");
				if($app->state != "0000")
				{
					GF::MSG($app->note,$this->url("appkey","appkeymanage"));
				}
				if(!isset($app->appkeynode))
				{
					GF::MSG("您还没有可用的appkey，请申请后操作",$this->url("appexplain","appkey"));
				}
				$appl= is_array($app->appkeynode)?$app->appkeynode:array($app->appkeynode);
				$vb = array();
				if($appname !="")
				{
					foreach($appl as $key=>$v)
					{
						$a = $appl[$key];
						if($a->appname == $appname)
						{
							$vb[] = $a;
						}
					}
				}
				if($appname !="")
				{
					$appl = $vb;
				}
				T::A("applist",$appl);
			}catch(exception $e){	
				GF::MSG("网络错误:".$e->getMessage(),"back");
			}
		
	}
	function updateappkey(){
		$type=$this->A->Get("type");
		$appname = $this->A->Get("appname");
		$appkey = $this->A->Get("key");
		try{
				$e = false;
				$obj = new stdClass();
				$obj->callid = time();
				$obj->appkey = $appkey;
				$obj->type= $type;
				$obj->apiversion = "1.0";
					$s = $this->send(GF::JSON($obj),"/developer/updateAppkeyAuth");
					$state = $s->state;
					if($state == "0000")
					{
						GF::MSG("开通成功",$this->url("newapp","app"));
					}else{
						GF::MSG("开通失败,请重试",$this->url("appkeymanage","appkey"));
					}
			}catch(exception $e){											
				GF::MSG("错误:".$e->getMessage(),"back");
			}
	}
}
?>
