<?php
class Member
{
	var $uid;
	var $U = null;
	function __construct()
	{
		if ( isset($_SESSION['uid']) && $_SESSION['uid'] > 0 )
		{
			$this->uid = $_SESSION['uid'];
			$this->loaduser();
		}
	}
	function check()
	{
		if ( !isset($_SESSION['uid']) ) return false;
		if (  isset($_SESSION['sess'] ) !=  session_id()  ) return false;
		if ( md5($this->uid.$this->U->username."12esdf%refd".session_id()) != $_SESSION['salt'] ) return false;
		return true;
	}
	
	function login($username,$password)
	{
		if ( !$username || !$password ) return 1;
		$Q = DB::Q("select * from members where username='{$username}'");
		if ( DB::N($Q) < 1 ) return 2;
		$M = DB::O($Q);
		if ( md5($password.$M->salt) !== $M->password )
		{
			return 3;
		}
		$_SESSION['uid'] = $M->uid;
		$_SESSION['name'] = $M->realname || $M->username;
		$_SESSION['sess'] = session_id();
		$_SESSION['salt'] = md5($M->uid.$M->username."12esdf%refd".$_SESSION['sess']);
		return 0;
	}

	function logout()
	{
		unset($_SESSION);
		@session_unset();
		@session_unregister();
		@session_destroy();
	}
	function loaduser($username='')
	{
		$where = $username==''?"uid='{$this->uid}'":"username='{$username}'";
		$q = DB::Q("select * from members where ".$where);
		if ( DB::N($q) < 1 ) 
		{
			throw new Exception("system error:code 1");
		}
		$this->U = DB::O($q);
	}

	function updatepasswd($password,$passwd,$passcp)
	{
		if( $passwd != $passcp ) return 1;
		$pw = md5($passwd.$this->U->salt);
		if ( $pw != $this->U->password ) return 2;
		DB::Q("update members set password='{$pw}' where uid='{$this->uid}'");
		return 0;
	}


}
?>