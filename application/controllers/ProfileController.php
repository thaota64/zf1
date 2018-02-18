<?php

class ProfileController extends Zend_Controller_Action{    
    protected $_currentController;
    protected $_arrParams = array(); 

    public function init(){
        
        //echo '<br>'. __METHOD__;
        
        /* Initialize action controller here */
        $paginator                              = new Zendvn_Config();
        $paginator                              = $paginator->config();
        $this->_arrParams                       = $this->_request->getParams();
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('create', 'html')->initContext();
        /* Url controller */
        $this->_currentController                       = '/' . $this->_arrParams['module'] . '/' . $this->_arrParams['controller']. '/' . $this->_arrParams['action'];
        $this->_currentControllerAction                 = '/' . $this->_arrParams['module'] . '/' . $this->_arrParams['controller'];
        $this->_arrParams['paginator']                  = $paginator['paginator'];
        $this->_arrParams['paginator']['currentPage']   = $this->_request->getParam('page', 1);
        $this->_arrParams['data']                       = $this->_getAllParams();
        $this->view->currentController                  = $this->_currentController;
        $this->view->currentControllerAction            = $this->_currentControllerAction;
    }
    
    public function indexAction(){
        //echo __METHOD__;
        $profile    = new Application_Model_Profile();
        $items      = $profile->listItem($this->_arrParams, array('task' => 'list-all'));
        $totalItem  = $profile->countItem();
        
        $adapter    = new Zend_Paginator_Adapter_Null($totalItem);;
        $paginator  = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage($this->_arrParams['paginator']['itemCountPerPage']);
        $paginator->setPageRange($this->_arrParams['paginator']['pageRange']);
        
        $paginator->setCurrentPageNumber($this->_arrParams['paginator']['currentPage']);
        
        //echo $totalItem;
        $this->view->items      = $items;
        $this->view->paginator  = $paginator;
        $this->view->title      = 'Profile list';
        $this->view->messages   = $this->_helper->flashMessenger->getMessages();
    }

    public function createAction(){
        $request = $this->getRequest();
        
        if ($this->_request->isXmlHttpRequest()) {
            $form    = new Application_Form_ValidateProfile($this->_arrParams);
            if ($form->isValid($this->_arrParams)) {
                $addItem = new Application_Model_Profile();
                $addItem = $addItem->save($this->_arrParams, array('task' => 'save-item'));
                $arrView['Item'] = $form->getData();
                echo json_encode($arrView);
                
            } else {
                $message = $form->getMessages();
                $error['fullname']      = @current($message['fullname']);
                $error['address']       = @current($message['address']);
                $error['age']           = @current($message['age']);
                $error['email']         = @current($message['email']);
                $error['member_code']   = @current($message['member_code']);
                $error['money']         = @current($message['money']);
                
                $arrView['Item'] = $form->getData();
                $arrView['Error'] = $error;
                echo json_encode($arrView);
                
            }
            $this->_helper->layout()->disableLayout(); 
            $this->_helper->viewRenderer->setNoRender(true);
        }

    }
    
    public function editAction(){
        $checkId = preg_match('/^[0-9]+$/', $this->_arrParams['id']);
        
        if(isset($this->_arrParams['id']) && $checkId == 1){
            $item = new Application_Model_Profile();
            $item = $item->getItem($this->_arrParams, array('task' => 'get-id'));
            
            if(!empty($item)){
                $arrItem['data'] = $item->toArray();
                 $this->view->Item = $arrItem;
            }

            if ($this->getRequest()->isPost()) {
                $form    = new Application_Form_ValidateProfile($this->_arrParams);
                if ($form->isValid($this->_arrParams)) {
                    $addItem = new Application_Model_Profile();
                    $addItem = $addItem->save($this->_arrParams, array('task' => 'edit-item'));
                    $this->_helper->flashMessenger->addMessage('Data is edited!');
                    $this->view->Item = $form->getData();
                    return $this->_helper->redirector('index'); 
                    
                } else {
                    $message                = $form->getMessages();
                    
                    $error['fullname']      = @current($message['fullname']);
                    $error['address']       = @current($message['address']);
                    $error['age']           = @current($message['age']);
                    $error['email']         = @current($message['email']);
                    $error['member_code']   = @current($message['member_code']);
                    $error['money']         = @current($message['money']);

                    $this->view->Item   = $form->getData();
                    $this->view->Error  = $error;

                }
            }

            $this->view->title      = 'Edit profile';
            $this->view->msgEmpty   = empty($item) ? 'Profile Not Found' : '';
        } else {
            return $this->_helper->redirector('index');  
        }
    }
    
    public function detailAction(){
        $item = new Application_Model_Profile();
        $item = $item->getItem($this->_arrParams, array('task' => 'get-id'))->toArray();
        
        if($item['status_delete'] == 1){
            echo 'Dữ liệu đã được xoá';
        } 
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function deleteAction(){
        $checkId = preg_match('/^[0-9]+$/', $this->_arrParams['id']);
        if(isset($this->_arrParams['id']) && $checkId == 1){
            
            $delete = new Application_Model_Profile();
            $delete->deleteItem($this->_arrParams, array('task' => 'delete-id'));
            $this->_helper->flashMessenger->addMessage('Profile is deleted!');
            return $this->_helper->redirector('index');  
            
            
        } else {
            return $this->_helper->redirector('index');  
        }
        
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function loginAction(){
        $request        = $this->getRequest();
        $form           = new Application_Form_Login();
        $db             = Zend_Registry::get('connectDb');
        $auth           = Zend_Auth::getInstance();
        $authAdapter    = new Zend_Auth_Adapter_DbTable($db);
        $authAdapter->setTableName('profile')
                    ->setIdentityColumn('email')
                    ->setCredentialColumn('password');
           
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $email      = $this->_arrParams['data']['email'];
                $password   = md5($this->_arrParams['data']['password']);
                $authAdapter->setIdentity($email);
                $authAdapter->setCredential($password);
                
                //Lấy kết quả truy vấn của zend auth
                $result = $auth->authenticate($authAdapter);
                if(!$result->isValid()){
                    $error = $result->getMessages();
                    $this->view->error = 'Account doesn\'t  exist';
                } else {
                    echo 'Login thành công!';
                    //Lấy thông tin của tài khoản đưa vào session auth
                    $data = $authAdapter->getResultRowObject();
                    echo '<pre>';
                    print_r($data);
                    echo '</pre>';
                    $auth->getStorage()->write($data);
                    $this->view->error = '';
                    return $this->_helper->redirector('index'); 
                    
                }
            }
        }
        
        $this->view->form   = $form;
        $this->view->title  = 'Login';
    }
    
    public function logoutAction(){
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        return $this->_helper->redirector('login');  
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function noAccessAction(){
        //$this->view->headTitle('No Access', true);
        $this->view->messageError = 'Bạn không có quyền truy cập vào chức năng này';
        
    }
}

