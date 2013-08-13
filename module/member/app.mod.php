<?php
define("APP",true);
class app extends GlobalMember {
	function __construct(){
		parent::__construct();
		$str = $this->memstate($this->U->status);
		if( $this->U->status != '800' )
			GF::MSG("您的账号状态为：".$str."，暂时无法使用本系统",$this->url("","member"));
	}
	function getState($s){
		$sArr = array('0'=>'待审核','100'=>'已上线','200'=>'已提测','300'=>'测试完毕','400'=>'审核打回','500'=>'申请发布','600'=>'申请下线','650'=>'停用','700'=>'审核中','750'=>'下线审核中','850'=>'申请上线打回','900'=>'已下线','950'=>'下线打回','9014'=>'APK包验证错误','9012'=>'APK版本重复');
		if( isset($sArr[$s]) )
			return $sArr[$s];
		else
			return " ";
	}
	function getgradetype($s){
		$sArr = array('100'=>'非强制升级','200'=>'强制升级');
		if( isset($sArr[$s]) )
			return $sArr[$s];
		else
			return " ";
	}
	function evetype($a)
	{
		$arr = array('1'=>'提测','2'=>'新增版本','3'=>'申请下线','4'=>'申请发布');
		if( isset($arr[$a]) )
			return $arr[$a];
		else
			return " ";
	}
	
