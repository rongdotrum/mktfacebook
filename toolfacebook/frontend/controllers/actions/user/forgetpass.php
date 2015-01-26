<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class forgetpass extends GBaseAction {

    public function run() {
        
        $control = $this->getController();
               
        /*** reset pass **/
        if (isset($_GET['uid']) && isset($_GET['vid']) && isset($_GET['code']))
        {
                $params = array('uid'=>$_GET['uid'],'vid'=>$_GET['vid'],'code'=>$_GET['code']);
                $model = new resetpassform();
                if (isset($_POST['resetpassform']))
                {
                    $model->attributes = $_POST['resetpassform'];
                    if ($model->validate())
                    {          
                        if ($model->check_code($_GET['uid'],$_GET['vid'],$_GET['code'])) {
                            if ($model->RecoverPass($_GET['uid'],$model->password,$_GET['vid']))
                                Yii::app()->user->setFlash('success','Mật Khẩu Đã Được Thay Đổi');
                        }
                    }   
                }
                $control->render('resetpass',array('model'=>$model,'params'=>$params));
        }
        else 
        {
             /*** xac nhận mail  **/
            $model = new ForgetPassForm();
            if (isset($_POST['forgetpassform']))          
            {                
                $model->attributes = $_POST['forgetpassform'];
                if ($model->validate()){
                    $code = $model->craete_verifycode();
                    if ($code != false)
                    {
                         $params = array('title' =>'Reset Mật Khẩu '.Yii::app()->controller->pageTitle, 'code' => $code);
                         $subject = 'Lấy Lại Mật Khẩu';
                         $view = 'forget_password';
                         $this->sendMail($model->email, $subject, $view, $params);
                         Yii::app()->user->setFlash('message', 'Kiểm Tra Mail Của Bạn Để Thay Đổi Mật Khẩu');
                    }
                }
                else
                    Yii::app()->user->setFlash('error',CHtml::errorSummary($model));                                   
            }
            $control->render('forgetpass', array('model' => $model));
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
        $message->from = Yii::app()->mail->transportOptions['username'];
        Yii::app()->mail->send($message);
    }

}
