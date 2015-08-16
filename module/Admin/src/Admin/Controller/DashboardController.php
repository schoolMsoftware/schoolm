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

class DashboardController extends AbstractActionController {
    public function __construct() {
        $this->view =  new ViewModel();    
    }
    
    public function addAction() {
        return $this->view;
    } 
    public function indexAction() {
        return $this->view;
    }
}
