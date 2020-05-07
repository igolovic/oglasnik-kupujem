<?php

class Default_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');

        $this->addElement('text', 'username', array(
            'label'      => 'Korisničko ime:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(),
	    'decorators' => array('ViewHelper', 'Description', 'Errors', array('HtmlTag', array('tag' => 'dd')), array('Label', array('tag' => 'dt')),)
        ));

        $this->addElement('password', 'password', array(
            'label'      => 'Lozinka:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(),
	    'decorators' => array('ViewHelper', 'Description', 'Errors', array('HtmlTag', array('tag' => 'dd')), array('Label', array('tag' => 'dt')),)
        ));

        $this->addElement('checkbox', 'rememberUser', array(
            'label'      => 'Zapamti me trajno na ovom računalu:',
            'checked'   => true,
	    'decorators' => array('ViewHelper', 'Description', 'Errors', array('HtmlTag', array('tag' => 'dd')), array('Label', array('tag' => 'dt')),)		
        ));
		
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Dalje',
	    'decorators' => array('ViewHelper', 'Description', 'Errors', array('HtmlTag', array('tag' => 'dt')), 'Label',)		
        ));
		
	$el = $this->getElement('submit');
	$el->removeDecorator('Label');
    }
}

?>