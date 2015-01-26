<?php
    class PaymentController extends Controller
    {
        public $defaultAction = 'napthe';
        public function actions() {
            return array(
                // captcha action renders the CAPTCHA image displayed on the contact page
                'captcha' => array(
                    'class' => 'CCaptchaAction',
                    'backColor' => 0xFFFFFF,
                ),);
        }
        public function actionNapthe() {
            if (app()->user->isGuest) {
                app()->user->setReturnUrl(app()->request->url);
                app()->user->setFlash('error', t('COM_ERR_NOT_LOGIN'));
                $this->redirect(app()->createUrl('user/login'));
            }     
            $model = new RequestCard;
            if (isset($_POST['RequestCard'])) {
                $this->actionNapthe2($model);
            }
            // display the login form
            $this->render('/requestcard/requestcard', array('model' => $model));
        }

        public function actionNapthe2(&$model) {
            $model->attributes = $_POST['RequestCard'];
            if (!$model->validate()) {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            } 
            else {
                  
                $plusgold = new GService();                
                $servers = Servers::model()->findByPk($model->ServerId,'status = 1');                                
                $checkuser = $plusgold->checkPlayer($servers,Yii::app()->user->getName(),Yii::app()->user->getId());          
                if ($checkuser == '1')
                {                    
              
                    $is_product = Yii::app()->params['deposit']=='production'?true:false;
                    $ws = new CardChargedResponse();
                    if ($is_product) {
                        $params = array(
                            'serial'=>$model->Serial,
                            'card_type'=>$model->CardId,
                            'pin'=>$model->Pin,
                            'userid'=>Yii::app()->user->id,
                            'ServerId'=>$servers->server_id,
                        );
                        $cardrespond = new CardChargedResponse();
                        $process = new Paymentprocess();
                        $process->setForm($cardrespond);
                        $process->setParams($params);
                        $ret = $process->execute();
                        if ($ret == 0) {
                            $models = $process->getReturnModels();
                            $ws = $models[0];
                        }
                        if ($ret == 1) {
                            $ws->retCode = 0;
                            $ws->retMsg = $process->getErrors();;
                        }
                    }
                    else {
                        $ws->retCode = -1;
                        $ws->retMsg = 'Chức năng nạp thẻ hiện không thực hiện được';
                    }                            
                    if ($ws->retCode != 1) 
                        Yii::app()->user->setFlash('error', $ws->retMsg);
                    else {                        
                        $money = $ws->data_cardValue;
                        $process = new GRequestCardProcess();
                        $checkSave = $process->saveMoney($money, Yii::app()->user->id);                        
                        if ($checkSave) {                            
                            #region add gold
                            $golden = $this->convertToGold($money);
                            
                             $promotion = GoldSale::model()->find(array('condition'=>"ServerId = :server AND NOW() BETWEEN ApplyFrom AND ApplyTo AND Status = 1",'params'=>array(':server'=>$model->ServerId)));

                             if($promotion !== null) 
                             {
                                    $golden *= $promotion->Rate;
                                    $golden = round($golden, 0, PHP_ROUND_HALF_UP);
                             }                            
                            $response = $plusgold->naptien($servers,Yii::app()->user->getName(),Yii::app()->user->getId(),$golden);
                            if (isset($response) && $response == true && $golden > 0) {
                                $turn = GConst::$Quayso[$money];
                                $process->saveQuayso($servers['server_id'], Yii::app()->user->id, $turn);
                                $tranfer = UsersMoney::model()->findByPk(Yii::app()->user->id);                                
                                $tranfer->current_money -= $money;
                                $tranfer->trans_money += $money;
                                $tranfer->save();
                                Yii::app()->user->setFlash('success', 'Yêu cầu nạp KNB thành công. Bạn được cộng ' . $golden . ' KNB vào máy chủ ' . $servers->server_name);
                            } else
                                Yii::app()->user->setFlash('error', $response . ' Tài Khoản Chưa Nhận Được KNB. Liên Hệ Admin');
                            $model->resetForm();
                            #endregion
                        } else
                            Yii::app()->user->setFlash('error', 'Có lỗi xảy ra trong quá trình nạp thẻ, vui lòng liên hệ admin.');  
                    }
                }  
                else
                {
                    Yii::app()->user->setFlash('error',$checkuser);
                }
            }
        }
        private function convertToGold($cash)
        {
            $gold = GoldenConfig::model()->find(array('condition' => 'Cash=:cash AND Status = 1', 'params' => array(':cash' => $cash)));
            if ($gold === null)
                return (int) -1;
            return (int) $gold->Gold;
        }
    }
?>
