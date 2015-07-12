<?php
return array(
		'controllers' => array(
			'invokables' => array(
				'Test\Controller\User' => 'Test\Controller\UserController',
			),
		),
     'router' => array(
         'routes' => array(
             'user' => array(
                 'type' => 'segment',
                 'options' => array(
                     'route'    => '/user[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Test\Controller\User',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'test' => __DIR__ . '/../view',
         ),
     ),
			
		);