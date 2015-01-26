<?php

    require('extensions/facebook-php-sdk/autoload.php');
   

    class AppschangioiModule extends CWebModule {

        protected $assetsUrl;
      

        public function init() {
            // this method is called when the module is being created
            // you may place code here to customize the module or the application
            // import the module-level models and components
            $this->setImport(array(
                'appschangioi.models.*',
                'appschangioi.components.*',
                'appschangioi.extensions.*',                  
            ));
         
            Yii::app()->setComponents(array(
                'errorHandler'=>array(
                    'errorAction'=>'appschangioi/default/error',
            )));

          
            $this->registerCoreJs();
            $this->registerCoreCss();
        }

        protected function registerCoreCss() {
            cs()->registerCssFile(app()->theme->baseUrl . '/css/message.css');
            $ver = 5; //time();
            if (isset(Yii::app()->params['sysconfig']['version_assets']))
                    $ver = Yii::app()->params['sysconfig']['version_assets'];
            Yii::app()->clientScript->registerCssFile($this->getAssetsUrl() . '/css/appschangioi/main.css?v=' . $ver);
            Yii::app()->clientScript->registerCssFile($this->getAssetsUrl() . '/css/appschangioi/menuleft.css?v=' . $ver);
            Yii::app()->clientScript->registerCssFile($this->getAssetsUrl() . '/css/appschangioi/menuHeader.css?v=' . $ver);
        }

        protected function registerCoreJs() {
            $ver = 5; //time();
            if (isset(Yii::app()->params['sysconfig']['version_assets']))
                    $ver = Yii::app()->params['sysconfig']['version_assets'];
            cs()->registerScriptFile($this->getAssetsUrl() . '/js/loginfb.js?v=' . $ver,CClientScript::POS_END);
            cs()->registerCoreScript('jquery');
            cs()->registerCoreScript('jquery.ui');
        }

        /**
        * Publishes and returns the URL to the assets folder.
        * @return string the URL
        */
        protected function getAssetsUrl() {
            if (!isset($this->assetsUrl)) {
                $assetsPath = Yii::getPathOfAlias('appschangioi.assets');
                if (isset(Yii::app()->params['sysconfig']['refresh_assets']))         
                    $this->assetsUrl = Yii::app()->assetManager->publish($assetsPath, false, -1,true);
                else
                    $this->assetsUrl = Yii::app()->assetManager->publish($assetsPath, false, -1);
            }

            return $this->assetsUrl;
        }

        public function beforeControllerAction($controller, $action) {
            if (parent::beforeControllerAction($controller, $action)) {
                // this method is called before any module controller action is performed
                // you may place customized code here
                return true;
            } else
                return false;
        }
        
        

    }
