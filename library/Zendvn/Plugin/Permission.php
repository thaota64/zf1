<?php
class Zendvn_Plugin_Permission extends Zend_Controller_Plugin_Abstract{
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        //echo '<br>'. __METHOD__;
        $arrParams = $this->_request->getParams();
        $auth = Zend_Auth::getInstance();
        
        if($auth->hasIdentity() == FALSE){
            $this->_request->setModuleName('default');
            $this->_request->setControllerName('profile');
            $this->_request->setActionName('login');
        }
        
    }
            
}
