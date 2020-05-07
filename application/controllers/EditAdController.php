<?php

require_once("UserLoginInfo.php");

class EditAdController extends Zend_Controller_Action
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
		
		$category = new Default_Model_Category();
		$this->view->category = $category->fetchAllOrdered();
		
		$ad = new Default_Model_Ad();

        if ($this->getRequest()->isPost() && isset($_POST["update"]))
		{
			$this->view->missingEntry = false;
			$this->view->adUpdated = false;
		
			$id = $this->_getParam("id");
			$title = $this->_getParam("title");
			$text = $this->_getParam("taContent");
			$duration = $this->_getParam("duration");
			
			if(strlen(trim($title)) < 1 || strlen(trim($text)) < 1)
			{ 
				$this->view->missingEntry = true;
			}
			else
			{
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
				filter_var($duration, FILTER_SANITIZE_STRING);
				filter_var_array($countyArray, FILTER_SANITIZE_STRING);
				filter_var($adCategory, FILTER_SANITIZE_STRING);
	
				$ad->updateAd($id, $title, $text, $duration, $allCounties, $countyArray, $adCategory, $_SESSION["user"]->getUserName());
				
				$this->view->adUpdated = true;
			}
		}
		else if($this->getRequest()->isPost() && isset($_POST["prolong"]))
		{
			$id = $this->_getParam("id");
			$ad->prolong($id);
		}

		if(isset($_GET["edit"]) && is_numeric($_GET["edit"]))
		{
			$ad->fetchAd($_GET["edit"]);
			
			$this->view->isOverdue = false;
			if($ad->getStatus() != 1)
			{
				$this->view->isOverdue = true;	
			}
			
			$this->view->ad = $ad;
    	}
	}
}