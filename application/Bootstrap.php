<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDb(){
        $optionResources = $this->getOption('resources');
        $dbOption = $optionResources['db'];
        
        $dbOption['params']['username'] = 'root';
        $dbOption['params']['password'] = 'root';
        $dbOption['params']['dbname'] = 'profile_testing';
        
        $adapter = $dbOption['adapter'];
        $config  = $dbOption['params'];
        $db      = Zend_Db::factory($adapter, $config);
        $db->setFetchMode(Zend_Db::FETCH_ASSOC);
        $db->query("SET NAMES 'utf8'");
        $db->query("SET CHARACTER SET 'utf8'");
        
        Zend_Registry::set('connectDb', $db);
        Zend_Db_Table::setDefaultAdapter($db);
        
        return $db;
        
        
    }

    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
    protected function _initFrontcontroller(){
        //echo '<br>' .__METHOD__;
        $front = Zend_Controller_Front::getInstance();
        $front->setControllerDirectory(APPLICATION_PATH . '/controllers');
        $front->registerPlugin(new Zendvn_Plugin_Permission());
        
        //$front = Zend_Controller_Front::getInstance();
        //$front->addModuleDirectory(APPLICATION_PATH . '/modules');
        //$front->setDefaultModule('default');
        //$front->registerPlugin(new Zendvn_Plugin_Permission());
        
        return $front;
        
    }
            
    
    
}

