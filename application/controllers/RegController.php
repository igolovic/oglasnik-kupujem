<?php

class RegController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction() 
    {	
		Zend_Session::start();
	
		$this->_captcha = new Zend_Captcha_Image(array(	'font' => realpath('captcha') . '/Arial.ttf',
														'wordLen' => 4,
														'dotNoiseLevel' => 20,
														'lineNoiseLevel' => 2));

		if(!isset($_SESSION["newUser"]))
		{
			$_SESSION["newUser"] = new Default_Model_User();
		}
	
        if ($this->getRequest()->isPost())
		{
			if(isset($_POST['captcha']))
			{
					$this->view->captchaError = false;				
					$this->view->userInserted = false;
					$this->view->missingEntry = false;
					$this->view->passwordMismatch = false;
					$this->view->emailExists = false;
					
					$userData = array(
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
					$user->setUserName($userData["username"]);
					$user->setPassword($userData["password"]);
					$user->setName($userData["name"]);
					$user->setLastName($userData["lastName"]);
					$user->setCountyId($userData["countyId"]);
					$user->setCity($userData["city"]);			
					$user->setPostalCode($userData["postalCode"]);
					$user->setStreetName($userData["streetName"]);
					$user->setStreetNumber($userData["streetNumber"]);						
					$user->setTelephone1($userData["telephone1"]);		
					$user->setTelephone2($userData["telephone2"]);
					$user->setEmail($userData["email"]);
					$_SESSION["newUser"] = $user;

				if($this->_captcha->isValid($_POST['captcha']))
				{					
					if( strlen(trim($userData["username"])) < 1 ||
						strlen(trim($this->_getParam("password1"))) < 1 ||
						strlen(trim($this->_getParam("password2"))) < 1 ||
						strlen(trim($userData["telephone1"])) < 1 ||
						strlen(trim($userData["email"])) < 1
					   )
					{ 
						$this->view->missingEntry = true;
					}
					else
					{
						if($this->_getParam("password1") != $this->_getParam("password2"))
						{
							$this->view->passwordMismatch = true;
						}
						else
						{
							if($userData["email"] != "" && !$user->emailExists($userData["email"]))
							{
								if(!$user->nameExists($userData["username"]))
								{
									if($user->insertUser(
										$userData["username"],
										$userData["password"],
										$userData["name"],
										$userData["lastName"], 
										$userData["countyId"], 
										$userData["city"],
										$userData["postalCode"], 
										$userData["streetName"],
										$userData["streetNumber"],
										$userData["telephone1"], 
										$userData["telephone2"], 
										$userData["email"]
									))
									{
										$this->view->userInserted = true;
									}
									else
									{
										$this->view->errorEmail = true;						
									}
								}
								else
								{
									$this->view->wrongUserName = true;
								}
							}
							else
							{
								$this->view->emailExists = true;
							}					
						} // lozinka i ponovljena lozinka se ne poklapaju
					} // nedostaju unosi
				} // is CAPTCHA valid
				else
				{
					$this->view->captchaError = true;
				}
			} // is CAPTCHA set
		} // is Post	
		
		$this->_captcha->setImgDir('./captcha/images');
		$this->_captcha->setImgUrl('/captcha/images');
	
		$this->view->captchaMD5 = $this->_captcha->generate();
		$this->view->captchaImage = $this->_captcha->render();
    }
}