	function send($obj,$url=''){
		$log=TTROOT."/log/developer_".date("m").".txt";
		$fp=fopen($log,'a+');
		global $CONF,$CURL;
		$CONF = new Conf();
		$CONF->GW = Conf::INI(TTROOT."/config/gateway.ini");
		$c = new CURL($CONF->GW['SERVER']['url'].$url,FALSE);
		fwrite($fp,date('Y-m-d H:i:s').' send: '.$obj ."\r\n");
		fwrite($fp,date('Y-m-d H:i:s').' URL: '.$CONF->GW['SERVER']['url'].$url ."\r\n");
		$s = $c->post($obj);
		$ret = $c->info();
		$c->close();
		fwrite($fp,date('Y-m-d H:i:s').' sendpost: '.$s ."\r\n");
		fwrite($fp,'------------------' ."\r\n");
		fflush($fp);
		fclose($fp);
		if( $ret['http_code'] != '200' ){
			throw new Exception("send data error:".$ret['http_code']);
		}
		return json_decode($s);
	}
	function getdeviceseq(){
		global $CONF,$CURL;
		$CONF = new Conf();
		$CONF->GW = Conf::INI(TTROOT."/config/gateway.ini");
		$c = new CURL($CONF->GW['SERVER']['deviceuri']);
		$s = $c->post('{"action":"GetDevmodelList"}');
		$ret = $c->info();
		$c->close();
		if( $ret['http_code'] != '200' ){
			throw new Exception($ret['http_code']);
		}
		return json_decode($s);
	}
	function myapp(){

	try{
		$obj = new stdClass();
		$obj->callid = time();
		$obj->devid= $this->U->huanid;
		$obj->start = "1";
		$obj->count = "100";
		$obj->apiversion = "1.0";
		$appl = $this->send(GF::JSON($obj),"/developer/queryAppListByDevid");
		if($appl->state !="0000")
			GF::MSG($appl->note,$this->url("","app"));
		}catch(Exception $e){											
				GF::MSG("网络错误:".$e->getMessage(),"back");
		}
		if(isset($appl->app))
		{
			$app= is_array($appl->app)?$appl->app:array($appl->app);
			$this->initmemcache();   
			$this->mset("key".$this->uid,$app);
			$val = $this->mget('key'.$this->uid);
			$vb = array();
			foreach($val as $key=>$v)
			{
				$va = $val[$key];
				if($va->status == "0")
				{
					if($va =="")
					{
						GF::MSG("网络错误，请稍等再试",$this->url("","member"));
					}
					$versions=is_array($va->version) ? $va->version : array($va->version);
					$version=end($versions);
					$va->servertime=$version->createtime;
					$va->status = $this->getState($va->status);
					$vb[] = $va;
				}
			}
			T::A("pag",DB::M());
			T::A("applist",$vb);
			
		}else{
			GF::MSG("您还没有添加应用，请添加后查看",$this->url("newapp","app"));
		}
		
		
	}
	function testing(){
	try{
		$obj = new stdClass();
		$obj->callid = time();
		$obj->devid= $this->U->huanid;
		$obj->start = "1";
		$obj->count = "100";
		$obj->apiversion = "1.0";
		$appl = $this->send(GF::JSON($obj),"/developer/queryAppListByDevid");
		if($appl->state !="0000")
			GF::MSG($appl->note,$this->url("","app"));
		}catch(Exception $e){											
				GF::MSG("网络错误:".$e->getMessage(),"back");
			}
		if(isset($appl->app))
		{
			$app= is_array($appl->app)?$appl->app:array($appl->app);
			$this->initmemcache();   
			$this->mset("key".$this->uid,$app);
			$val = $this->mget('key'.$this->uid);
			$vb = array();
			foreach($val as $key=>$v)
			{
				$va = $val[$key];
				if($va =="")
				{
					GF::MSG("网络错误，请稍等再试",$this->url("","member"));
				}
				elseif($va->status == "200" || $va->status == "300" || $va->status == "700" || $va->status == "500")
				{
					$va->status = $this->getState($va->status);
					$versions=is_array($va->version) ? $va->version : array($va->version);
					$version=end($versions);
					$va->servertime=$version->createtime;
					$vb[] = $va;
				}
			}
			T::A("pag",DB::M());
			T::A("applist",$vb);
		}else{
			GF::MSG("您还没有添加应用，请添加后查看",$this->url("newapp","app"));
		}
	}
	function myback(){
		
		try{
		$obj = new stdClass();
		$obj->callid = time();
		$obj->devid= $this->U->huanid;
		$obj->start = "1";
		$obj->count = "100";
		$obj->apiversion = "1.0";
		$appl = $this->send(GF::JSON($obj),"/developer/queryAppListByDevid");
		if($appl->state !="0000")
			GF::MSG($appl->note,$this->url("","app"));
		}catch(Exception $e){											
				GF::MSG("网络错误:".$e->getMessage(),"back");
		}
		if(isset($appl->app))
		{
			$app= is_array($appl->app)?$appl->app:array($appl->app);
			$this->initmemcache();
			$this->mset("key".$this->uid,$app);
			$val = $this->mget('key'.$this->uid);
			$vb = array();
			foreach($val as $key=>$v)
			{
				$va = $val[$key];
				if($va =="")
					{
						GF::MSG("网络错误，请稍等再试",$this->url("","member"));
					}
				if($va->status == "400" || $va->status == "850")
				{
					$va->status = $this->getState($va->status);	
					$versions=is_array($va->version) ? $va->version : array($va->version);
					foreach($versions as $version){
						if($version->status==400) {
							$data=new stdClass();
							$data->curver=$version->ver;
							$data->verid=$version->verid;
							$data->status=$va->status;
							$data->servertime=$version->createtime;
							$data->series=$va->series;
							$data->apptype=$va->apptype;
							$data->name=$va->name;
							$data->appkey=$va->appkey;
							$vb[] = $data;
							break;
						}
					}
					
				}
			}
			T::A("pag",DB::M());
			T::A("applist",$vb);
		}else{
			GF::MSG("您还没有添加应用，请添加后查看",$this->url("newapp","app"));
		}
	}
	function online(){
		
		try{
		$obj = new stdClass();
		$obj->callid = time();
		$obj->devid= $this->U->huanid;
		$obj->start = "1";
		$obj->count = "100";
		$obj->apiversion = "1.0";
		$appl = $this->send(GF::JSON($obj),"/developer/queryAppListByDevid");
		if($appl->state !="0000")
			GF::MSG($appl->note,$this->url("","app"));
		}catch(Exception $e){											
				GF::MSG("网络错误:".$e->getMessage(),"back");
			}
		if(isset($appl->app))
		{
			$app= is_array($appl->app)?$appl->app:array($appl->app);
			$this->initmemcache();   
			$this->mset("key".$this->uid,$app);
			$val = $this->mget('key'.$this->uid);
			$vb = array();
			
			foreach($val as $key=>$v)
			{
				$va = $val[$key];
				if($va =="")
					{
						GF::MSG("网络错误，请稍等再试",$this->url("","member"));
					}
				if($va->status == "100")
				{
					$va->status = $this->getState($va->status);
					$versions=is_array($va->version) ? $va->version : array($va->version);
					$version=end($versions);
					$va->servertime=$version->createtime;
					$vb[] = $va;
				}
			}
			T::A("pag",DB::M());
			T::A("applist",$vb);
		}else{
			GF::MSG("您还没有添加应用，请添加后查看",$this->url("newapp","app"));
		}
	}
	function offapp(){	
	try{
		$obj = new stdClass();
		$obj->callid = time();
		$obj->devid= $this->U->huanid;
		$obj->start = "1";
		$obj->count = "100";
		$obj->apiversion = "1.0";
		$appl = $this->send(GF::JSON($obj),"/developer/queryAppListByDevid");
		if($appl->state !="0000")
			GF::MSG($appl->note,$this->url("","app"));
		}catch(Exception $e){											
				GF::MSG("网络错误:".$e->getMessage(),"back");
			}
		if(isset($appl->app))
		{
			$app= is_array($appl->app)?$appl->app:array($appl->app);
			$this->initmemcache();   
			$this->mset("key".$this->uid,$app);
			$val = $this->mget('key'.$this->uid);
			$vb = array();
			
			foreach($val as $key=>$v)
			{
				$va = $val[$key];
				if($va =="")
					{
						GF::MSG("网络错误，请稍等再试",$this->url("","member"));
					}
				if($va->status == "600" || $va->status == "750")
				{
					$va->status = $this->getState($va->status);
					$versions=is_array($va->version) ? $va->version : array($va->version);
					$version=end($versions);
					$va->servertime=$version->createtime;
					$vb[] = $va;
				}
			}
			T::A("pag",DB::M());
			T::A("applist",$vb);
		}else{
			GF::MSG("您还没有添加应用，请添加后查看",$this->url("newapp","app"));
		}
	}
	
