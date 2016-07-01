<?php
defined('YII_TRACE_LEVEL')	or define('YII_TRACE_LEVEL',	3);
defined('APPLICATION_MODE')	or define('APPLICATION_MODE',	isset($_SERVER['APPLICATION_MODE'])? $_SERVER['APPLICATION_MODE']: 'production');
defined('YII_DEBUG')		or define('YII_DEBUG',			APPLICATION_MODE !== 'production' && APPLICATION_MODE !== 'qa');

// calculate filename for config
$configFileName = realpath(__DIR__ . '/../protected/config/' . preg_replace('/[^A-Za-z0-9_\-]/', '_', APPLICATION_MODE) . '.php');

// include library
require_once('../yii/framework/yii.php');
Yii::createWebApplication($configFileName)
	->run();
