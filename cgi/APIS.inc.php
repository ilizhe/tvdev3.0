<?php
class APIS{
	var $C;//系统配置参数
	var $exp = 0;
	var $fp = null;
	function __construct($CONF){
		$this->C = $CONF;
		$this->exp = 6;
		$this->initmemcache();
	}
    public function PageManager($urlopt=''){
        return DB::M($urlopt);
    }
	public function log($str){
		return ;
		$s = date("Y-m-d H:i:s",time())."\t".$str."\r\n";
		fwrite($this->fp,$s);
		fflush($this->fp);
	}
	public function resize($o,$w=0,$h=0){
		if( (!$w && !$h ) || !intval($o->width) || !intval($o->height)){
			$o->dwidth = intval($o->width);
			$o->dheight = intval($o->height);
		}else{
			if( $w > 0 ){
				$o->dwidth = $w;
				$o->dheight = intval(($o->width * $w) / $o->height );
			}
			if( $h > 0 ){
				$o->dheight = $h;
				$o->dwidth = intval(($o->height * $h ) / $o->width );
			}
		}
		return $o;
	}
	public function checkalbumid($albumid){
		$Q = DB::Q("select * from photo_album where id='{$albumid}'");
		if(DB::N($Q)<1)return 0;
		$O = DB::O($Q);
		return $O->status;
	}
	public function checkfid($uid,$fid){
		$Q = DB::Q("select * from followex where user_id='{$uid}' and follow_user_id='{$fid}'");
		if(DB::N($Q)<1)return false;
		$O = DB::O($Q);
		return  $O->friendtype == '3'?true:false;
	}
	public function cmresize($o,$w,$h){
		$p = $w/$h;
		$o->x = floor( $w * $o->x / $h );
		$o->y = floor( $w * $o->y / $h );
		$o->w = floor( $w * $o->w / $h );
		$o->h = floor( $w * $o->h / $h );
		$o->twidth  = floor( $w * $o->twidth / $h );
		$o->theight = floor( $w * $o->theight / $h )+1;
		$o->ttop    = floor( $w * $o->ttop / $h )+1;
		$o->tleft   = floor( $w * $o->tleft / $h )+1;
		$o->fsize   = floor( $w * $o->fsize / $h );
		$o->text = str_replace("\r\n","<br>",$o->text);
		if( $o->x<0 )$o->x=0;
		if( $o->y<0 )$o->y=0;
		return $o;
	}

	public function initmemcache(){
		$this->MC = new Memcache();
		$ret = @$this->MC->connect($this->C->MEMCACHE['host'],$this->C->MEMCACHE['port']);
		if( $ret === false )throw new exception("connect memcached server failed!");
	}
	public function mset($key,$val,$expires=0){
		return $this->MC->set($key,serialize($val),0,$expires>0?$expires:$this->C->MEMCACHE['expires']);
	}
	public function mkey($key){
		return $this->MC->add($key,'true',false,10);
	}
	public function mget($key){
		$ret = $this->MC->get($key);
		if( !$ret ) return false;
		$rets = unserialize($ret);
//		$this->R = json_last_error();
//		if($this->R != JSON_ERROR_NONE ) throw new exception("json decode error:".$this->R.print_r($ret,true));
		return $rets;
	}
	public function mdel($key){
		return $this->MC->delete($key);
	}
	public function getface($uid,$file='90'){
		$path = $this->C->APP["faceurl"].'/avatar/';
		for($i=0;$i<strlen($uid);$i=$i+4){
			$path .= substr($uid,$i,4)."/";
		}
		return "http://".$path.$file.".jpg";
	}
}
?>