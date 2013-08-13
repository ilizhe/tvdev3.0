<?php
if( !defined("DINDEX")){
	define("DINDEX",1);
}
class dindex extends GlobalMember{
	var $U;
	var $A;
	var $C;
	function __construct(){
		global $ARGV,$CONF;
		$this->A = $ARGV;
		$this->C = $CONF;
		$this->U = User::Cinit();
		if( !$this->U->check() )
			GF::HD($this->url("loggin",'member'));

	}

	function init($act='',$mod='dindex'){
		T::A("menu",$this->menu());
		T::A("nav",$this->menucur($act));
		T::A("module","dindex");
		T::A("frm",$this->A->mkFRM(true));
		T::A("formhash",$this->A->FormHash());
	}
	function index(){
	}
	function main(){

	}
	function info(){
		if( $this->A->CheckForm($this->A->Post("formhash")) ){
		}else{
			T::A("U",$this->U);
		}
	}
	function upgrade(){
	}
	function myapp(){
	}
	function newapp(){
	}
	
}
?>