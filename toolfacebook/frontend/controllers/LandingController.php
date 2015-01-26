<?php
  class LandingController extends Controller {
      
      
      public function actions() {
          return array(
              'captcha' => array(
              'class' => 'CCaptchaAction',
              'backColor' => 0xFFFFFF,
              'foreColor' => 0x0099CC,
          ),
          'oauth' => array(
              // the list of additional properties of this action is below
              'class' => 'common.extensions.hoauth.HOAuthAction',
              // Yii alias for your user's model, or simply class name, when it already on yii's import path
              // default value of this property is: Users
              'model' => 'Users',
              // map model attributes to attributes of user's social profile
              // model attribute => profile attribute
              // the list of avaible attributes is below
              'attributes' => array(
              'email' => 'email',
              'display_name' => 'identifier',
              'activate_status' => 1,
              'social_name'=>'displayName',
              'password' => md5('!@#$social!@#$'),
              ),
          ),

          );
    }
      
      public function actionIndex() {
          
          $date_params = null;
            if(isset(Yii::app()->params['sysconfig']['cd_landing']) && !empty(Yii::app()->params['sysconfig']['cd_landing'])) 
                $date_params = Yii::app()->params['sysconfig']['cd_landing'];                        
            $date1 = new DateTime($date_params);
            $date2 = new DateTime();
            $remain = null;
            if ($date1 > $date2) {
                $date3 = $date1->diff($date2);    
                $day = $date3->format("%d");
                $hour = $date3->format("%H");
                $minute = $date3->format("%i");
                $second = $date3->format("%s");
                $remain = $day*(24*60*60)+$hour*60*60+$minute*60+$second;
            }            
          $this->renderPartial('/layouts/landing',array('remain'=>$remain),false,true);
      }
  }
?>
