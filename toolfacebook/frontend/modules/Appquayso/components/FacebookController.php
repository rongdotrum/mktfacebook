<?php
    use Facebook\FacebookSession;
    use Facebook\FacebookRequest;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookCanvasLoginHelper;   
    class FacebookController extends CController {

        public $layout = '/layouts/landing';
        public $breadcrumbs = array();
        public $title = '';
        public $description = '';
        public $keywords = '';
        public $image = '';
        public $content = null;
        public $showboxScoin = null;            
        public $url_home = 'http://changioi.com';
        public $url_site = 'https://mongvl.com/fbapps/changioi/appschangioi/';
        public $urlapp = 'https://apps.facebook.com/fbchangioi';
        public $mod_app = '';
        
        protected $appid = '896350517066260';
        protected $appsecrect = '08c00f69e599478993fee453c1243913';
        
        

        public function init() {
                      
           $this->appid = Yii::app()->params['appfb_id'];
           $this->appsecrect = Yii::app()->params['appfb_secret'];
           $this->getMeta();           
          /** khai báo biến chung trong js **/
            Yii::app()->clientScript->registerScript(__CLASS__,'
                var appId = "'. $this->appid .'";
                var urlapp = "'.$this->urlapp.'";
                var mod_app = "'.$this->mod_app.'";    
                var url_share = "'.$this->url_home.'";
                var name_game = "Chân Giới";    
            ',CClientScript::POS_HEAD);
            
              //luu gia tri partner
            $r_partner = r()->getParam('pid');
            if ($r_partner !== null) {              
                    Yii::app()->session['pid'] = $r_partner;//$partner->partner_id;
            }                        
            $this->title = $this->description = param('pageTitle');
            $this->image = app()->createAbsoluteUrl(app()->theme->baseUrl) . 'images/logo.png';           
            $this->loginfb();          
        }     
       
        public function beforeAction($action) {               
                return parent::beforeAction($action);
        }

        protected function loginfb() {
        
            $facebook =  FacebookSession::setDefaultApplication($this->appid ,$this->appsecrect);
            $helper = new FacebookCanvasLoginHelper();
            $session = $helper->getSession();            
            if ($session){    
            
                $request = new FacebookRequest( $session, 'GET', '/me' );
                $response = $request->execute();
                // get response
                $graphObject = $response->getGraphObject();
               
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
                    if (isset(Yii::app()->session['pid']))
                    {          
                            $partner = Partners::model()->find('partner_pkey=:pkey and status = 1', array(':pkey' => Yii::app()->session['pid']));                  
                            if ($partner != null)
                                $user->partner_id = $partner->partner_id; 
                            $user->partner_key_url = Yii::app()->session['pid'];                              
                    }
                    if (!$user->save())                   
                    {
                         Yii::app()->user->setFlash('error','Có Lỗi Xảy Ra Vui Lòng Thử Lại');            
                         return;
                    }
                    else
                    {
                        Yii::app()->session['isregist'] = 1;
                    }                    
                }
                else {
                    if ($user->usersource != 'Facebook')
                    {
                         Yii::app()->user->setFlash('error','Tài Khoản Email Đã Tồn Tại, Vui Lòng Click '.CHtml::link('Vào Đây','javascript:;',array('onclick'=>'window.top.location = "'.$this->url_home.'/user/register"')).' Để Chơi');
                         return;
                    }                        
                }
                
                $identity = new UserIdentity($user->email,null);
                if (!Yii::app()->user->login($identity,2592000))
                    throw new Exception('Có Lỗi Xảy Ra Vui Lòng Thử Lại');
                Yii::app()->request->cookies['fb_name'] = new CHttpCookie('fb_name', $graphObject->getProperty('name'));
                Yii::app()->request->cookies['fb_email'] = new CHttpCookie('fb_email', $graphObject->getProperty('email'));
                Yii::app()->request->cookies['fb_id'] = new CHttpCookie('fb_id', $graphObject->getProperty('id'));
                return true;

            }         
            if ( Yii::app()->controller->id == 'default' )
                echo '<script>window.top.location.href = encodeURI("https://www.facebook.com/v2.1/dialog/oauth?client_id=896350517066260&redirect_uri=' . $this->urlapp . '&display=page&response_type=token&scope=email")</script>';
            if (Yii::app()->user->isGuest)
                echo '<script>window.top.location.href = encodeURI("https://www.facebook.com/v2.1/dialog/oauth?client_id=896350517066260&redirect_uri=' . $this->urlapp . '&display=page&response_type=token&scope=email")</script>';


        }
        private function getMeta() {            
            $this->keywords = Yii::app()->params['sysconfig']['meta_keywords'];
            $this->description = Yii::app()->params['sysconfig']['meta_description'];
            if (isset(Yii::app()->params['sysconfig']['pageTitle']))
                $this->pageTitle = Yii::app()->params['sysconfig']['pageTitle'];
                
            $sys = Yii::app()->params['sysconfig'];
            if (isset($sys['appfb_id']))
                $this->appid = $sys['appfb_id'];
            if (isset($sys['url_home']))
                $this->url_home = $sys['url_home'];
            if (isset($sys['url_site']))
                $this->url_site = $sys['url_site'];
            if (isset($sys['urlapp']))
                $this->urlapp = $sys['urlapp'];
           if (isset($sys['mod_app']))
               $this->mod_app = $sys['mod_app'];    
           else                  
               $this->mod_app = $this->module->name;
                       
        }




    }

?>
