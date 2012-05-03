<?php
set_include_path(__DIR__ . PATH_SEPARATOR . realpath('../common/lib'));
spl_autoload_unregister(array('YiiBase','autoload'));
function __autoload($className) {
	include str_replace("\\", "/", $className).".php";
}

// change the following paths if necessary
$yii=dirname(__FILE__).'/../common/lib/yii/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
spl_autoload_register('__autoload');
Yii::createWebApplication($config)->run();

