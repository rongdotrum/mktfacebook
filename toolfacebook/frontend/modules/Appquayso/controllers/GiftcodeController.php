<?php
    class GiftcodeController extends FacebookController {
        public function actionIndex() {
            $this->renderPartial('index',array(),false,true);
        }

        public function actiongetGiftCode() {
            if (Yii::app()->user->isGuest || !isset(app()->request->cookies['fb_name']) || app()->request->cookies['fb_name']->value == '') {
                echo CJSON::encode(array('success' => false, 'message' => 'Chưa Đăng Nhập'));
            } else {
                $share = new GiftcodeFanpageShare();
                $share = $share->find('userid=:userid', array(':userid' => app()->user->getId()));
                if ($share == null) {
                    echo CJSON::encode(array('success' => false, 'message' => 'Vui lòng LIKE và MỜI BẠN BÈ trước khi nhận code'));
                    exit;
                } else {
                   $server_id = app()->request->getParam('server_id');          
                   $code = app()->request->getParam('code');                        
                   $server = Servers::model()->findByPk($server_id,'status = 1 and published_date <= now()');
                   $giftcode_process = new GiftcodeProcess();
                   $params = array(
                        'serverid'=>$server_id,
                        'username'=>Yii::app()->user->getName(),
                        'userid'=>Yii::app()->user->getId(),
                        'code'=>$code,
                        'tanthu'=>0
                   );
                    $giftcode_process->setParams($params);                   
                    $result = $giftcode_process->execute();
                    if ($result == 0)
                    {
                        echo json_encode(array('success' => true, 'message' => 'Nhận giftcode thành công'));                
                    }
                    else
                    {
                        $error = $giftcode_process->getErrors();
                        echo json_encode(array('success' => false, 'message' => $error));                      
                    }                   
                }
            }
        }        
        public function actionlistgiftcode() {
            if(!Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest) {
                $status = app()->request->getParam('status');
                $serverid = (int) app()->request->getParam('servergift');
                $serverid_getcode = app()->request->getParam('serverid');
                $userid = app()->user->getId();
                if ($status == 'success' && $serverid_getcode != 0) {
                    $loggift = GiftCodeReceiveLog::model()->find('serverid=:serverid AND userid=:userid AND isGet=1', array(':serverid' => $serverid_getcode, ':userid' => $userid));
                    if ($loggift == null) {
                        $this->redirect(app()->createUrl('site'));
                    }
                    $server = Servers::model()->find('server_id=:server_id AND status = 1', array(':server_id' => $serverid_getcode));
                    $listgift = GiftcodeGameitem::model()->findAll('serverid=:serverid', array('serverid' => $serverid));
                    $this->renderPartial('/giftcode/listgiftcode', array('listgift' => $listgift, 'server' => $server),false,false);
                }
            }
        }
        
        public function actionSaveshare() {
            if (app()->user->isGuest || !isset(app()->request->cookies['fb_name']) || app()->request->cookies['fb_name']->value == '') {
                die('nologin');
            } else {
                $share = new GiftcodeFanpageShare();
                $share = $share->find('userid=:userid', array(':userid' => app()->user->getId()));
                if ($share == null) {
                    $share = new GiftcodeFanpageShare();
                    $share->userid = app()->user->getId();
                    $share->dateshare = new CDbExpression('NOW()');
                    $share->save();
                }
            }
        }
    }
?>
