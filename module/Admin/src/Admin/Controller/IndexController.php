<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Admin\Model\UserTable;

class IndexController extends AbstractActionController {

    var $userObj;
    protected $storage;
    protected $authservice;

    public function __construct() {
        $this->session = new Container('User');
    }

    public function indexAction() {

        $request = $this->getRequest();

        $view = new ViewModel();

        if ($request->isPost()) {
            $data = $request->getPost();
            $encyptPass = md5($data['password']);
            $this->getAuthService()
                    ->getAdapter()
                    ->setIdentity($data['username'])
                    ->setCredential($encyptPass);
            $result = $this->getAuthService()->authenticate();
            if ($result->isValid()) {
                $this->session->offsetSet('email', $data['email']);
                $this->flashMessenger()->addMessage(array('success' => 'Login Success.'));
                return $this->redirect()->toRoute('dashboard', array(
                    'action' => 'add',
                ));
            } else {
                $this->flashMessenger()->addMessage(array('error' => 'invalid credentials.'));
                // Rirect to page after login failureedirect to page after login failure
            }

            // Logic for login authentication                
        }
        return $this->redirect()->toRoute('index', array(
            'action' => 'login',
        ));
        //return $this->redirect()->tourl('/schoolManage/admin/login');
        //$view->setVariable('loginForm', $loginForm);
        //return $view;
    }
    public function loginAction() {
        return new ViewModel();
    }
    private function getAuthService() {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }

}
