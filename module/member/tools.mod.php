<?php
if(!defined("TOOLS")) define("TOOLS",2);

class tools extends GlobalMember {
	var $path;
	var $cf;
	var $out;
	var $maxn = 5;
	function __construct(){
		parent::__construct();
		$this->cf = array();
		$this->maxn = $this->C->APP['maxconfigfile'];
		$this->path = TTROOT."/userdata/".$this->uid."/config";
		if( file_exists($this->path."/record") ){
			$cfa = file_get_contents($this->path."/record");
			$this->cf = json_decode($cfa);
		}
	}
	public function config(){
		T::A('files',$this->cf);
	}

	public function down(){
		$dnum = $this->A->Get("num");
		if( $dnum == "" ){
			$num = count($this->cf);
		}else{
			$dnum = intval($dnum);
			if($dnum<0 || $dnum>$this->maxn || !isset($this->cf[$dnum]) )
				$num=0;
			else
				$num = $dnum;
		}
		if( $num>=5 )GF::MSG("配置文件最多只能下载 ".$this->maxn." 个","back");
		
		$fname = "uainfo".$num.".xml";
		if(@mkdir(TTROOT."/userdata/".$this->uid)){
		}
		$path = TTROOT."/userdata/".$this->uid."/config";
		if(@mkdir($path)){
		}
		$file = $path."/".$fname;
		if( file_exists($file) ){
			$fp = fopen($file,"r");
			$this->out = fread($fp,filesize($file));
			fclose($fp);
		}else{
			$dnum = $this->getfile($file);
			$this->cf[$num]=$dnum;
			file_put_contents($this->path."/record",GF::JSON($this->cf));
		}
		header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" );
		header( "Cache-Control: no-cache, must-revalidate" );
		header( "Pragma: no-cache" );
		header( "Content-type:application/octet-stream" );
		header( "Content-Disposition:attachment;filename=uainfo.xml" );
		exit($this->out);
	}
	public function update(){
		$num = intval($this->A->Get("num"));
		if($num<0 || $num> $this->maxn || !isset($this->cf[$num]) )GF::MSG("错误的序号","back");

		$fname = "uainfo{$num}.xml";
		$file = $this->path."/".$fname;
		$dnum = $this->getfile($file,2,$this->cf[$num]);

		header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" );
		header( "Cache-Control: no-cache, must-revalidate" );
		header( "Pragma: no-cache" );
		header( "Content-type:application/octet-stream" );
		header( "Content-Disposition:attachment;filename=uainfo.xml" );
		exit($this->out);
	}
	private function getfile($file,$optype=1,$dnum=''){
		$s = $this->C->INI(TTROOT."/config/gateway.ini");
		$obj = '{"action":"GetTestDeviceUserInfo","locale":"zh_CN","optype":'.$optype.',"device":{"dnum":"'.$dnum.'"}}';
		$c = new CURL($s['SERVER']['deviceuri']);
		$s = $c->post($obj);
		$ret = $c->info();
		$c->close();
		if( $ret['http_code'] != '200' ){
			GF::MSG("网络忙，请稍候再试","back");
		}
		$do = json_decode($s);
		if(!$do)GF::MSG("数据错误","back");
		$xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
		$xml .= "<UaInfo\r\n";
		$xml .= "    ActiveKey=\"{$do->device->activekey}\"\r\n";
		$xml .= "    DevModel=\"{$do->device->devmodel}\"\r\n".
				"    DeviceNum=\"{$do->device->dnum}\"\r\n".
				"    Didtoken=\"{$do->device->didtoken}\"\r\n".
				"    HuanId=\"{$do->user->huanid}\"\r\n".
				"    HuanToken=\"{$do->user->token}\" >\r\n".
				"</UaInfo>";
		$this->out = $xml;
		file_put_contents($file,$xml);
		return $do->device->dnum;
	}
}
?>