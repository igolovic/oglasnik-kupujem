<?php

require_once("UserLoginInfo.php");

class AdController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction()
    {
		session_start();
        
		if(isset($_COOKIE["user"]))
		{
			$userLoginData = explode("|", $_COOKIE["user"]);
				
			$user = new Default_Model_User();
			if($user->loginApproved($userLoginData[0], $userLoginData[1]))
			{
				$_SESSION["user"] = new UserLoginInfo($userLoginData[0], $userLoginData[1]);
				$user = new Default_Model_User();
				//$user->getUserByName($values["username"]);
				$_SESSION["userData"] = $user;				
			}
			else
			{
				header("Location: login");
			}
		}
		
		if(isset($_SESSION["user"]))
		{
			$uli = $_SESSION["user"];
			$this->view->userName = $uli->getUserName();
		}
	
		if(isset($_GET["id"]))
		{
			filter_input(INPUT_GET, $_GET["id"], FILTER_SANITIZE_STRING);
			
			$ad = new Default_Model_Ad();
			$ad->fetchAd($_GET["id"]);
			
			$this->view->ad = $ad;
			
			$user = new Default_Model_User();
			$user->getUserById($ad->getUserId());
			
			$this->view->user = $user;
    	}
	}
}