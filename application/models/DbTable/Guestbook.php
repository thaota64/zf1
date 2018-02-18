<?php

class Application_Model_DbTable_Guestbook extends Zend_Db_Table_Abstract
{
    protected $_name = 'guestbook';
    
    public function listItem(){
        echo __METHOD__;
    }
}
