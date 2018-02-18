<?php

require_once 'Zend/Validate/Abstract.php';

class Zendvn_Duplicate2 extends Zend_Validate_Abstract
{
    const MSG_DUPLICATE = 'msgDuplicate';
 
    protected $_messageTemplates = array(
        self::MSG_DUPLICATE => "Duplicate data",
    );

    public function isValid($value)
    {
        $this->_setValue($value);
        
        $arrValue   = explode(',', $value);
        $arrFormat  = array_unique($arrValue);
        
        if(count($arrValue) > count($arrFormat)){
            $this->_error(self::MSG_DUPLICATE);
            return false;
        } else {
            return true;
        }
        //[1,2,4,1]
        $aryCheck = [];
        foreach ($aryCheck as $value) {
            if (isset($aryCheck[$value]))
                echo "trung code";
            else
                $aryCheck[$value] = $value;
        }
    }
}

