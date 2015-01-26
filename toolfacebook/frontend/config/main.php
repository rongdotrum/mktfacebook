<?php

/**
* main.php
*
* This file holds frontend configuration settings.
*/
// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', __DIR__ . '/../..');
Yii::setPathOfAlias('common', __DIR__ . '/../../common');
Yii::setPathOfAlias('frontend', __DIR__ . '/..');
Yii::setPathOfAlias('www', __DIR__ . '/../www');
Yii::setPathOfAlias('YiiFacebook', __DIR__ . '/../extensions/YiiFacebook');


return CMap::mergeArray(
    require(__DIR__ . '/../../common/config/main.php'), array(
        // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
        'basePath' => 'frontend',
        // set parameters
        // preload components required before running applications
        // @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
        'preload' => array('log', 'bootstrap'),
        // @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
        'sourceLanguage' => '00',
        'language' => 'vi',
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
            'application.processes.*',            
            'application.extensions.*',            
            'common.extensions.gbase.*',
            'common.extensions.gmailer.*',
            'common.extensions.YiiMailer.YiiMailer'
        ),
        /* uncomment and set if required */
        // @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
        'modules' => array(
			'appschangioi'
		),
        'components' => array(
             'facebook'=>array(
                'class' => '\YiiFacebook\SFacebook',
                'appId'=>'774520229309342', // needed for JS SDK, Social Plugins and PHP SDK
                'secret'=>'e6d2ee549b19d5d98cae5b6606a68890', // needed for the PHP SDK            
                'redirectUrl'=>'http://quayso.com/'
             ),
            'themeManager' => array(
                'basePath' => 'frontend/themes',
            ),
            'errorHandler' => array(
                // @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
                'errorAction' => 'site/error'
            ),
            //'bootstrap' => array(
            //  'class' => 'common.extensions.bootstrap.components.Bootstrap',
            //  'responsiveCss' => false,
            //),
            'urlManager' => array(
                'urlFormat' => 'path',
                'rules' => array(
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    /* '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>/<id:\d+><title:.*?>' => '<controller>/<action>', */
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                )
            ),
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'error, warning, debug',
                        'logFile' => 'application.log'
                    ),
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'trace',
                        'logFile' => 'payment.log'
                    ),
                ),
            ),
            'user' => array(
                'class' => 'application.components.GWebUser',
                'allowAutoLogin' => true,
            ),
            'curl' => array(
                'class' => 'application.extensions.curl.Curl',
            ),
            'image' => array(
                'class' => 'application.extensions.image.CImageComponent',
                // GD or ImageMagick
                'driver' => 'GD',
                // ImageMagick setup path
                'params' => array('directory' => Yii::getPathOfAlias('frontend') . '/extensions/image/drivers'),
            ),
        ),
        'params' => array(         
        ),
    ), 
    (file_exists(__DIR__ . '/main-env.php') ? require(__DIR__ . '/main-env.php') : array()), 
    (file_exists(__DIR__ . '/main-theme.php') ? require(__DIR__ . '/main-theme.php') : array())
);
