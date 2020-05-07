<?php

class Default_Form_PasswordRecovery extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');

        $this->addElement('text', 'email', array(
            'label'      => 'E-mail adresa:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(array('validator' => 'EmailAddress', 'breakChainOnFailure' => true)),
	    'decorators' => array('ViewHelper', 'Description', 'Errors', array('HtmlTag', array('tag' => 'dd')), array('Label', array('tag' => 'dt')),)
        ));
	
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Poslati lozinku na e-mail',
	    'decorators' => array('ViewHelper', 'Description', 'Errors', array('HtmlTag', array('tag' => 'dt')), 'Label',)		
        ));
		
	$el = $this->getElement('submit');
	$el->removeDecorator('Label');
    }
}

