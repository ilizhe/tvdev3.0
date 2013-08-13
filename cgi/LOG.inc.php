<?php
class LOG {
	var $fp;
	var $C;
	var $file;
	var $id;
	static $obj = null;
	public static function init($c,$f){
		if(self::$obj == null)
			self::$obj = new self($c,$f);
		return self::$obj;
	}
	private function __construct($CONF,$file='debug.log'){
		$this->C = $CONF;
		$this->file = $file;
		$this->fp = fopen(TTROOT."/log/".$this->file,"a+");
	}
	function w($str){
		$s = $this->id."\t".date("Y-m-d H:i:s",time())."\t".$str."\r\n";
		fwrite($this->fp,$s);
		fflush($this->fp);
	}
	function mw($str){
		$s = $this->id."\t".microtime()."\t".$str."\r\n";
		fwrite($this->fp,$s);
		fflush($this->fp);
	}
	function close(){
		fclose($this->fp);
	}
}
?>