	/**
	 * 下线打回作品
	 */
	function offback(){	
	try{
		$obj = new stdClass();
		$obj->callid = time();
		$obj->devid= $this->U->huanid;
		$obj->start = "1";
		$obj->count = "100";
		$obj->apiversion = "1.0";
		$appl = $this->send(GF::JSON($obj),"/developer/queryAppListByDevid");
		if($appl->state !="0000")
			GF::MSG($appl->note,$this->url("","app"));
		}catch(Exception $e){											
				GF::MSG("网络错误:".$e->getMessage(),"back");
			}
		if(isset($appl->app))
		{
			$app= is_array($appl->app)?$appl->app:array($appl->app);
			$this->initmemcache();   
			$this->mset("key".$this->uid,$app);
			$val = $this->mget('key'.$this->uid);
			$vb = array();
			
			foreach($val as $key=>$v)
			{
				$va = $val[$key];
				if($va =="")
					{
						GF::MSG("网络错误，请稍等再试",$this->url("","member"));
					}
				if($va->status == "950")
				{
					$va->status = $this->getState($va->status);
					$versions=is_array($va->version) ? $va->version : array($va->version);
					$version=end($versions);
					$va->servertime=$version->createtime;
					$vb[] = $va;
				}
			}
			T::A("pag",DB::M());
			T::A("applist",$vb);
		}else{
			GF::MSG("您还没有添加应用，请添加后查看",$this->url("newapp","app"));
		}
	}
	
	
	function offline(){
		
	try{
		$obj = new stdClass();
		$obj->callid = time();
		$obj->devid= $this->U->huanid;
		$obj->start = "1";
		$obj->count = "100";
		$obj->apiversion = "1.0";
		$appl = $this->send(GF::JSON($obj),"/developer/queryAppListByDevid");
		if($appl->state !="0000")
			GF::MSG($appl->note,$this->url("","app"));
		}catch(Exception $e){											
				GF::MSG("网络错误:".$e->getMessage(),"back");
			}
		if(isset($appl->app))
		{
			$app= is_array($appl->app)?$appl->app:array($appl->app);
			$this->initmemcache();   
			$this->mset("key".$this->uid,$app);
			$val = $this->mget('key'.$this->uid);
			$vb = array();
			
			foreach($val as $key=>$v)
			{
				$va = $val[$key];
				if($va =="")
					{
						GF::MSG("网络错误，请稍等再试",$this->url("","member"));
					}
				if($va->status == "900")
				{
					$va->status = $this->getState($va->status);
					$versions=is_array($va->version) ? $va->version : array($va->version);
					$version=end($versions);
					$va->servertime=$version->createtime;
					$vb[] = $va;
				}
			}
			T::A("pag",DB::M());
			T::A("applist",$vb);
		}else{
			GF::MSG("您还没有添加应用，请添加后查看",$this->url("newapp","app"));
		}
	}

