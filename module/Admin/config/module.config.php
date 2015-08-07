<?php
 return array(
     'controllers' => array(
         'invokables' => array(
             'Admin\Controller\Index' => 'Admin\Controller\IndexController',
             'Admin\Controller\Dashboard' => 'Admin\Controller\DashboardController',
         ),
     ),
 'router' => array(
         'routes' => array(
             'index' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/index[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'	 => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Admin\Controller\Index',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'dashboard' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/dashboard[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'	 => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Admin\Controller\Dashboard',
                         'action'     => 'index',
                     ),
                 ),
             ),             
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             __DIR__ . '/../../../public/view',
         ),
     ),
 );