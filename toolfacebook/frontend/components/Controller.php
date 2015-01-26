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
    //public $layout = '//layouts/g4g_3colum';
    public $title = '';
    public $_description = '';
    public $_keywords = '';
    public $image = '';
    public $signupForm;
    public $renderTheme = '';
    public $_assetsUrl;
    public $version_assets = 1;

    public function init() {
        
        $this->loginfacebook();
        $this->getAssetsUrl();                
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
            $loginurl = $fb->getLoginUrl(null,array('email'));         
            $this->redirect($loginurl);
        }
    }

}