	function newapp(){
		if($_POST || $this->A->CheckForm($this->A->Post("formhash")) ){
			$name = $this->A->Post("name");
			$appkey = $this->A->Post("key");
			if($name == "" || $appkey == "")
			{
				exit(json_encode(array('error'=>"请选择应用名及对应appkey，如没有请先申请appkey")));
				//GF::MSG("请选择应用名及对应appkey，如没有请先申请appkey",$this->url("newapp","app"));
			}
			
			$apkfile = $this->A->Post("apkfilename");
//			$a=$this->apk($apkfile);
			
			$ispay = $this->A->Post("ispay");
			$isad = $this->A->Post("isad");
			
			$desci = $this->A->Post("desci");
			$picnum = $this->A->Post("picnum");
			$attribute = $this->A->Post("attribute");
			$shopinshop = $this->A->Post("shopinshop");
			if($shopinshop=='')$shopinshop = "0";
			$operatetype = $this->A->Post("operatetype");
			$apptype = $this->A->Post("apptype");
			$fee = intval($this->A->Post("fee"));
			$deviceseq = $this->A->Post("deviceseq");
			if(is_array($deviceseq)){
				$devseq = implode(";",$deviceseq);
			}else{
				$devseq = $deviceseq;
			}
			
			$appicon= $this->A->Post("appicon");

			$spreadicon = $this->A->Post("spreadicon");

			$apppic1=$this->A->Post("apppic1");
			$apppic2=$this->A->Post("apppic2");
			$apppic3=$this->A->Post("apppic3");
			$apppic4=$this->A->Post("apppic4");
			$apppic5=$this->A->Post("apppic5");
			
			$obj = new stdClass();
			
			for($i=1;$i<=5;$i++){
				$var='apppic'.$i;
				if($$var !=''){
//					$obj->$var = $this->filter($$var);
					$obj->$var = $$var;
				}else{
					$obj->$var='';
				}
			}
			$upgradetype = $this->A->Post("upgradetype");
			
		try{
			
			$obj->callid = time();
			$obj->devid = $this->U->huanid;
			$obj->name =  $name;
			$obj->app = $apkfile;
			$obj->upgrade = "0";
			$obj->vurver = "1.0";
			$obj->appkey = $appkey;
			$obj->apptype = $apptype;
	
			$obj->shopinshop = $oshopinshop;
			$obj->category = $category==""?"0":$category;
			$obj->subcategory = $subcategory==""?"0":$subcategory;
			$obj->ispay = $ispay;
			$obj->isad = $isad;
			$obj->status = $status;
			$obj->series = $devseq;
			$obj->fee = $fee;
			$obj->desci = $desci;
			$obj->memo = $memo==""?"0":$memo;
			$obj->resratio = $resratio==""?"0":$resratio;
			$obj->appicon =  $appicon;
			$obj->spreadicon =  $spreadicon;
		
			$obj->level = $level==""?"0":$level;
			$obj->operatetype = $operatetype;
			$obj->addon = $addon==""?"0":$addon;
			$obj->attribute = $attribute;
			$obj->apiversion = "1.0";

			$appl = $this->send(GF::JSON($obj),"/developer/saveAppInfo");
			if($appl->state != "0000")
			{
				exit(json_encode(array('error'=>$appl->note)));
				GF::MSG($appl->note,$this->url("newapp","app"));
			}
			
		}catch(Exception $e){
				exit(json_encode(array('error'=>"网络错误:".$e->getMessage())));											
			}
			exit(json_encode(array('success'=>$this->url("myapp","app"))));
			//GF::MSG("提交成功",$this->url("myapp","app"));
				
		}
		else
		{
			$obj = new stdClass();
			$obj->callid = time();
			$obj->devid= $this->U->huanid;
			$obj->start = "1";
			$obj->count = "100";
			$obj->apiversion = "1.0";
			try{
				$app = $this->send(GF::JSON($obj),"/developer/getAppkeyListByDevid");
			}catch(Exception $e){
				GF::MSG("网络错误:".$e->getMessage(),"back");
			}
			
			if($app->state != "0000")
			{
				GF::MSG($app->note,$this->url("appkey","appkeymanage"));
			}
			if(!isset($app->appkeynode))
			{
				GF::MSG("您还没有可用的appkey，请申请后操作",$this->url("appexplain","appkey"));
			}
			$appl= is_array($app->appkeynode)?$app->appkeynode:array($app->appkeynode);
			$applist=array();
			foreach($appl as $key=>$v)
			{
				if($v->isused == 1)
					continue;
				$v->name=$v->appname;
				$applist[]=$v;
			}
			if(count($applist) < 1)
			{
				GF::MSG("您还没有可用的appkey，请申请后操作",$this->url("appexplain","appkey"));
			}
			$page = $this->A->Get("page");
			$type = $this->A->Get("type");
			$ords = $this->A->Get("ords");
			$appname = $this->A->Get("app");
			$appkey = $this->A->Get("key");
			$pay = $this->A->Get("pay");
			$ad = $this->A->Get("ad");
			
			T::A("appkey",$appkey);
			T::A("pay",$pay);
			T::A("ad",$ad);
			T::A("appname",$appname);

			T::A("applist",$applist); 
			T::A("SESSIONID",session_id());
			$fsize = $this->C->pic['maxsize'];
			$apkfsize = $this->C->apk['maxsize'];
			$filetype = "*.jpg;*.png;*.gif;*.jpeg";
			$filedesc = "Web Image Files";
			$upnum = "2";
			T::A("upnum",$upnum);
			T::A('uploadmode','0');
			T::A("fsize",$fsize);
			T::A("apkfsize",$apkfsize);
			T::A("filetype",$filetype);
			T::A("filedesc",$filedesc);
		}
	}
	
