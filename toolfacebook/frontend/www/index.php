<?php

/**
 * index.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 11:13 AM
 */
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// On dev display all errors
if (YII_DEBUG) {
//	error_reporting(-1);
//	ini_set('display_errors', true);
}

date_default_timezone_set('UTC');
chdir(dirname(__FILE__) . '/../..');

require_once('common/lib/Yii/yii.php');
require_once('common/components/WebApplication.php');
require_once('common/lib/global.php');
require_once('common/lib/fbsdk/autoload.php');

$app = Yii::createApplication('WebApplication', require('frontend/config/main.php'));

/* please, uncomment the following if you are using ZF library */
/*
  Yii::import('common.extensions.EZendAutoloader', true);

  EZendAutoloader::$prefixes = array('Zend');
  EZendAutoloader::$basePath = Yii::getPathOfAlias('common.lib') . DIRECTORY_SEPARATOR;

  Yii::registerAutoloader(array("EZendAutoloader", "loadClass"), true);
 */
defined('COOKIE_PREFIX') or define('COOKIE_PREFIX', param('vbb.cookie_prefix'));
defined('DOMAIN') or define('DOMAIN', param('vbb.domain'));
defined('COOKIE_SALT') or define('COOKIE_SALT', param('vbb.cookie_salt'));
defined('TIMENOW') or define('TIMENOW', time());
defined('TYPE_INT') or define('TYPE_INT', 2); // force integer
defined('TYPE_STR') or define('TYPE_STR', 7); // force trimmed string
defined('REQ_PROTOCOL') or define('REQ_PROTOCOL', 'http'); // scheme

$app->run();

/* uncomment if you wish to debug your resulting config */
/* echo '<pre>' . dump($config) . '</pre>'; */
