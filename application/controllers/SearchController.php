<?php

require_once("UserLoginInfo.php");

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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
				$user->getUserByName($values["username"]);
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
	
        if($this->getRequest()->isPost())
		{
		
			$searchString = trim($this->_getParam("s"));
			
			if(strlen($searchString) < 2){ $this->view->entries = array(); return; }
			
			$searchArray = explode(" ", $searchString);
			
			$ad = new Default_Model_Ad();
			$this->view->entries = $ad->search($searchArray);
			
			$_SESSION["search"] = $searchString;
		}
    }
}