	function modify()
	{    
		$this->initmemcache();
		$val = $this->mget("key".$this->uid);
        if($_POST || $this->A->CheckForm($this->A->Post("formhash")) ){
			$appkey = $this->A->Post('id');	
			$name = $this->A->Post("name");
			$desci = $this->A->Post("desci");
		//	$picnum = $this->A->Post("picnum");
			$attribute = $this->A->Post("attribute");
			$shopinshop = $this->A->Post("shopinshop");
			$upgradetype = $this->A->Post("upgradetype");
			if($shopinshop=='')$shopinshop = "0";
			$operatetype = $this->A->Post("operatetype");
			$apptype = $this->A->Post("apptype");
			$fee = intval($this->A->Post("fee"));
			$deviceseq = $this->A->Post("deviceseq");
			if(is_array($deviceseq)){
				$devseq = implode(";",$deviceseq);
			}else{
				$devseq = $deviceseq;
			}
		
			$obj = new stdClass();
			$obj->callid = time();
			$obj->devid = $this->U->huanid;
			$obj->name =  $name;
			$obj->appkey = $appkey;
			$vb = array();
			foreach($val as $key=>$v)
			{
				if($v =="")
				{
					exit(json_encode(array('error'=>"网络错误，请稍等再试")));
					//GF::MSG("网络错误，请稍等再试",$this->url("","member"));
				}
				if($v->appkey == $appkey)
				{
					$vb[] = $v;
				}
				
			}
			
			$p = $vb[0];
			$versions=is_array($p->version) ? $p->version : array($p->version);
			foreach ($versions as $version) {
				if($version->status==400) {
					$u=$version;
					break;
				}
			}
			$u = $p->version;
			$appicon= $this->A->Post("appicon");
			if($appicon!="")
			{
				$obj->appicon =  $appicon;
			}else{
				$obj->appicon=$p->appicon;
			}
			$spreadicon = $this->A->Post("spreadicon");
			if($spreadicon !="")
			{
				$obj->spreadicon = $spreadicon;
			}else{
				$obj->spreadicon=$p->spreadicon;
			}
			if($this->A->Post("apppic1")!='' || $this->A->Post("apppic2")!='' || $this->A->Post("apppic3")!='' || $this->A->Post("apppic4")!='' || $this->A->Post("apppic5")!='' ){
				$apppic1=$this->A->Post("apppic1");
				$apppic2=$this->A->Post("apppic2");
				$apppic3=$this->A->Post("apppic3");
				$apppic4=$this->A->Post("apppic4");
				$apppic5=$this->A->Post("apppic5");
				for($i=1;$i<=5;$i++){
					$var='apppic'.$i;
					if($$var !='' && $$var !='del'){
						$img = $$var;
						$obj->$var=$img;
					}else{
						$obj->$var='';
						if($$var !='del'){
							$obj->$var=$p->$var =='' ? '' : $p->$var;
						}
					}	
				}
			}else{
				for($i=1;$i<=5;$i++){
					$var='apppic'.$i;
					$obj->$var=$p->$var;
				}
			}

			$upgradetype = $this->A->Post("upgradetype");
			$apkfile = $this->A->Post("apkfilename");
			if($apkfile !=''){
				$obj->app = $apkfile;
			}else{
				$obj->app = $p->cururl;
			}
			$obj->shopinshop = $p->shopinshop;
			$obj->category = $p->category==""?"0":$p->category;
			$obj->subcategory = $p->subcategory==""?"0":$p->subcategory;
			
			$obj->level = $level==""?"0":$level;
			$obj->ispay = $ispay;
			$obj->isad = $isad;
			$obj->status = $p->status;
			$obj->memo = $p->memo==""?"0":$p->memo;
			$obj->resratio = $p->resratio==""?"0":$p->resratio;

			$obj->upgrade = $upgradetype;
			$obj->desci = $desci;
			$obj->attribute = $attribute;
			$obj->operatetype = $operatetype;
			$obj->fee =$fee;
			$obj->series = $devseq;
			$obj->apiversion = "1.0";
			$obj->vurver = "1.0";
			$obj->apptype = $apptype;
			$obj->addon = $addon==""?"0":$addon;
			try{
				$appl = $this->send(GF::JSON($obj),"/developer/saveAppInfo");
				if($appl->state != "0000")
				{
					exit(json_encode(array('error'=>$appl->note)));
				}
				else{
					exit(json_encode(array('success'=>$this->url("myapp","app"))));
				}						
			}catch(Exception $e){
				exit(json_encode(array('error'=>"网络错误:".$e->getMessage())));	
			}        			
		}
		else
		{
			$appkey = $this->A->Get("id");
			$vb = array();
			foreach($val as $k=>$v)
			{
				$va = $val[$k];
				if($va =="")
				{
					GF::MSG("网络错误，请稍等再试",$this->url("","member"));
				}
				elseif($va->appkey == $appkey)
				{
					$vb[] = $va;
				}
			}
			$p = $vb[0];
			$u = $p->version;
			$str = $p->status;
			if($str !=400 && $str !=850 && $str !=950){
			GF::MSG("此应用在该状态下不能进行这个操作！","back");
			}
			
			$p->status = $this->getState($p->status);
			if(is_array($u))
			{
				$u[0]->upgradetype = $this->getgradetype($u[0]->upgradetype);
				T::A("u",$u[0]);
			}
			if(is_object($u))
			{
				$u->upgradetype = $this->getgradetype($u->upgradetype);
				T::A("u",$u);
			}
			$ck = explode(";",$p->series);	
			T::A("appkey",$appkey);
			T::A("seq",$ck);
			T::A("A",$p);
			T::A("SESSIONID",session_id());
			
			
		}
	}
	
