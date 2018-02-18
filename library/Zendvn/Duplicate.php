<?php

require_once 'Zend/Validate/Abstract.php';

class Zendvn_Duplicate extends Zend_Validate_Abstract
{
    const MSG_DUPLICATE = 'msgDuplicate';
 
    protected $_messageTemplates = array(
        self::MSG_DUPLICATE => "Duplicate data",
    );

    public function isValid($value)
    {
        $this->_setValue($value);
        
        $arrValue = explode(',', $value);
        sort($arrValue);
        if(count($arrValue) > 0) {
            for($i = 0; $i < count($arrValue); $i++){
                if($arrValue[$i] == $arrValue[$i+1]){
                    $this->_error(self::MSG_DUPLICATE);
                    return false;
                } else {
                    return true;
                }
            }
        }
        return true;
    }
}

