<?php
if(!defined("MEMBER")) define("MEMBER",2);

class company extends GlobalMember {
	var $A;
	var $C;
	var $M;
	var $uid = 0;
	
	function send($obj,$url=''){
		$log=TTROOT."/log/comextent_".date("m").".txt";
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
	
	function active(){

		T::A("U",$this->U);
	}
	function comp(){
			if($this->U->active != "1")
			{
				GF::MSG("请您先激活邮箱后再选择会员类型","back");
			}
			if($this->U->devtype !="-1")
			{
				GF::MSG("您已经申请为公司会员，不能再次申请",$this->url("","company"));
			}
			$q = DB::Q("select * from comextent where developerid='{$this->uid}'");
			if(DB::N($q) <= 0 )
			{
				DB::Q("insert comextent(developerid,email) value('{$this->uid}','{$mail}')");
				DB::Q("update ".UC_DBTABLEPRE."members  set devtype='1' where uid='{$this->uid}'");
				GF::MSG("您选择了公司申请，请填写相关资料",$this->url("info"));
			}
	}
	function info(){
		if($this->U->devtype == "-1"){
			GF::MSG("请先选择会员类型",$this->url("select","member"));
		}
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$name = $this->A->Post("name");
			$email = $this->A->Post("email");
			$enname = $this->A->Post("enname");
			$website = $this->A->Post("website");
			$provid = $this->A->Post("provid");
			$cityid = $this->A->Post("cityid");
			$townid = $this->A->Post("townid");
			$pctaddr = GF::PCT($provid,$cityid,$townid);
			$address = $this->A->Post("address");
			$telephone   = $this->A->Post("telephone");
			$fax = $this->A->Post("fax");
			$postal = $this->A->Post("postal");
			$contactperson = $this->A->Post("contactperson");
			$contactjob = $this->A->Post("contactjob");
			$mobile  = $this->A->Post("mobile");
			$contactqq= $this->A->Post("contactqq");
            $contactmsn = $this->A->Post("contactmsn");
			$sql = "update comextent set name='{$name}',enname='{$enname}',website='{$website}',provid='{$provid}',cityid='{$cityid}',townid='{$townid}',pctaddr='".$pctaddr->prov.$pctaddr->city.$pctaddr->town."',address='{$address}',mobile='{$mobile}',telephone='{$telephone}',fax='{$fax}',postal='{$postal}',contactperson='{$contactperson}',contactjob='{$contactjob}',contactqq='{$contactqq}',contactmsn='{$contactmsn}' where developerid='{$this->U->uid}'";
			DB::Q($sql);
			if($this->U->status=='800')
			{
				$obj=$this->gateway($this->uid);
				try{
					$ret=$this->send(GF::JSON($obj),'/developer/regOrUpdateDevInfo');
					if($ret->state !="0000") GF::MSG($ret->note,$this->url("upgradeinfo"));
				}catch(Exception $e)
				{
					GF::MSG("网络错误:".$e->getMessage(),"back");
				}
			}
			GF::MSG("更新成功",$this->url("info"));
		}else{
			T::A("U",$this->U);
		}
	}
/*
申请签约：200,APPLY
已签约：800,SIGN
未通过签约：300,NOTPASS
暂停：500,PAUSE
注销：400,DEPRECATED*/

	function upgrade(){
		switch($this->U->status){
			case "800":
			case "200":
			case "500":
			case "400":
			case "300":
				T::A("U",$this->U);
				break;
			default:
				GF::MSG("请先签约",$this->url("upgradeinfo"));
				break;
		}
	}
	function upgradeinfo(){
		if( $this->U->status>'0' && $this->U->status != '300' )GF::HD($this->url("upgrade"));
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			if( $this->A->Post("verify") != "1" )
				GF::MSG("您必须同意此合同",$this->url("upgradeinfo"));
			$license = $this->A->Post("license");
			$filename = $this->A->Post("filename");
			
			$introduction = $this->A->Post("introduction");
			$bank = $this->A->Post("bank");
			$bankaddress = $this->A->Post("bankaddress");
			$bankphone = $this->A->Post("bankphone");
			$bankaccountname = $this->A->Post("bankaccountname");
			$bankaccount = $this->A->Post("bankaccount");
			if( mb_strlen($bankaccountname,'utf8') >100)GF::MSG("开户行超长",$this->url("upgradeinfo"));
			$sql = "update comextent set license='{$license}'";
			$sql .= (strlen($filename)>3)?",licensepic='{$filename}'":'';
			$sql .= ",introduction='{$introduction}',bank='{$bank}',bankaddress='{$bankaddress}',bankphone='{$bankphone}',bankaccountname='{$bankaccountname}',bankaccount='{$bankaccount}' where developerid='{$this->U->uid}'";
			DB::Q($sql);
			DB::Q("update ".UC_DBTABLEPRE."members  set status='200' where uid='{$this->uid}'");
			$obj=$this->gateway($this->uid);
			try{
				$ret=$this->send(GF::JSON($obj),'/developer/regOrUpdateDevInfo');
				if($ret->state !="0000"){
					DB::Q("update ".UC_DBTABLEPRE."members set refuseinfo='{$ret->note}',status='300' where huanid='{$this->uid}'");
					GF::MSG($ret->note,$this->url("upgradeinfo"));
				} 
			}catch(Exception $e)
			{
				GF::MSG("网络错误:".$e->getMessage(),"back");
			}
			GF::MSG("申请签约资料已提交，稍后客服人员会与您联系核实信息，请耐心等待，谢谢！",$this->url("upgrade"));
		}else{
			if( $this->U->name == "" || $this->U->contactperson == "" || $this->U->mobile == "" )
				GF::MSG("您的基本资料还不完整，请先填写",$this->url("info"));
			T::A("U",$this->U);
			T::A("SESSIONID",session_id());
			$fsize = $this->C->pic['maxsize'];
			$filetype = "*.jpg;*.gif;*.png";
			$filedesc = "图片文件";
			$upnum = "100";
			T::A("upnum",$upnum);
			T::A("fsize",$fsize);
			T::A('uploadmode','0');
			T::A("filetype",$filetype);
			T::A("filedesc",$filedesc);
		}
	}
	function bankinfo(){
		if( $this->U->status != '800' )GF::MSG("请先签约",$this->url("upgrade"));
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
			$bank = $this->A->Post("bank");
			$bankaddress = $this->A->Post("bankaddress");
			$bankphone = $this->A->Post("bankphone");
			$bankaccountname = $this->A->Post("bankaccountname");
			$bankaccount = $this->A->Post("bankaccount");
			DB::Q("update  comextent set bank='{$bank}',bankaddress='{$bankaddress}',bankphone='{$bankphone}',bankaccountname='{$bankaccountname}',bankaccount='{$bankaccount}' where developerid='{$this->uid}'");
			if($this->U->status=='800')
			{
				$obj=$this->gateway($this->uid);
				try{
					$ret=$this->send(GF::JSON($obj),'/developer/regOrUpdateDevInfo');
					if($ret->state !="0000") GF::MSG($ret->note,$this->url("bankinfo"));
				}catch(Exception $e)
				{
					GF::MSG("网络错误:".$e->getMessage(),"back");
				}
			}
			GF::MSG("修改成功",$this->url("bankinfo"));
		}else{
			T::A("U",$this->U);
		}
	}


}
?>