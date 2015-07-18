<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;


 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;

 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
		//echo __DIR__ . '/autoload_classmap.php';die;
         return array(
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }

    public function getServiceConfig()
    {
        return array(
            'initializers' => array(
               function ($instance, $sm) {
               //use this only once for reduce repetitive injection
                   //in registering class in SM
                   if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
                   $instance->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
            }
                }
        ),
            'invokables' => array(
                'Admin\Model\UserTable' =>  'Admin\Model\UserTable'
            ),
        );
    }
 }
