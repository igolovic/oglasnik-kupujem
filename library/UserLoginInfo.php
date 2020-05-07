<?php

class UserLoginInfo
{
	protected $userName, $password;
	
	function __construct($_userName, $_password)
	{
		$this->userName = $_userName;
		$this->password = $_password;
	}
	
	public function getUserName()
	{
		return $this->userName;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	
}

?>