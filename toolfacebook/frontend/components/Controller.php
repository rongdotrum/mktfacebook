<?php

/**
* Controller.php
*
* @author: antonio ramirez <antonio@clevertech.biz>
* Date: 7/23/12
* Time: 12:55 AM
*/

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookCanvasLoginHelper; 

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
    public $urlapp = 'https://apps.facebook.com/appquayso';
    public $idfb = '';

    public function init() {
        $this->loginfacebook();                
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
            
            $facebook =  FacebookSession::setDefaultApplication(Yii::app()->params['appfb_id'],Yii::app()->params['appfb_secret']);
            $helper = new FacebookCanvasLoginHelper();
            $session = $helper->getSession();                        
            if (isset($session)){                
                $request = new FacebookRequest( $session, 'GET', '/me' );
                $response = $request->execute();                
                $graphObject = $response->getGraphObject();                             
                if (!Yii::app()->user->isGuest && Yii::app()->user->getName() != $graphObject->getProperty('id')) 
                    Yii::app()->user->logout();
                if (Yii::app()->user->isGuest) {
                    $user = Users::model()->find('email = :email',array(':email'=>$graphObject->getProperty('email')));        
                    if (empty($user))
                    {                    
                        $user = new Users();
                        $user->email =  $graphObject->getProperty('email');
                        $user->salt = GHelpers::fetch_random_string();
                        $user->display_name = $graphObject->getProperty('id');
                        $user->social_name =  $graphObject->getProperty('name');
                        $user->registerdate = new CDbExpression('NOW()');                    
                        $user->usersource = 'Facebook';
                        $user->activate_status = 1; 
                        $user->password = md5('xxxxxx'.$user->salt);                                                            
                        $user->save();                        
                    }                
                    $identity = new UserIdentity($user->email,null);
                    Yii::app()->user->login($identity,2592000);                            
                }
                return true;
            }      
	if (!Yii::app()->request->isAjaxRequest)
             echo '<script>window.top.location.href = encodeURI("https://www.facebook.com/v2.2/dialog/oauth?client_id='.Yii::app()->params['appfb_id'].'&redirect_uri=' . $this->urlapp . '&display=page&response_type=token&scope=email")</script>';                   

    }
   protected function afterRender($view, &$output) {
        parent::afterRender($view,$output);       
        Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages        
        return true;
    }

}
