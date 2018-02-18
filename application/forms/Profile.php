<?php

class Application_Form_Profile extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        // Add fullname element
        $this->addElement('text', 'fullname', array(
            'label'      => 'Fullname',
            'required'   => true,
            "type"       => "Zend\\InputFilter\\ArrayInput",
            'filters' => array(
                array(
                     'name'              => 'StringTrim',
                     'options'           => array()
                 ),
                array(
                     'name'              => 'StripTags',
                     'options'           => array()
                 ),
            ),
            'validators' => array(
                array(
                    'validator'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>'Yêu cầu nhập dữ liệu cho ô input fullname'
                    ),
                    'breakChainOnFailure'=>true
                ),
            ),     
        ));

        // Add address element
        $this->addElement('text', 'address', array(
            'label'      => 'Address',
            'required'   => true,
            'validators' => array(
                array(
                    'validator'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>'Yêu cầu nhập dữ liệu cho ô input address'
                    ),
                    'breakChainOnFailure'=>true
                ),
            )
        ));
        
        // Add age element
        $this->addElement('text', 'age', array(
            'label'      => 'Age',
            'required'   => true,
            'validators' => array(
                array(
                    'validator'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>'Yêu cầu nhập dữ liệu cho ô input age'
                    ),
                    'breakChainOnFailure'=>true
                ),
                array(
                    'validator'=>'Int',
                    'options'=>array(
                        'messages'=>'Nhập đúng định dạng số'
                    ),
                    'breakChainOnFailure'=>true
                ),
            )
        )); 
        
        // Add password element
        $this->addElement('password', 'password', array(
            'label'      => 'Password',
            'required'   => FALSE,
        )); 
        
        // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'Email',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array(
                    'validator'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>'Yêu cầu nhập dữ liệu cho ô input Email'
                    ),
                    'breakChainOnFailure'=>true
                ),
                array(
                    'validator'=>'EmailAddress',
                    'options'=>array(
                        'messages'=>'Không đúng định dạng email'
                    ),
                    'breakChainOnFailure'=>true
                ),
            )
        ));
        
        // Add age element
        $this->addElement('hidden', 'createprofile', array(
            'value'   => 'createprofile',
        )); 
        $element = $this->getElement('createprofile');
        $element->removeDecorator('label');
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit',
        ));
    }
    
}
