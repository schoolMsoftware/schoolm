<?php
namespace Test\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Test\Model\User;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
		$this->layout('layout/index');
		$user = new user();
		$user->xyz();
		$view = new viewModel();
		$view->a = 'ravi<br/>';
		$view->b = 'ranjan<br/>';
		return $view;
    }
}
?>