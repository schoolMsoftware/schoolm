<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Session\Container;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Admin\Model\UserTable;
use Zend\Authentication\Adapter\DbTable as DbAuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager   = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $serviceManager = $e->getApplication()->getServiceManager();
        
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'boforeDispatch'
        ), 100);
    }
 
    function boforeDispatch(MvcEvent $event){
        include 'config/constant.php';
        $request = $event->getRequest();
        $response = $event->getResponse();
        $target = $event->getTarget ();
        $requestUri = $request->getRequestUri();
        $controller = $event->getRouteMatch ()->getParam ( 'controller' );
        $action = $event->getRouteMatch ()->getParam ( 'action' );
        
        $requestedResourse = $controller . "\\" . $action;
        
        $session = new Container('User');
        if ($session->offsetExists ('email')) {
            if(in_array ( $requestedResourse, $GLOBALS['PAGE_BEFORE_LOGIN'] )) {
                $url = $GLOBALS['SITE_ADMIN_URL'].'dashboard/add';
                $response->setHeaders ( $response->getHeaders()->addHeaderLine ( 'Location', $url ) );
                $response->setStatusCode ( 302 );
            }
        }else{
            if ($requestedResourse != 'Admin\Controller\Index\index' && ! in_array ( $requestedResourse, $GLOBALS['PAGE_BEFORE_LOGIN'])) {
                $url = $GLOBALS['SITE_ADMIN_URL'].'index/login';                
                $response->setHeaders ( $response->getHeaders ()->addHeaderLine ( 'Location', $url ) );
                $response->setStatusCode ( 302 ); 
            }
            $response->sendHeaders ();
        }
    }
    public function getAutoloaderConfig() {
        //echo __DIR__ . '/autoload_classmap.php';die;
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Admin\Model\UserTable' => function($sm) {
                    $adapter = $sm->get('AdminDbAdapter');
                    $userObj = new \Admin\Model\UserTable($adapter);
                    return $userObj;
                },
                'AdminDbAdapter' => function ($sm) {
                    return $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                },
                'AuthService' => function ($sm) {
                    $adapter = $sm->get('AdminDbAdapter');
                    $dbAuthAdapter = new DbAuthAdapter ( $adapter, 'sh_system_user', 'email_id', 'password' );
                    	
                    $auth = new AuthenticationService();
                    $auth->setAdapter($dbAuthAdapter);
                    return $auth;
                },                        
            ),
        );
    }

}