	function view()
	{
		
			$name = $this->A->Get("name");
			$appkey = $this->A->Get("id");
			$this->initmemcache();
			$val = $this->mget('key'.$this->uid);
			$vb=array();
			foreach($val as $key=>$v)
			{
				$va = $val[$key];
				if($va->appkey == $appkey)
				{
					$vb[] = $va;
				}
			}
			$operateArr = array('100'=>'单机','200'=>'在线');
			$p = $vb[0];
			
			$u = $p->version;
			if(is_array($u))
			{
				$u[0]->upgradetype = $this->getgradetype($u[0]->upgradetype);
				T::A("u",$u[0]);
			}
			if(is_object($u))
			{
				$u->upgradetype = $this->getgradetype($u->upgradetype);
				T::A("u",$u);
			}
			$p->status = $this->getstate($p->status);
			$p->operatetype = $operateArr[$p->operatetype];
			$apppic = array($p->apppic1,$p->apppic2,$p->apppic3,$p->apppic4,$p->apppic5);
			T::A("apppic",$apppic);
			T::A("A",$p);
	
	}
	function backmsg()
	{
		$this->initmemcache();
		$val = $this->mget("key".$this->uid);
		$appkey = $this->A->Get("id");
		foreach($val as $key=>$v)
		{
			$va = $val[$key];
			if($va =="")
				{
					GF::MSG("网络错误，请稍等再试",$this->url("","member"));
				}
			if($va->appkey == $appkey)
			{
				if($va->status=="400" || $va->status=="850" || $va->status=="950")
				{	
					$msg = $va->refuseinfo;
				}else{
					GF::MSG("该应用不在此状态,无法查看","back");
				}
			}
		}
		T::A("pag",DB::M());
		T::A("msg",$msg);
	}
	function delapp()
	{
			$appkey = $this->A->Get("id");
			$verid	= $this->A->Get("verid");
			if($appkey == '' || $verid == '') {
				GF::MSG("没有这条记录！请核对",$this->url("myback"));
			}
			$obj=new StdClass();
			$obj->callid=time();
			$obj->apiversion="1.0";
			$app=new StdClass();
			$app->appkey=$appkey;
			$app->verid=$verid;
			$obj->app=$app;
			$res = $this->send(GF::JSON($obj),"/developer/deleteAppVersionsByAppkeyAndVer");
			if($res->state != "0000")
			{
				GF::MSG($res->note,$this->url("myback"));			
			}
			else{
				GF::MSG("删除成功",$this->url("myback"));
			}		
			
	}
	
