<?php

class ConfirmController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction()
    {
        if(isset($_GET["uid"]))
		{
			$user = new Default_Model_User();
			if($user->confirmed($_GET["uid"]))
			{
				$this->view->confirmed = true;
			}
			else
			{
				$this->view->confirmed = false;
			}
		}
    }
}

?>