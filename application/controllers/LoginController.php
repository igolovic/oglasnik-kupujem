<?php

require_once("UserLoginInfo.php");

class LoginController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $form    = new Default_Form_Login();
			
		session_start();
		$this->view->badLogin = "none";

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
			
		$values = $form->getValues();
			
        $user = new Default_Model_User();
		if($user->loginApproved($values["username"], $values["password"]))
		{
			if($values["rememberUser"] == "1")
			{
				setcookie("user",$values["username"] . "|" . $values["password"], time()+31556926,"/",".kupujem.net",false,true);
			}
			
			$_SESSION["user"] = new UserLoginInfo($values["username"], $values["password"]);
			$user = new Default_Model_User();
			$user->getUserByName($values["username"]);
			$_SESSION["userData"] = $user;
			
			header('Location: my-ads');
		}
		else
		{
			$this->view->badLogin = "block";
		}
            }
        }
	else
	{
		$act = $this->_getParam("act");
		if($act == "logout")
		{
			if(isset($_SESSION["user"]))
			{
				setcookie("user","dummy", time()-1209600,"/",".kupujem.net",false,true);
				$_SESSION["user"] = null;
				$_SESSION["userData"] = null;
			}
		}
	}
        $this->view->form = $form;
    }
}