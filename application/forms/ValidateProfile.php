<?php

class Application_Form_ValidateProfile extends Zend_Form {

    //Chứa những thông báo của form 
    protected $_messagesError = null;
    
    //Mảng chứa dữ liệu sau khi kiểm tra
    protected $_arrData;
    
    public function __construct(&$arrParram = null, $option = null) {
        
        $this->addElement($this->validateFullname());
        $this->addElement($this->validateAddress());
        $this->addElement($this->validateAge());
        
        if($arrParram['data']['email'] != ''){
            $this->addElement($this->validateAddressEmail());
        } else { 
            $this->addElement($this->validateEmail());
        }
        
        if($arrParram['data']['member_code'] != ''){
            $this->addElement($this->validateRecorMemberCode($arrParram));
        } else { 
            $this->addElement($this->validateMemberCode());
        }
        
        if($arrParram['data']['money'] != ''){
            $this->addElement($this->validateFormatMoney());
        } else { 
            $this->addElement($this->validateMoney());
        }
        
        $arrParram['data']['fullname']          = !empty($arrParram['data']['fullname']) ? trim($arrParram['data']['fullname']) : '';
        $arrParram['data']['address']           = !empty($arrParram['data']['address']) ? trim($arrParram['data']['address']) : '';
        $arrParram['data']['age']               = !empty($arrParram['data']['age']) ? trim($arrParram['data']['age']) : '';
        $arrParram['data']['email']             = !empty($arrParram['data']['email']) ? trim($arrParram['data']['email']) : '';
        $arrParram['data']['member_code']       = !empty($arrParram['data']['member_code']) ? trim($arrParram['data']['member_code']) : '';
        
        $this->_arrData = $arrParram;
    }
    
    public function validateFullname()
    {
        $element = new Zend_Form_Element_Text('fullname');
        $validatorEmty = new Zend_Validate_NotEmpty();
        $validatorEmty->setMessage('Yêu cầu nhập dữ liệu cho ô input fullname', Zend_Validate_NotEmpty::IS_EMPTY);
        $element->setRequired(true)->addValidator($validatorEmty);
        
        return $element;
    }
    
    public function validateAddress()
    {
        $element = new Zend_Form_Element_Text('address');
        $validatorEmty = new Zend_Validate_NotEmpty();
        $validatorEmty->setMessage('Yêu cầu nhập dữ liệu cho ô input address', Zend_Validate_NotEmpty::IS_EMPTY);
        $element->setRequired(true)->addValidator($validatorEmty);
        
        return $element;
    }
    
    public function validateAge()
    {
        $element = new Zend_Form_Element_Text('age');
        $validatorEmty = new Zend_Validate_NotEmpty();
        $validatorEmty->setMessage('Yêu cầu nhập dữ liệu cho ô input age', Zend_Validate_NotEmpty::IS_EMPTY);
        $validator = new Zend_Validate_Regex("/^[0-9]*$/");
        $validator->setMessage('Nhập đúng dữ liệu số', Zend_Validate_Regex::NOT_MATCH);
        $element->setRequired(true)->addValidator($validator, true)
                ->addValidator($validatorEmty);
        
        return $element;
    }
    
    public function validateEmail()
    {
        $element = new Zend_Form_Element_Text('email');
        $validatorEmty = new Zend_Validate_NotEmpty();
        $validatorEmty->setMessage('Yêu cầu nhập dữ liệu cho ô input email', Zend_Validate_NotEmpty::IS_EMPTY);
        $element->setRequired(true)->addValidator($validatorEmty);
        
        return $element;
    }
    
    public function validateAddressEmail()
    {
        $element = new Zend_Form_Element_Text('email');
        $validatorEmail = new Zend_Validate_EmailAddress();
        $validatorEmail->setMessage('Sai địa chỉ Email', Zend_Validate_EmailAddress::INVALID_FORMAT);
        $element->setRequired(true)->addValidator($validatorEmail);
        
        return $element;
    }
    
    public function validateMemberCode()
    {
        $element = new Zend_Form_Element_Text('member_code');
        $validatorEmty = new Zend_Validate_NotEmpty();
        $validatorEmty->setMessage('Yêu cầu nhập dữ liệu cho ô input member code', Zend_Validate_NotEmpty::IS_EMPTY);
        $element->setRequired(true)->addValidator($validatorEmty);
        
        return $element;
    }
    
    public function validateRecorMemberCode($arrParram = null)
    {        
        $element    = new Zend_Form_Element_Text('member_code');
        $validator  = new Zend_Validate_Db_NoRecordExists(array('table' => 'profile', 'field' => 'member_code', 'exclude' => array('field' => 'id', 'value' => '1')));
        $validator->setMessage('Member code đã tồn tại', Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND);
        $element->setRequired(true)->addValidator($validator);
        
        return $element;
    }

    public function validateMoney(){
        $element = new Zend_Form_Element_Text('money');
        $element->setRequired(false);
        
        return $element;
    }
    
    public function validateFormatMoney(){
        $element = new Zend_Form_Element_Text('money');
        $validator = new Zendvn_Duplicate2;
        $element->setRequired(true)->addValidator($validator);
        
        return $element;
    }
    //Kiểm tra error 
    //Return nếu có lỗi xuất hiện 
    public function isError(){
        if(count($this->_messagesError) > 0){
            return true;
        } else {
            return false;
        }
        
    }
    //Trả về 1 mảng các lỗi
    public function getMessageError(){
        return $this->_messagesError;
    }
    //Trả về 1 mảng dữ liệu 
    public function getData($options = null){
        return $this->_arrData;
    }
    
}