	function filter($file){
		global $CONF,$CURL;
		$CONF = new Conf();
		$CONF->GW = Conf::INI(TTROOT."/config/gateway.ini");
		$u = $CONF->GW['SERVER']['pichost'];
			return $u."?type=app&file=".$file;
	}
	
	function apk($apkfile)
	{
		$a = new APK();
		$a->open(TTROOT . "/static/temp/".$apkfile);
		if($a->getPackage()=="" || $a->getVersionName()=="")
		{
			exit(json_encode(array('error'=>"无法解析到包名或者版本号")));
		}
		return $a;
	}
	
	
	function addnew()
	{
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$appkey = $this->A->Post("k");
			$appname = $this->A->Post("n");
			$filetype = $this->A->Post("filetype");
			$upgradetype = $this->A->Post("upgradetype");
			$apkfile = $this->A->Post("filename");
			
			try{
				$obj = new stdClass();
				$obj->callid = time();
				$obj->appkey = $appkey;
				$obj->app = $apkfile;
				$obj->upgradetype = $upgradetype;
				$obj->apiversion = "1.0";
				$appl = $this->send(GF::JSON($obj),"/developer/upgradeAppInfo/");
				if($appl->state != "0000")
				{
					GF::MSG($appl->note,$this->url("addnew&n=".$appname."&k=".$appkey,"app"));
				}
				else{
					GF::MSG("提交成功",$this->url("myapp","app"));
				}
			}catch(Exception $e){
					GF::MSG("网络异常",$this->url("addnew&n=".$appname."&k=".$appkey,"app"));											
				}
		}else{
			$appname = $this->A->Get("n");
			$appkey =$this->A->Get("k");
			if($appname =="" || $appkey=="")
			{
//				GF::MSG("请先选择需要增加版本的应用",$this->url("online","app"));
			}
			T::A("n",$appname);
			T::A("k",$appkey);
			$fsize = $this->C->apk['maxsize'];
			$filetype = "*.apk";
			$filedesc = "APK";
			$upnum = 1;
			T::A("upnum",$upnum);
			T::A("fsize",$fsize);
			T::A('uploadmode','0');
			T::A("filetype",$filetype);
			T::A("filedesc",$filedesc);
			T::A("SESSIONID",session_id());
		}
	}
	
	function applyoff()
	{
	    if($this->A->CheckForm($this->A->Post("formhash")) ){
			 $appkey = $this->A->Post("id");
			 $appname = $this->A->Post("appname");
			 $memo = $this->A->Post("memo");
			 if(empty($memo))
			 {
				GF::MSG("请填写申请下线理由！","back");
			 }
			try{
				$obj = new stdClass();
				$obj->callid = time();
				$obj->appkey = $appkey;
				$obj->reason=$memo;
				$obj->apiversion = "1.0";
				$s = $this->send(GF::JSON($obj),"/developer/downlineApp");
				if($s->state =="0000")
					{
						GF::MSG("提交成功",$this->url("online"));
					}
			}catch(Exception $e){											
				GF::MSG("网络异常",$this->url("applyoff&id=".$appkey."&name=".$appname,"app"));
			}
		}
			 else 
			 { 
				
				 $appname =$this->A->Get("name");
				 $id = $this->A->Get("id");
				 T::A("appid",$id);
				 T::A("appname",$appname);
			 }
	}

}
?>
