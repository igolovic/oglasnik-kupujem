<?php

require_once("UserLoginInfo.php");

class EditUserDataController extends Zend_Controller_Action
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
			
			$user = new Default_Model_User();
			$user->getUserByName($uli->getUserName());
			$_SESSION["userData"] = $user;
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
		
        if ($this->getRequest()->isPost())
		{
			$this->view->passwordMismatch = false;
			$this->view->missingEntry = false;
			
			$userData = array(
				"id" => $this->_getParam("id"),
				"username" => $this->_getParam("username"),
				"password" => $this->_getParam("password1"),			
				"name" => $this->_getParam("name"),
				"lastName" => $this->_getParam("lastName"),
				"countyId" => $this->_getParam("selCounty"),
				"city" => $this->_getParam("city"),
				"postalCode" => $this->_getParam("postalCode"),
				"streetName" => $this->_getParam("streetName"),
				"streetNumber" => $this->_getParam("streetNumber"),								
				"telephone1" => $this->_getParam("telephone1"),
				"telephone2" => $this->_getParam("telephone2"),
				"email" => $this->_getParam("email")
			);

			filter_var_array($userData, FILTER_SANITIZE_STRING);

			$user = new Default_Model_User();
		
			if($this->_getParam("password1") != $this->_getParam("password2")){ $this->view->passwordMismatch = true; return; }
			
			if(strlen(trim($userData["telephone1"])) < 1 || strlen(trim($userData["password"]))  < 1)
			{ $this->view->missingEntry = true; return; }
			
			$user->updateUser(
				$userData["id"],
				$userData["password"],				
				$userData["name"],
				$userData["lastName"], 
				$userData["countyId"], 
				$userData["city"],
				$userData["postalCode"], 
				$userData["streetName"],
				$userData["streetNumber"],				
				$userData["telephone1"],				
				$userData["telephone2"]
			);
			
			$user->getUserById($userData["id"]);
			$_SESSION["userData"] = $user;
			
			$this->view->userUpdated = true;
		}
    }
}