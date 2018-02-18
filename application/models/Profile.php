<?php

class Application_Model_Profile extends Zend_Db_Table_Abstract {
    protected $_name = 'profile';
    protected $_primary = 'id';

    public function countItem(){
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);
        $where = '';
        $where = $this->_db->quoteInto('status_delete = ?', 0);
        $select = $db->select()
                     ->from('profile AS p', array('COUNT(p.id) AS totalItem'))
                     ->where($where)
                    ;
        
        $result = $db->fetchOne($select);
        return $result;
    }

    public function listItem($arrParams = null, $options = null){
        
        $db         = Zend_Registry::get('connectDb');
        //$db         = Zend_Db::factory($adapter, $config);
        $paginator  = $arrParams['paginator'];
        
        if($options['task'] == 'list-all'){
            $where = '';
            $where = $this->_db->quoteInto('status_delete = ?', 0);
            
            $select = $this->_db->select()
                         ->from('profile')
                         ->where($where)
                         ->order('id DESC')
                    ;
                //echo $select ;die(1);
            if($paginator['itemCountPerPage'] > 0){
                $page   = $paginator['currentPage'];
                $count  = $paginator['itemCountPerPage'];
                $select->limitPage($page, $count);
            }
            
            $result = $db->fetchAll($select);
        }
        
        return $result;
    }
    
    public function getItem($arrParams = null, $options = null){
        
        if($options['task'] == 'get-id'){
            $where = 'id =' .$arrParams['id'];
            $result = $this->fetchRow($where);
        }
        
        return $result;
    }
    
    public function deleteItem($arrParams = null, $options = null){
        
        if($options['task'] == 'delete-id'){
            
            $db         = Zend_Registry::get('connectDb');
            //$db         = Zend_Db::factory($adapter, $config);
            $data = array(
                'status_delete' => 1,
            );
            
            $result = $db->update('profile', $data, array('id = ?' => $arrParams['id']) );
            echo $result;
        }
        
        return $result;
    }
    
    public function save($arrParams = null, $options = null){
        $db         = Zend_Registry::get('connectDb');
        //$db         = Zend_Db::factory($adapter, $config);
        $arrData = $arrParams['data'];
        if($options['task'] == 'save-item'){
            
            $data = array(
                'fullname'      => $arrData['fullname'],
                'address'       => $arrData['address'],
                'age'           => $arrData['age'],
                'email'         => $arrData['email'],
                'member_code'   => $arrData['member_code'],
                'money'         => $arrData['money'],
                'password'      => md5($arrData['password']),
            );
            $result = $db->insert('profile', $data);
        }
        if($options['task'] == 'edit-item'){
            
            $data = array(
                'fullname'      => $arrData['fullname'],
                'address'       => $arrData['address'],
                'age'           => $arrData['age'],
                'email'         => $arrData['email'],
                'member_code'   => $arrData['member_code'],
                'money'         => $arrData['money'],
            );
            if(isset($arrData['password'])){
                $data['password'] = md5($arrData['password']);
            }
            
            $result = $db->update('profile', $data, array('id = ?' => $arrParams['id']) );
        }
        return $result;
    }
    
}


