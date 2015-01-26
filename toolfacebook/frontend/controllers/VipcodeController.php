<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VipcodeController extends Controller {

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'foreColor' => 0x0099CC,
            ),
        );
    }

    public function accessRules() {
        return array(
            // not logged in users should be able to login and view captcha images as well as errors
            array('deny', 'actions' => array('register'), 'user' => '@'),
            array('allow', 'actions' => array('index', 'captcha', 'login', 'error', 'KK')),
            array('allow', 'actions' => array('receiveip'), 'users' => array('@')),
            // logged in users can do whatever they want to
            array('allow', 'users' => array('@')),
            // not logged in users can't do anything except above
            array('deny'),
        );
    }
    public function actionReceivevip()
    {
            $server_id = app()->request->getParam('server_id');

            if (app()->user->isGuest) {
                echo json_encode(array('status' => 'error', 'url' => 'Chưa đăng nhập'));
                die();
            }
            $userid = app()->user->getId();
            if (empty($server_id)) {
                echo json_encode(array('status' => 'error', 'url' => 'Chưa chọn server'));
                return;
            }
            $server = Servers::model()->find('server_id=:server_id AND status = 1', array(':server_id' => $server_id));
            if ($server == null) {
                    echo json_encode(array('status' => 'error', 'url' => 'Server này không tồn tại hoặc đã khóa'));
                    return;
            }
            $rechargeUrl = $server['rechargeUrl'];
            $urlService = $rechargeUrl . param('gold')['serviceUrl']; 
            if (!remote_file_exists($urlService)) {
                echo json_encode(array('status' => 'error', 'url' => 'Kết nối đến hệ thống server thất bại'));
                die();
            }
            $result = GService::nhapvip($server,Yii::app()->user->getName(),Yii::app()->user->getId());
            if ($result['status']==1)
            {
                echo json_encode(array('status' => 'success', 'url' => 'Đã Nhận Vip'));
                die();
            }
            else
            {
                echo json_encode(array('status' => 'error', 'url' => 'Nhận Vip Không Thành Công '.$result['error'] ));
                die();
            }
                
    }

   

}
