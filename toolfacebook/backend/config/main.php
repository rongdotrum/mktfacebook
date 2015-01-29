<?php

/**
 * main.php
 *
 * This file holds the configuration settings of your backend application.
 */
// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', __DIR__ . '/../..');
Yii::setPathOfAlias('common', __DIR__ . '/../../common');
Yii::setPathOfAlias('backend', __DIR__ . '/..');
Yii::setPathOfAlias('www', __DIR__ . '/../www');
Yii::setPathOfAlias('media', __DIR__ . '/../../media');

return CMap::mergeArray(
                require(__DIR__ . '/../../common/config/main.php'), array(
            'name' => 'Administrator Control Panel',
            // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
            'basePath' => 'backend',
            // preload components required before running applications
// @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
            'preload' => array('bootstrap', 'log'),
            // @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
            'sourceLanguage' => '00',
            'language' => 'vi',
            // using bootstrap theme ? not needed with extension
//'theme' => 'bootstrap',
// setup import paths aliases
// @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
            'import' => array(
// uncomment if behaviors are required
// you can also import a specific one
                /* 'common.extensions.behaviors.*', */
// uncomment if validators on common folder are required
                /* 'common.extensions.validators.*', */
                'application.components.*',
                'application.controllers.*',
                'application.models.*',
                'common.extensions.gbase.*',
                'application.modules.rights.*',
                'application.modules.rights.components.*',
            ),
            /* uncomment and set if required */
// @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
            'modules' => array(
                'rights',
                'systemusers',
                'users',
                'controllers',
                'logquayso',
                'quayso',
                'quaysoitem',
                'sysconfig',
            ),
            'components' => array(
                'user' => array(
                    'class' => 'RWebUser',
                    'allowAutoLogin' => true,
                ),
                'authManager' => array(
                    'class' => 'RDbAuthManager',
                    'connectionID' => 'db',
                    'defaultRoles' => array('Authenticated', 'Guest'),
                ),
                //  'metadata' => array('class' => 'Metadata'),
                /* load bootstrap components */
                'bootstrap' => array(
                    'class' => 'common.extensions.bootstrap.components.Bootstrap',
                    'responsiveCss' => true,
                ),
                'errorHandler' => array(
// @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
                    'errorAction' => 'site/error'
                ),
                'urlManager' => array(
                    'showScriptName' => false,
                    'caseSensitive' => false,
                    'rules' => array(
                        '<controller:\w+>/<id:\d+>' => '<controller>/view',
                        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    //'<alias:[\w\d\-_\/]+>' => array('blog/view', 'urlSuffix' => '.html'),
                    )
                ),
				'log' => array(
					'class' => 'CLogRouter',
					'routes' => array(
						array(
							'class' => 'CFileLogRoute',
							'levels' => 'error, warning, debug, info',
						),
					// uncomment the following to show log messages on web pages
					/*
					  array(
					  'class'=>'CWebLogRoute',
					  ),
					 */
					),
				),
            ),
                ), (file_exists(__DIR__ . '/main-env.php') ? require(__DIR__ . '/main-env.php') : array()), (file_exists(__DIR__ . '/main-local.php') ? require(__DIR__ . '/main-local.php') : array())
);
