<?php
if(!defined("PERSON")) define("PERSON",2);

class person extends GlobalMember {
	var $A;
	var $C;
	var $M;
	var $uid = 0;
	
	function send($obj,$url=''){
		$log=TTROOT."/log/indiextent_".date("m").".txt";
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
	function info(){
		if($this->U->devtype == "-1"){
			GF::MSG("请先选择会员类型",$this->url("select","member"));
		}
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
//			$realname = $this->A->Post("realname");
			$nickname = $this->A->Post("nickname");
			$enname = $this->A->Post("enname");
			$provid = $this->A->Post("provid");
			$cityid = $this->A->Post("cityid");
			$townid = $this->A->Post("townid");
			$pctaddr = GF::PCT($provid,$cityid,$townid);
			$address = $this->A->Post("address");
			$mobile  = $this->A->Post("mobile");
			$telephone   = $this->A->Post("telephone");
			$website = $this->A->Post("website");
			$fax = $this->A->Post("fax");
			$postal = $this->A->Post("postal");
			$qq = $this->A->Post("qq");
			$msn = $this->A->Post("msn");
			$sql = "update indiextent set nickname='{$nickname}',enname='{$enname}',provid='{$provid}',cityid='{$cityid}',townid='{$townid}',pctaddr='".$pctaddr->prov.$pctaddr->city.$pctaddr->town."',address='{$address}',mobile='{$mobile}',telephone='{$telephone}',website='{$website}',fax='{$fax}',postal='{$postal}',qq='{$qq}',msn='{$msn}' where developerid='{$this->U->uid}'";
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
	function upgrade(){
		switch($this->U->status){
			case "800":
			case "200":
			case "500":
			case "400":
			case "300":
				$tpArr = array('IDCARD'=>'身份证','POSSPORT'=>'护照');
				$this->U->certtypestr = isset($tpArr[$this->U->certtype])?$tpArr[$this->U->certtype]:$this->U->certtype;
				T::A("U",$this->U);
				break;
			default:
				GF::MSG("请先签约",$this->url("upgradeinfo"));
				break;
		}
	}
	function upgradeinfo(){
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
//			if(!$this->verify())
//				GF::MSG("验证码错误，请重新填写","back");
			if( $this->A->Post("verify") != "1" )
				GF::MSG("您必须同意此合同",$this->url("upgradeinfo"));
			$certtype = $this->A->Post("certtype");
			$certno  = $this->A->Post("certno");
			$realname = $this->A->Post("realname");
			$bank = $this->A->Post("bank");
			$bankaddress = $this->A->Post("bankaddress");
			$bankphone = $this->A->Post("bankphone");
			$bankaccountname = $this->A->Post("bankaccountname");
			$bankaccount = $this->A->Post("bankaccount");

			$introduction = $this->A->Post("introduction");
			$filename = $this->A->Post("filename");
			
			$sql = "update indiextent set certtype='{$certtype}',realname='{$realname}',certno='{$certno}'";
			$sql .= (strlen($filename)>3)?",certpicture='{$filename}'":'';
			$sql .= ",bank='{$bank}',bankaddress='{$bankaddress}',bankphone='{$bankphone}',bankaccountname='{$bankaccountname}',bankaccount='{$bankaccount}',introduction='{$introduction}' where developerid='{$this->U->uid}'";
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
			if( $this->U->mobile == "" )
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
			DB::Q("update  indiextent set bank='{$bank}',bankaddress='{$bankaddress}',bankphone='{$bankphone}',bankaccountname='{$bankaccountname}',bankaccount='{$bankaccount}' where developerid='{$this->uid}'");
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