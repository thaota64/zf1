<?php

class ProfileController extends Zend_Controller_Action{    
    protected $_currentController;
    protected $_arrParams = array(); 
    protected $_paginator = array(
                                'itemCountPerPage' => 3,
                                'pageRange' => 3
                              );

    public function init(){
        
        //echo '<br>'. __METHOD__;
        /* Initialize action controller here */
        $this->_arrParams                       = $this->_request->getParams();
        $paginator = new Zendvn_Config();
        $paginator = $paginator->config();
        echo '<pre>';
        print_r($paginator);
        echo '</pre>';
        /* Url controller */
        $this->_currentController                       = '/' . $this->_arrParams['module'] . '/' . $this->_arrParams['controller']. '/' . $this->_arrParams['action'];
        $this->_currentControllerAction                 = '/' . $this->_arrParams['module'] . '/' . $this->_arrParams['controller'];
        $this->_arrParams['paginator']['currentPage']   = $this->_request->getParam('page', 1);
        $this->_arrParams['paginator']                  = $paginator['paginator'];
        $this->_arrParams['data']                       = $this->_getAllParams();
        $this->view->currentController                  = $this->_currentController;
        $this->view->currentControllerAction            = $this->_currentControllerAction;
    }
    
    public function indexAction(){
        //echo __METHOD__;
        $profile    = new Application_Model_Profile();
        $items      = $profile->listItem($this->_arrParams, array('task' => 'list-all'));
        $totalItem  = $profile->countItem();
        echo '<pre>';
        print_r($this->_arrParams);
        echo '</pre>';
        $adapter    = new Zend_Paginator_Adapter_Null($totalItem);;
        $paginator  = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage($this->_arrParams['paginator']['itemCountPerPage']);
        $paginator->setPageRange($this->_arrParams['paginator']['pageRange']);
        
        $paginator->setCurrentPageNumber($this->_arrParams['paginator']['currentPage']);
        echo '<pre>';
        print_r($paginator);
        echo '</pre>';
        //echo $totalItem;
        $this->view->items      = $items;
        $this->view->paginator  = $paginator;
        $this->view->title      = 'Profile list';
        $this->view->messages   = $this->_helper->flashMessenger->getMessages();
    }

    public function createAction(){
        $request = $this->getRequest();
        $form    = new Application_Form_Profile();
        
        if ($this->getRequest()->isPost()) {
            
            if ($form->isValid($request->getPost())) {
                $addItem = new Application_Model_Profile();
                $addItem = $addItem->save($this->_arrParams, array('task' => 'save-item'));
                return $this->_helper->redirector('index'); 
            }
        }

        $this->view->form = $form;
    }
    
    public function editAction(){
        $checkId = preg_match('/^[0-9]+$/', $this->_arrParams['id']);
        if(isset($this->_arrParams['id']) && $checkId == 1){
            $request = $this->getRequest();
            $form    = new Application_Form_Profile();

            $item = new Application_Model_Profile();
            $item = $item->getItem($this->_arrParams, array('task' => 'get-id'));
            if(!empty($item)){
                $form->populate($item->toArray());
            }

            if ($this->getRequest()->isPost()) {
                if ($form->isValid($request->getPost())) {
                    $addItem = new Application_Model_Profile();
                    $addItem = $addItem->save($this->_arrParams, array('task' => 'edit-item'));
                    $this->_helper->flashMessenger->addMessage('Data is edited!');
                    return $this->_helper->redirector('index');  
                }
            }

            $this->view->title      = 'Edit profile';
            $this->view->msgEmpty   = empty($item) ? 'Profile Not Found' : '';
            $this->view->form       = $form;
        } else {
            return $this->_helper->redirector('index');  
        }
    }
    
    public function deleteAction(){
        $checkId = preg_match('/^[0-9]+$/', $this->_arrParams['id']);
        if(isset($this->_arrParams['id']) && $checkId == 1){
            $item = new Application_Model_Profile();
            $item = $item->deleteItem($this->_arrParams, array('task' => 'delete-id'));
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
        //$this->_helper->viewRenderer->setNoRender();
    }
    
    public function noAccessAction(){
        //$this->view->headTitle('No Access', true);
        $this->view->messageError = 'Bạn không có quyền truy cập vào chức năng này';
        
    }
}

