<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

class UserController extends Controller {

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
        'forgetpass' => array('class' => 'application.controllers.actions.user.forgetpass')
        );
    }
    public function filters()
    {
        return array( 'accessControl' ); // perform access control for CRUD operations
    }

    public function accessRules() {
        return array(
            array('allow', 
                'actions' => array('changepass'), 
                'users' => array('@'),
                'expression'=>array('UserController','isloginfb')
            ),                
        // logged in users can do whatever they want to               
        );
    }

    static function isloginfb() {            
        if (Yii::app()->user->social_name() !=null )
            throw new CDbException('Tài Khoản Mạng Xã Hội Không Thể Thay Đổi Thông Tin');
    }

    public function actionIndex() {
        if (app()->user->isGuest) {
            app()->user->setFlash('error', 'Vui Lòng Đăng Nhập');
            $this->render('index', array('model' => null));
        } else {
            $model = new Users();
            $model = $model->model()->findByPk(app()->user->getId());

            $this->render('index', array('model' => $model));
        }
    }

    public function actionChangePass() {
        $changeform = new ChangePassForm;
        app()->clientScript->registerScriptFile(app()->baseUrl . '/css/extStyle.css');
        if (isset($_POST['ChangePassForm'])) {
            $changeform->attributes = $_POST['ChangePassForm'];
            if (!$changeform->validate()) {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($changeform));
            } else {

                if ($changeform->change()) {
                    Yii::app()->user->setFlash('success', 'Đã Thay Đổi Mật Khẩu');
                    app()->clientScript->registerScript('removeForm', '$("#changepass-form").remove()');
                } else
                    Yii::app()->user->setFlash('error', CHtml::errorSummary($changeform));
            }
        }
        if (app()->user->isGuest)
            Yii::app()->user->setFlash('error', 'Bạn Vui Lòng Đăng Nhập Để Thực Hiện Chức Năng Này');
        $this->render('changepass', array('model' => $changeform));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        if(!param('skip_forum'))
        {
            $forum = new VbbForum();
            $sessionhashold = isset($_COOKIE[COOKIE_PREFIX . 'sessionhash']) ? (string) $_COOKIE[COOKIE_PREFIX . 'sessionhash'] : '';
            $forum->process_logout($sessionhashold);
        }
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionLogin() {      
        if (!empty(Yii::app()->request->urlReferrer) && Yii::app()->user->returnUrl === '/index.php')
            if (!strpos(Yii::app()->request->urlReferrer, '/user/') && !strpos(Yii::app()->request->urlReferrer, ' /user/login')) {
                Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
            }                                                                                          
            
            if (!Yii::app()->user->isGuest) { 
            if (!empty(Yii::app()->request->urlReferrer))
                $this->redirect(Yii::app()->request->urlReferrer);
            else
                $this->redirect(Yii::app()->createUrl('site'));
            Yii::app()->end();
        }

        $model = new LoginForm;

        if (Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest && isset($_POST['LoginForm']))
        {
            $this->actionLogin2();
            $message = array('error'=>0,'message'=>'','login_attempt');
            if (Yii::app()->user->hasFlash('error'))
            {
                $message['error'] = 1;
                $message['value'] =  Yii::app()->user->getFlash('error');
                $message['login_attempt'] = Yii::app()->user->getState('login_attempt');
            }
            else {
                $message['error'] = 0;
                $message['value'] =  '';
                $message['login_attempt'] = Yii::app()->user->getState('login_attempt');
            }

            echo json_encode($message);     
            Yii::app()->end(); 
        }


        //if it is ajax validation request

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $this->actionLogin2();
        }

        // display the login form
        $this->render('login', array('model' => $model));
    }

    public function actionLogin2() {          
        $login_attempt = Yii::app()->user->getState("login_attempt", 0);
        $model = new LoginForm;
        $model->attributes = $_POST['LoginForm'];
        if (!$model->validate()) {
            Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            $content = '';
            foreach($model->getErrors() as $obj)
            {
                $tmp = explode(',',$obj[0]);
                if ($content == '')
                    $content .= $tmp[0];
                else
                    $content .= '<br/>'.$tmp[0];
            }
            $this->setLogUser('Đăng Nhập',$model->username,$content);
        } else {
            $param = $model->attributes;
            $process = new GLoginProcess();
            $process->setForm($model);
            $process->setParams($param);
            $ret = $process->execute();
            
            if ($ret == 0) {   
                
                $models = $process->getReturnModels();
                
                if ($models) {                    
                    $this->setLogUser('Đăng Nhập',$model->username,'Đăng Nhập Thành Công');  

                    if(!param('skip_forum'))
                    {
                        # region Set cookie for forum
                        $forum = new VbbForum();
                        if ($forum->process_login(array('userid' => $models[0]->model->userforum_id, 'password' => $models[0]->model->password))) {
                            $duration = $param['rememberMe'] ? 3600 * 24 * 30 : 0; // 30 days
                            Yii::app()->user->login($models[0], $duration);

                        }
                        # endregion
                    }
                    else
                    {                        
                        $duration = $param['rememberMe'] ? 3600 * 24 * 30 : 0; // 30 days
                        Yii::app()->user->login($models[0], $duration);                        
                    }                               
                    if (Yii::app()->user->returnUrl == '/' || Yii::app()->user->returnUrl == (Yii::app()->createAbsoluteUrl('').'/'))                             $this->redirect('/play');                    
                    $this->redirect(Yii::app()->user->returnUrl);
                }
                
                Yii::app()->user->setFlash('error', t('COM_ERR_RETURNMODELS'));
                $this->setLogUser('Đăng Nhập',$model->loginname,t('COM_ERR_RETURNMODELS'));  
            }
            if ($ret == 1) {
                $errors = $process->getErrors();
                Yii::app()->user->setFlash('error', $errors);

                $this->setLogUser('Đăng Nhập',$model->loginname,$errors);  
            }
        }         
        Yii::app()->user->setState("login_attempt", ++$login_attempt);
        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(array('/user/login', 'login_attempt' => $login_attempt));
    }

    public function actionRegister() {     
        $signupForm = new SignUpForm;
        $src = null;
        if (Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['SignUpForm']) && Yii::app()->request->isAjaxRequest  )
            {
                $this->actionSignUp($signupForm);
                $message = array();
                if (!Yii::app()->user->isGuest) {
                    $message['error'] = 0;
                    $message['value'] =  'Đăng Ký Thành Công';                                                        
                     $server =  Servers::model()->find(array('condition'=>'status = 1 and published_date <= now()','order'=>'published_date desc'));
                    if (isset($server->server_id)) {
                        $en_sid = Encrypts::instance()->Encrypt('server',$server->server_id);                        
                        $convertion = bin2hex('changioi');          
                        $message['sid'] =  $en_sid;                                                        
                        $message['con'] =  $convertion;  
                     }            
                     else {
                         $message['sid'] = 'play';
                     }                                          
                    echo json_encode($message);
                    die;
                }
                if (Yii::app()->user->hasFlash('error'))
                {
                    $message['error'] = 1;
                    $message['value'] =  Yii::app()->user->getFlash('error');
                    echo json_encode($message);
                    die;
                }                               
            }
            yii::app()->end();
        }
        if (!empty($_GET['src']))
            $src = $_GET['src'];
        if (!Yii::app()->user->isGuest)        
            Yii::app()->user->setFlash('error', t('COM_ERR_LOGINED'));
        else if (isset($_POST['SignUpForm'])) {
                $this->actionSignUp($signupForm);
            }
            $signupForm->password = '';
        $signupForm->usersource = $src;
        $this->render('register', array('signupForm' => $signupForm)); //, 'lstnews' => $news, 'lstnews_game' => $lstnews_game));
    }


    public function actionSignUp(&$model) {
        $model->attributes = $_POST['SignUpForm'];
        if (isset($_POST['SignUpForm']['usersource']))
        {
            $keysrc = Keysrc::model()->find('lower(keysrc) = lower(:p_key) ',array('p_key'=>$_POST['SignUpForm']['usersource']));
            if (!empty($keysrc))
                $model->usersource = $keysrc->keysrc ;// $_POST['SignUpForm']['usersource'];
        }

        if (isset(Yii::app()->session['pid']))
        {
            $check_pid = Partners::model()->find('partner_pkey = :pkey and status = 1 and del_flg != 1',array(
            'pkey'=>Yii::app()->session['pid']
            ));
            if (isset($check_pid)) {
                $model->pid = $check_pid->partner_id;                                        
            }
        }

        if (!$model->validate()) {
            Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            $content = '';
            foreach($model->getErrors() as $obj)
            {
                if ($content == '')
                    $content .= $obj[0];
                else
                    $content .= '<br/>'.$obj[0];
            }
            $this->setLogUser('Đăng Ký',$model->loginname,$content);
        } else {
            $params = $model->attributes;
            $process = new GRegistrationProcess();
            $process->setForm($model);
            $process->setParams($params);
            $ret = $process->execute();
            if ($ret == 0) {
                if ($models = $process->getReturnModels()) {
                    $this->setLogUser('Đăng Ký',$models[0]['display_name'],'Đăng Ký Thành Công');     
                    if(!param('skip_forum')){
                        #region sync forum
                        $process_forumreg = new ForumRegistrationProcess();
                        $process_forumreg->setForm($models[0]);
                        $process_forumreg->setParams(array('username' => $models[0]['display_name'], 'password' => $params['password'], 'email' => $params['email']));
                        if ($process_forumreg->execute() == 0) {
                            $user_forum = $process_forumreg->getReturnModels();
                            # region Set cookie for forum
                            $forum = new VbbForum();
                            if ($forum->process_login(array('userid' => $user_forum[0], 'password' => $models[0]['password']))) {
                                //set login
                                $user = new UserIdentity($models[0]['display_name'], $params['password']);
                                $user->authenticate();
                                Yii::app()->user->login($user, 0);
                            }
                            # endregion
                        }
                        #endregion
                    }
                    else
                    {
                        $user = new UserIdentity($models[0]['display_name'], $params['password']);
                        $user->authenticate();
                        Yii::app()->user->login($user, 0);
                        
                    }
                     /** vao server moi nhat **/                   
                    if (!Yii::app()->user->isGuest && !Yii::app()->request->isAjaxRequest) {
                        $server =  Servers::model()->find(array('condition'=>'status = 1 and published_date <= now()','order'=>'published_date desc'));
                        if (isset($server->server_id)) {
                        $en_sid = Encrypts::instance()->Encrypt('server',$server->server_id);                        
                        $convertion = bin2hex('changioi');          
                        $this->redirect(Yii::app()->createUrl('/play/entergame',array('serverid'=>$en_sid,'convertion'=>$convertion)));
                        }
                        else
                            $this->redirect(array('/play'));
                        Yii::app()->end();
                    }                    
                }
                Yii::app()->user->setFlash('error', t('COM_ERR_RETURNMODELS'));
                $this->setLogUser('Đăng Ký',$model->loginname,t('COM_ERR_RETURNMODELS'));
            }

            if ($ret == 1) {
                $errors = $process->getErrors();
                Yii::app()->user->setFlash('error', $errors);
                $this->setLogUser('Đăng Ký Tài Khoản',$model->loginname,$errors);  
            }
        }
    }

    /**
    *
    * @param type $receiver : Tài khoản người Nhận
    * @param type $subject
    * @param type $view : layout mail tại common.views.mail
    * @param type $data : biến truyền vào layout
    */
    private function sendMail($receiver, $subject, $view, $data = array()) {

        $message = new YiiMailMessage;
        $message->view = $view;
        $params = $data;
        $message->subject = $subject;
        $message->setBody($params, 'text/html');
        $message->addTo($receiver);
        $mailserver = param('mail.server');
        $message->from = $mailserver['username'];
        Yii::app()->mail->send($message);
    }

    /**
    * Lưu log đăng nhập
    * 
    * @param string $action
    * @param string $username
    * @param string $content
    */
    private function setLogUser($action,$username,$content)
    {                   
        return;
        $loguser = new LogUser();
        $loguser->username = $username;
        $loguser->content = $content;
        $loguser->action = $action;
        $loguser->ip = $this->getIpAddress();//$_SERVER['REMOTE_ADDR'];
        $loguser->createddate = date('Y-m-d H:i:s');
        $loguser->save();
    }

    function logincount()
    {
        if (!app()->user->isGuest)
        {
            $model = new Activerecord();
            $user = $model->find('user_id = :p_uid and date(recordate) = date(now())',array(':p_uid'=>app()->user->getId()));
            if (!empty($user))
            {
                $user->logincount = intval($user->logincount)+1;
                $user->save();
            }
            else
            {
                $model->user_id = app()->user->getId();
                $model->recordate = new CDbExpression('NOW()');
                $model->logincount = 1;
                $model->save();         
            }
        }
    }

    /**
    * Get client IP address
    * @return string
    */
    function getIpAddress() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return '';
    }
    public function actionloadPopupLogin() {
        $model = new LoginForm();
        Yii::app()->clientScript->scriptMap['jquery.min.js']=false;            
        $this->renderPartial('popuplogin',array('model'=>$model),false,true);
    }
    public function actionloadPopupRegist() {
        $model = new SignUpForm();
        $this->renderPartial('popupregist',array('model'=>$model),false,true);
    }
   

}
