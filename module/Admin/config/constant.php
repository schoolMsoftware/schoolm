<?php
$GLOBALS['SITE_ADMIN_URL'] = 'http://' .$_SERVER['HTTP_HOST'].'/schoolm/admin/';
$GLOBALS['PAGE_BEFORE_LOGIN'] = array('Admin\Controller\Index\login','Admin\Controller\Index\index');