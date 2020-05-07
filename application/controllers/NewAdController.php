<?php

require_once("UserLoginInfo.php");

class NewAdController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction()
    {
		session_start();

		if(!isset($_SESSION["newAd"]))
		{
			$_SESSION["newAd"] = new Default_Model_Ad();
		}	
	
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
		
		$this->view->missingEntry = false;
		$this->view->adOk = false;
		
		$category = new Default_Model_Category();
		$this->view->category = $category->fetchAllOrdered();
		
        if ($this->getRequest()->isPost())
		{
			$this->view->missingEntry = false;
			$this->view->adInserted = false;		
		
			$ad = new Default_Model_Ad();
		
			$title = trim($this->_getParam("title"));
			$text = trim($this->_getParam("taContent"));		
			$duration = $this->_getParam("duration");
			
			$allCounties = false;
			$countyArray = array();
			
			if($this->_getParam("chAll") == null)
			{
				for($i=0; $i<22; $i++)
				{
					$name = "ch" . ($i + 1);
					$value = $this->_getParam($name);
					if($value != null)
					{
						$countyArray[] = $value;
					}
				}
			}
			else
			{
				$allCounties = true;
			}
			
			$adCategory = $this->_getParam("adCategory");
			
			filter_var($title, FILTER_SANITIZE_STRING);
			filter_var($text, FILTER_SANITIZE_STRING);			
			filter_var($duration, FILTER_SANITIZE_STRING);
			filter_var_array($countyArray, FILTER_SANITIZE_STRING);
			filter_var($adCategory, FILTER_SANITIZE_STRING);
			
			$ad = new Default_Model_Ad();
			$ad->setTitle($title);
			$ad->setText($text);
			//Zend_Debug::dump($ad->getText($text));
			
			$_SESSION["newAd"] = $ad;
			
			if(strlen($title) < 1 || strlen($text) < 1)
			{
				$this->view->missingEntry = true; return;
			}			
			
			$ad->insertAd($title, $text, $duration, $allCounties, $countyArray, $adCategory, $_SESSION["user"]->getUserName());

			$_SESSION["newAd"] = new Default_Model_Ad();;
						
			$this->view->adInserted = true;
		}
    }
}