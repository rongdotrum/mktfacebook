<?php

/**
* Controller.php
*
* @author: antonio ramirez <antonio@clevertech.biz>
* Date: 7/23/12
* Time: 12:55 AM
*/
class Controller extends CController {

    public $breadcrumbs = array();
    public $menu = array();
    public $layout = '//layouts/main';
    public $title = '';
    public $_description = '';
    public $_keywords = '';
    public $image = '';
    public $signupForm;
    public $renderTheme = '';
    public $_assetsUrl;
    public $version_assets = 1;

    public function init() {
        
     
        //if (Yii::app()->user->isGuest)
        $this->loginfacebook();
           
       // $this->getAssetsUrl();                
    //    $this->getMetaHeader();      
        parent::init();
    }
       
        
    public function getAssetsUrl() {                
        if ( $this->_assetsUrl == null ) {
            $path = Yii::getPathOfAlias('application.www.themes.'.Yii::app()->theme->name);
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish($path,false,-1,true);
        } 
        return $this->_assetsUrl;
    }
    
  
    
    public function loginfacebook() {        
        if (isset(Yii::app()->facebook)) {
            $fb = Yii::app()->facebook;
            $session = $fb->getSessionInfo();
            if ($session) {            
                $fb_user = $fb->getMe();              
                $user = Users::model()->find('email = :pemail',array(':pemail'=>$fb_user->getEmail()));
                if ($user == null) {
                    $user = new Users();
                    $user->display_name = $fb_user->getId();
                    $user->social_name = $fb_user->getName();
                    $user->email = $fb_user->getEmail();
                    $user->password = md5('xxxxx'.md5('yyy'));
                    $user->activate_status = 1;
                    $user->save();                    
                }
                $identity = new UserIdentity($user->email,null);
                if (!Yii::app()->user->login($identity,2592000))
                    throw new Exception('Có Lỗi Xảy Ra Vui Lòng Thử Lại');
            }
            else {
                if (!Yii::app()->user->isGuest) {
                      Yii::app()->user->logout();                  
                }
                $loginurl = $fb->getLoginUrl(null,array('email'));         
                $this->redirect($loginurl);
                Yii::app()->end;
            }
        }
        else {
            if (!Yii::app()->user->isGuest)
            {
                Yii::app()->user->logout();
                $this->refresh();
                Yii::app()->end();
            }
        }
    }
    protected function afterRender($view, &$output) {
        parent::afterRender($view,$output);
        //Yii::app()->facebook->addJsCallback($js); // use this if you are registering any additional $js code you want to run on init()
        Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
        // Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags
        return true;
    }

}
