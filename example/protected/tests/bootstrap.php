<?php

//defined('YII_DEBUG') or define('YII_DEBUG',true);
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// change the following paths if necessary
$yiit='/var/www/yii/1.1.14/framework/yiit.php';
$config=dirname(__FILE__).'/../config/test.php';

require_once($yiit);
//require_once(dirname(__FILE__).'/WebTestCase.php');

Yii::createWebApplication($config);
