<?php

class UsersController extends Controller {

    /**
    * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
    * using two-column layout. See 'protected/views/layouts/column2.php'.
    */
    public $layout = '//layouts/column1';

    /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate() {
        $model = new Users;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->user_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->email = $_POST['Users']['email'];
            if (!empty($_POST['Users']['password']))
            {
                $model->password = md5($_POST['Users']['password']);
            }
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->user_id));
        }
        $model->password = null;
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
    */
    public function actionDelete($id) {


        /*        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin')); */
        $model = $this->loadModel($id);
        $model->del_flg = abs(1 - $model->del_flg);
        if ($model->save()) {
            $Admin_Id = app()->user->getId();
            $Admin_name = app()->user->getName();
            $Action = 'Khóa tài khoản';
            $Content = 'Khóa tài khoản ' . $model->display_name . "(ID=$id)";
            $Ip = $_SERVER['REMOTE_ADDR'];
            $Datetime = new CDbExpression('NOW()');
            $AdminLog = new AdminLog();
            $AdminLog->Admin_Id = $Admin_Id;
            $AdminLog->Admin_name = $Admin_name;
            $AdminLog->Action = $Action;
            $AdminLog->Content = $Content;
            $AdminLog->Ip = $Ip;
            $AdminLog->Datetime = $Datetime;
            $AdminLog->save();
            $this->redirect(array('view', 'id' => $model->user_id));
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
    * Lists all models.
    */
    public function actionIndex() {
        //        $dataProvider = new CActiveDataProvider('Users');
        //        $this->render('index', array(
        //            'dataProvider' => $dataProvider,
        //        ));
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users']))
            $model->attributes = $_GET['Users'];

        $this->render('index', array(
            'model' => $model,
        ));
    }


    /**
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer the ID of the model to be loaded
    */
    public function loadModel($id) {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
    * Performs the AJAX validation.
    * @param CModel the model to be validated
    */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPlusgold($id) {
        $model = new PlusGold();
        $user = $this->loadModel($id);
        $model->display_name = $user->display_name;
        $model->email = $user->email;
        if (isset($_POST['PlusGold'])) {
            $model->attributes = $_POST['PlusGold'];
            if (!$model->validate()) {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            } else {
                $server = Servers::model()->findByPk($model->server_id);
                $Admin_Id = app()->user->getId();
                $Admin_name = app()->user->getName();
                $Action = 'Cộng Gold';
                $Content = $Action . ' ' . $model->gold . ' cho tài khoản ' . $model->display_name . "(ID=$id) ở máy chủ $server->server_name";
                $Ip = $_SERVER['REMOTE_ADDR'];
                $Datetime = new CDbExpression('NOW()');
                $AdminLog = new AdminLog();
                $AdminLog->Admin_Id = $Admin_Id;
                $AdminLog->Admin_name = $Admin_name;
                $AdminLog->Action = $Action;
                $AdminLog->Ip = $Ip;
                $AdminLog->Datetime = $Datetime;
                $params = array(
                    'UserName' => $user->user_id,//$model->display_name,
                    'PlusDate' => new CDbExpression('NOW()'),
                    'Gold' => $model->gold,
                    'ServerId' => $model->server_id,
                    'Admin' => app()->user->getName(),
                );
                $log = new LogPlusgold();
                $log->attributes = $params;
                if (!$log->save()) {
                    Yii::app()->user->setFlash('error', CHtml::errorSummary($log));
                    $AdminLog->Content = $Content . " (không thành công)";
                    $AdminLog->save();
                } else {
                    $log_id = $log->dbConnection->getLastInsertID();


                    if ($server === null) {
                        Yii::app()->user->setFlash('error', 'Chọn sai server. Vui lòng chọn lại!');
                        $AdminLog->Content = $Content . " (không thành công)";
                        $AdminLog->save();
                    } else {
                        $urlService = $server->rechargeUrl . param('gold')['serviceUrl'];
                        $key = param('gold')['key'];
                        if (!remote_file_exists($urlService)) {
                            Yii::app()->user->setFlash('error', 'Không thể kết nối đến hệ thống máy chủ game.</br>Bạn chắc chắn chọn đúng máy chủ?. Vui lòng liên hệ admin để được khắc phục!');
                            $AdminLog->Content = $Content . " (không thành công)";
                            $AdminLog->save();
                        } else {
                          
                            $check_user = GService::checkPlayer($server,$user->display_name,$user->user_id);

                            if ($check_user < 0) {
                                switch ($check_user) {
                                    case -11:Yii::app()->user->setFlash('error', 'Xác thực không hợp lệ');
                                        break;
                                    case -15:Yii::app()->user->setFlash('error', 'Sai địa chỉ IP');
                                        break;
                                }
                                $AdminLog->Content = $Content . " (không thành công)";
                                $AdminLog->save();
                            } elseif ($check_user == 0) {
                                Yii::app()->user->setFlash('error', 'Không tồn tại tài khoản trong game');
                                $AdminLog->Content = $Content . " (không thành công)";
                                $AdminLog->save();
                            } elseif ($check_user > 1) {
                                Yii::app()->user->setFlash('error', 'Có nhiều hơn 2 tài khoản trùng tên. Vui lòng liên hệ admin.');
                                $AdminLog->Content = $Content . " (không thành công)";
                                $AdminLog->save();
                            } else {


                                #region add gold
                                $golden = $model->gold;
                                $serverId = $server->gameserver_id;
                                $uname = $user->user_id;//$user->display_name;

                                $data = GService::naptien($server,$user->display_name,$user->user_id,$model->gold);
                               
                                $code = $data;
                                if ($code == 01) {
                                    Yii::app()->user->setFlash('success', 'Tài khoản ' . $uname . ' được cộng ' . $golden . ' GOLD vào máy chủ ' . $server->server_name);
                                } else {
                                    Yii::app()->user->setFlash('error', $data[1]);
                                    $AdminLog->Content = $Content . " (không thành công)";
                                    $AdminLog->save();
                                }

                                if (isset($log_id)) {
                                    $check_log = LogPlusgold::model()->findByPk($log_id);
                                    if ($check_log === null) {
                                        $check_log = new LogPlusgold();
                                        $check_log->attributes = $params;
                                    }
                                    $check_log->Status = (int) $code;
                                    $check_log->save();
                                    $AdminLog->Content = $Content . " (Thành công)";
                                    $AdminLog->save();
                                } else {
                                    $AdminLog->Content = $Content . " (không thành công)";
                                    $AdminLog->save();
                                }
                                #endregion
                            }
                        }
                    }
                }
            }
        }
        $this->render('plusgold', array(
            'model' => $model,
        ));
    }

   
   public function actionAdditem($id) {
       $model = new SendItem();       
       $model->unsetAttributes();
       $model->user_id = $id;       
       if (isset($_POST['SendItem'])) {
           $model->attributes = $_POST['SendItem'];
           if ($model->validate()) {
               $service = new GService();
               $server = Servers::model()->findByPk($model->serverid);
               if (!isset($server->server_id))
                    Yii::app()->user->setFlash('error','Không thể kết nối đến server');
               else {
                   $player = $service->checkPlayer($server,'',$model->user_id);
                   if ($player != '1') 
                      Yii::app()->user->setFlash('error','Chưa tạo nhân vật');
                   else {
                        $mail = $service->senditem($server,$model->user_id,$model->itemid,$model->title,$model->message);
                        if ($mail == 1)
                            Yii::app()->user->setFlash('success','Đã gửi item vào nhân vật');
                        else
                            Yii::app()->user->setFlash('error','Gửi item thất bại');
                   }                   
               }  
           }
       }
       $this->render('additem',array('model'=>$model));
   }
}

