<?php

require_once("UserLoginInfo.php");

class MyAdsController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction()
    {
		session_start();
	
        if(isset($_SESSION["user"]))
		{
			$uli = $_SESSION["user"];
			$this->view->userName = $uli->getUserName();
		}
		else
		{
			if(isset($_COOKIE["user"]))
			{
				$userLoginData = explode("|", $_COOKIE["user"]);
					
				$user = new Default_Model_User();
				if($user->loginApproved($userLoginData[0], $userLoginData[1]))
				{
					$_SESSION["user"] = new UserLoginInfo($userLoginData[0], $userLoginData[1]);
					$user = new Default_Model_User();
					$user->getUserByName($values["username"]);
					$_SESSION["userData"] = $user;					
				}
				else
				{
					header("Location: login"); return;
				}
			}
			else
			{
				header("Location: login"); return;
			}
		}
		
		$ad = new Default_Model_Ad();
		if(isset($_GET["del"]) && is_numeric($_GET["del"]))
		{
			$ad->deleteAd($_SESSION["user"]->getUserName(), $_GET["del"]);
		}

		$this->view->entries = $ad->fetchUserAds($_SESSION["user"]->getUserName());
    }
}