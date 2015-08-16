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
    protected $authservice;

    public function __construct() {
        $this->session = new Container('User');
        $this->userObj = new \Admin\Model\UserTable();
    }

    public function indexAction() {
        $request = $this->getRequest();
        $view = new ViewModel();
        if ($request->isPost()) {
            $data['param'] = $request->getPost();
            $data['param']['password'] = md5($data['param']['password']);
            $response = json_decode($this->userObj->webService($data));
            if ($response->status == 'success') {
                $this->session->offsetSet('user', $response);
                return $this->redirect()->toUrl($GLOBALS['SITE_ADMIN_URL'].'dashboard/add');
            } else {
                $this->flashMessenger()->addMessage(array('error' => 'invalid credentials.'));
            }              
        }
        return $this->redirect()->toUrl($GLOBALS['SITE_ADMIN_URL'].'index/login');
    }
    public function loginAction() {
        return new ViewModel();
    }
}
