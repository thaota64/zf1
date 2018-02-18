<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        
        // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'Email',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array(
                    'validator'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>'Email is required'
                    ),
                    'breakChainOnFailure'=>true
                ),
                array(
                    'validator'=>'EmailAddress',
                    'options'=>array(
                        'messages'=>'Email is invalid'
                    ),
                    'breakChainOnFailure'=>true
                ),
            )
        ));
        // Add password element
        $this->addElement('password', 'password', array(
            'label'      => 'Password',
            'required'   => true,
            'validators' => array(
                array(
                    'validator'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>'Password is required'
                    ),
                    'breakChainOnFailure'=>true
                ),
            )
        )); 
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit',
        ));
       
    
//        // And finally add some CSRF protection
//        $this->addElement('hash', 'csrf', array(
//            'ignore' => true,
//        ));
    }
    
}
