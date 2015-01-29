<?php

session_start();
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;
    
  class Fbsdk {
            
      public function getInfoFb() {       
            FacebookSession::setDefaultApplication(Yii::app()->params['appfb_id'],Yii::app()->params['appfb_secret']);
            $helper = new FacebookRedirectLoginHelper('http://mongthuyhu.com/');     
           try {
              $session = $helper->getSessionFromRedirect();
            }
            catch(FacebookRequestException $ex ) {
                
            }
            if (isset($session)) {
                $request = new FacebookRequest($session, 'GET', '/me');
                $response = $request->execute();
                $graphObject = $response->getGraphObject();  
                return array('error'=>0,'value'=>$graphObject,'logout'=>$helper->getLogoutUrl($session,'http://mongthuyhu.com'));
               
            }
            else {                 
                 $url = $helper->getLoginUrl();                 
                 return array('error'=>1,'value'=>$url);                 
            }            
      }
  }
?>
