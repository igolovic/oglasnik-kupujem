<?php

require_once("UserLoginInfo.php");

class IndexController extends Zend_Controller_Action
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
		
		$this->view->showReg = true;
		if(isset($_SESSION["user"]))
		{
			$uli = $_SESSION["user"];
			$this->view->userName = $uli->getUserName();
			$this->view->showReg = false;
		}
	
		$category = new Default_Model_Category();
		$menuCols = array_chunk($category->fetchAllOrdered(), 6);
		$this->view->menuEntriesCol1 = $menuCols[0];	
		$this->view->menuEntriesCol2 = $menuCols[1];
		$this->view->menuEntriesCol3 = $menuCols[2];	
		
        $ad = new Default_Model_Ad();
        $this->view->lastTenAdsEntries = $ad->fetchLastTenAds();
    }
}

?>