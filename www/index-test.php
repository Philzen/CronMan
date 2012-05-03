<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

set_include_path(__DIR__ . PATH_SEPARATOR . realpath('../common/lib'));
spl_autoload_unregister(array('YiiBase','autoload'));
function __autoload($className) {
	include str_replace("\\", "/", $className).".php";
}

// change the following paths if necessary
$yii=dirname(__FILE__).'/../common/lib/yii/yii.php';
$config=dirname(__FILE__).'/protected/config/test.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
spl_autoload_register('__autoload');
Yii::createWebApplication($config)->run();
