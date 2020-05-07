<?php

require_once("UserLoginInfo.php");

class CategoryAdsController extends Zend_Controller_Action
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
		if(isset($_GET["id"]))
		{
			$c = new Default_Model_Category();
			
			filter_var($_GET["id"], FILTER_SANITIZE_STRING);
			
			$c->getCategoryById($_GET["id"]);
			
			$this->view->name = $c->getName();
			$this->view->description = $c->getDescription();
			$this->view->adCount = $c->getAdCount();
			
			$ad = new Default_Model_Ad();
			$this->view->entries = $ad->getAdsByCategory($_GET["id"]);

			$page = 1;
			if(isset($_GET["p"]))
			{
				$page = $_GET["p"];
			}
			//Zend_Debug::dump($page);
			$paginator = Zend_Paginator::factory($ad->getAdsByCategory($_GET["id"]));
			$paginator->setItemCountPerPage(5);
			$paginator->setCurrentPageNumber($page);
		
			$this->view->paginator=$paginator;	
		}
    }
}