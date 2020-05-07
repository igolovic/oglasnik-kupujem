<?php

class PasswordRecoveryController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction()
    {
		$request = $this->getRequest();
		$form = new Default_Form_PasswordRecovery();
		
		$this->view->form = $form;
		$this->view->genericError = 'none';
		$this->view->messageSent = 'none';
		$this->view->messageNotSent = 'none';
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($request->getPost()))
			{
				$values = $form->getValues();
				
				$user = new Default_Model_User();
				if($user->emailExists(trim($values['email'])))
				{	
					$email = trim($values['email']);
				
					$user->getUserByEmail($email);
				
					$mail = new Zend_Mail("UTF-8");
					$body = "
					<span style='font-weight:strong; color:navy; font-family:Arial; margin:0px; padding:0px'>
					<img alt='' src='http://www.kupujem.net/res/emailLogo.gif'><br /><br />
					<br/><br/>
					Vaši podaci za prijavu su:<br />
					<br />
					Korisničko ime: " . $user->getUserName() . "<br />
					Lozinka: " . $user->getPassword() . "
					<br/><br/><br/>
					Pozdrav, Vaš Kupujem.net
					<br/><br/><br/>
					<p>
					<span style='font-size:11px'>Za sva pitanja, komentare i sugestije obratite se na <a href='mailto:info@kupujem.net'>info@kupujem.net</a></span><br />
					<span style='font-size:11px'>U slučaju tehničkih problema kontaktirajte nas na <a href='mailto:admin@kupujem.net'>admin@kupujem.net</a></span>
					</p>
					</span>";
					try
					{	
						$mail->setBodyHtml($body);	
						$mail->setFrom('kupujemn@depri1.srv16.com', 'Kupujem.net');
						$mail->addTo($email, $email);
						$mail->setSubject('Kupujem.net - podaci za prijavu');
						$mail->send();
						$this->view->messageSent = 'block';	
					}
					catch(Zend_Exception $e)
					{
						$this->view->genericError = 'block';
						return false;
					}
				}
				else
				{
					$this->view->messageNotSent = 'block';        
				}
			}
		}
    }
}