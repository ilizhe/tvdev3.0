<?php
class CURL
{
	var $url;
	var $ch;
	var $fp;
	public function __construct($url,$time=TRUE){
		$this->url = $url;
		$this->ch = curl_init($this->url);
//		if( $this->ch===false ) throw new exception("remote server connect faild");
//		curl_setopt($this->ch, CURLOPT_URL, $this->url);
		curl_setopt($this->ch,CURLOPT_HEADER,0);
		curl_setopt($this->ch,CURLOPT_RETURNTRANSFER,1);
//		curl_setopt($this->ch,CURLOPT_CONNECTTIMEOUT_MS, 2000);	//连接前等待时间
//		curl_setopt($this->ch,CURLOPT_TIMEOUT_MS,20000);	//最大执行时间20秒
		if($time)
			curl_setopt($this->ch,CURLOPT_TIMEOUT,30);			//最大执行时间20秒
	}
	public function __destruct(){
		$this->close();
	}
	public function close(){
		curl_close($this->ch);
	}
	public static function init($url){
		return new self($url);
	}

	function set($opt,$val){
		LOG::MW("set option:".$opt.",val=".$val);
		curl_setopt($this->ch,$opt,$val);
	}
	function get($data){
		LOG::MW("GET request url:".$data);
		curl_setopt($this->ch,CURLOPT_URL,$data);
		$res = curl_exec($this->ch);
		$errno = curl_errno($this->ch);
		$error = curl_error($this->ch);
		LOG::MW("result:".$res." \r\nerrno:".$errno."\t error:".$error);
		return $res;
	}

	function post($data,$t=true){
		if($t){
			$header = array();
			$header[] = "Content-Type: application/json; charset=UTF-8";
			$header[] = "Connection: Keep-Alive";
			$header[] = "User-Agent: Apache-HttpClient/4.0-beta2 (java 1.5)";
			$header[] = "Expect: 100-Continue";
			curl_setopt($this->ch,CURLOPT_HTTPHEADER, $header); 
		}
		curl_setopt($this->ch,CURLOPT_POST,1);
		curl_setopt($this->ch,CURLOPT_POSTFIELDS,$data);
		LOG::MW("POST request url:".$this->url.",data:".$data);
		$res =  curl_exec($this->ch);
		$errno = curl_errno($this->ch);
		$error = curl_error($this->ch);
		LOG::MW("result:".$res." bytes \r\nerrno:".$errno."\t error:".$error);
		return $res;
	}
	function info($s=''){
		$sd = curl_getinfo($this->ch);
		return $s?$sd[$s]:$sd;
	}
}
?>