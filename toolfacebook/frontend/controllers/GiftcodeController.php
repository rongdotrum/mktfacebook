<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GiftcodeController extends Controller {

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'foreColor' => 0x0099CC,
            ),
            'forgetpass' => array('class' => 'application.controllers.actions.user.forgetpass')
        );
    }

    public function accessRules() {
        return array(
            // not logged in users should be able to login and view captcha images as well as errors
            array('deny', 'actions' => array('register'), 'user' => '@'),
            array('allow', 'actions' => array('index', 'captcha', 'login', 'error', 'KK')),
            array('allow', 'actions' => array('changepass'), 'users' => array('@')),
            // logged in users can do whatever they want to
            array('allow', 'users' => array('@')),
            // not logged in users can't do anything except above
            array('deny'),
        );
    }

    public function actionListGift() {
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

            $this->render('/giftcode/listgift', array('listgift' => $listgift, 'server' => $server));
        }
        else
            $this->redirect(app()->createUrl('site'));
    }

    public function actionAddGiftCode() {
        $server_id = app()->request->getParam('server_id');
        $code = app()->request->getParam('code');
        $tanthu = app()->request->getParam('tanthu');
        if (app()->user->isGuest) {
            echo json_encode(array('status' => 'error', 'url' => 'Chưa đăng nhập'));
            die();
        }
        $userid = app()->user->getId();
        if ($server_id == '') {
            echo json_encode(array('status' => 'error', 'url' => 'Chưa chọn server'));
            die();
        }
        if ($code == '' && $tanthu == 0) {
            echo json_encode(array('status' => 'error', 'url' => 'Chưa nhập code'));
            die();
        }
        $servers = Servers::model()->findByPk($server_id);
        $checkuser = GService::checkPlayer($servers,Yii::app()->user->getName(),Yii::app()->user->getId());
        if($checkuser != '1')
        {
              echo json_encode(array('status' => 'error', 'url' => 'Chưa tạo nhân vật'));
              die;
        }
        
        $giftcode_process = new GiftcodeProcess();
        $params = array(
            'serverid'=>$server_id,
            'username'=>Yii::app()->user->getName(),
            'userid'=>Yii::app()->user->getId(),
            'code'=>$code,
            'tanthu'=>$tanthu
        );
        $giftcode_process->setParams($params);
        $result = $giftcode_process->execute();
        if ($result == 0)
        {
            if ($tanthu ==0)
                $resultarr = array('status' => 'success', 'url' => 'Nhận giftcode thành công');
            elseif ($tanthu==3)
                $resultarr = array('status' => 'success', 'url' => 'Nhận quà online thành công');
            else
                $resultarr = array('status' => 'success', 'url' => 'Nhận quà tân thủ thành công');
            echo json_encode($resultarr);
        }
        else
        {
            $error = $giftcode_process->getErrors();
            $resultarr = array('status' => 'error', 'url' => $error);
            echo json_encode($resultarr);
        }
        
    }

}
