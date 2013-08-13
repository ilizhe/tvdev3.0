<?php
/*
dfindex array

0	p0
1	p1
2	p2
3	p3



*/
class Focus{

	function __construct(){
		if( !isset($_SESSION['focus_history']) )
			$_SESSION['focus_history'] = array();
	}
	function save($id){
		array_push($_SESSION["focus_history"],$id);
	}
	function get(){
		return array_pop($_SESSION["focus_history"]);
	}

	function C($A){
		$s = $A->Get("df");
		if( $s )
			$this->save($s);
		$d = $A->Get("returnback");
		if( $d )
			return $this->get();
		else
			return null;
	}
	function P($A,$ret){
		$fd = $A->Get("defocus");
		$fdb= $A->Get("defb");
		$lr = $A->Get("dflr");
		if( !$fd ) return ;
		if( $lr )
			return $ret->NextMark?$fd:$fdb;
		else
			return $ret->PrevMark?$fd:$fdb;
	}
}
?>