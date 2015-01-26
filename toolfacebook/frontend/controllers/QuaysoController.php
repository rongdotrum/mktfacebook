<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class QuaysoController extends Controller {

    

    public function accessRules() {

        return array(
        );
    }

    public function actionIndex() {
        
        if(isset(Yii::app()->params['sysconfig']['flg_quayso']))
            $sys = Yii::app()->params['sysconfig']['flg_quayso'];           
        if (!isset($sys) || $sys != '1')
        {
            if (Yii::app()->request->isAjaxRequest)
                die('Hoạt động này chưa mở');
            else
                $this->render('index',array('message'=>'Hoạt động quay số chưa mở'));           
        }   
        
        
        if (app()->user->isGuest) {
            app()->user->setReturnUrl(app()->request->url);
            app()->user->setFlash('error', t('COM_ERR_NOT_LOGIN'));
            $this->redirect(app()->createUrl('user/login'));
        }
        $this->render('/quayso/chonserver');
    }

    public function actionServers() {

       if(isset(Yii::app()->params['sysconfig']['flg_quayso']))
            $sys = Yii::app()->params['sysconfig']['flg_quayso'];        
        if (!isset($sys) || $sys != '1')
        {
            if (Yii::app()->request->isAjaxRequest)
                die('Hoạt động này chưa mở');
            else
                $this->render('index',array('message'=>'Hoạt động quay số chưa mở'));           
        }   
        
        
        
        if (app()->user->isGuest) {
            app()->user->setReturnUrl(app()->request->url);
            app()->user->setFlash('error', t('COM_ERR_NOT_LOGIN'));
            $this->redirect(app()->createUrl('user/login'));
        }        
        if (isset($_POST['game_code']) && $_POST['game_code'] == 'vieautog4g$#@!') {

            $server_id = $_POST['server_id'];
            $server = Servers::model()->find('server_id=:server_id', array(':server_id' => $server_id));
            if ($server['status'] != 1)
                $this->redirect(app()->createUrl('site'));
            $urlService = $server['rechargeUrl'] . param('ingame')['serviceUrl'];
            //$urlService = 'http://localhost/ttq/trunk/source/gameservices/' . param('ingame')['serviceUrl'];
            $username = app()->user->getId(); //GHelpers::EncryptAccountName(app()->user->getName(), app()->user->getId());
            $userid = app()->user->getId();
            $key = param('gold')['key'];
            $sign = md5($username . $key);
            $params = array('username' => $username,'dbname'=>$server->dbname, 'sign' => $sign);
            ini_set('soap.wsdl_cache_enable', 0);
            ini_set('soap.wsdl_cache_ttl', 0);
            $client = new SoapClient(null, array('location' => $urlService, 'uri' => "localhost"));
            // check user
            $result = $client->__soapCall('GetPlayerInfo', $params);
            if ($result == array())
                die('chưa tạo nhân vật');
            $player = $result[0]['NAME'];
            $quayso = UsersQuayso::model()->find('userid=:userid AND server_id=:server_id', array(':userid' => $userid, ':server_id' => $server_id));
            $turn = $quayso['turn'];
            $servername = $server['server_name'];
            echo("&username=$player&turn=$turn&servername=$servername");
            die();
        }
        else {            
            $userid = app()->user->getId();
            $server_id = app()->request->getParam('ID');
            $quayso = UsersQuayso::model()->find('userid=:userid AND server_id=:server_id AND turn>0', array(':userid' => $userid, ':server_id' => $server_id));
            $data = true;
            if ($quayso == null)
                $data = false;
            if ($server_id == '')
                $this->redirect(app()->createUrl('site'));
            $this->layout = '//layouts/main_quayso';
            $phanthuong = $this->listPhanThuong();
            $lichsu = $this->listHistory($server_id);
            $this->render('/quayso/quayso', array('data' => $data, 'phanthuong' => $phanthuong, 'lichsu' => $lichsu));
        }
    }

    public function actionPhatthuong() {
                
        if(isset(Yii::app()->params['sysconfig']['flg_quayso']))
            $sys = Yii::app()->params['sysconfig']['flg_quayso'];                
        if (!isset($sys) || $sys != '1')
        {
            if (Yii::app()->request->isAjaxRequest)
                die('Hoạt động này chưa mở');
            else
                $this->render('index',array('message'=>'Hoạt động quay số chưa mở'));           
        }   
        
        
        if (app()->user->isGuest) {
            die();
        }
        if (isset($_POST['game_code']) && $_POST['game_code'] == 'vieautog4g$#@!') {
            $userid = app()->user->getId();
            $server_id = $_POST['server_id'];
            $player = $_POST['player'];
            $quaysoitem = QuaysoItem::model()->findAll('idingame=0 and percent != 0');
            $process = new GQuaysoProcess();
            $randint = rand(1, 1000);
            $type = 'GOLD';
            $idingame = 0;
            $item = array();
            
            if ($randint <= (int) $quaysoitem[0]['percent']) {
                $item = $process->getItemLevel($quaysoitem[0]['percent'], $idingame);
            } 
            elseif (count($quaysoitem)==1)
            {
                $item = $process->getItemLevel($quaysoitem[0]['percent'], $idingame);
            }
            elseif ($randint <= (int) $quaysoitem[0]['percent'] + (int) $quaysoitem[1]['percent'] && $randint > $quaysoitem[0]['percent']) {
                $item = $process->getItemLevel($quaysoitem[1]['percent'], $idingame);
            } elseif ($randint <= (int) $quaysoitem[0]['percent'] + (int) $quaysoitem[1]['percent'] + (int) $quaysoitem[2]['percent'] && $randint > (int) $quaysoitem[0]['percent'] + (int) $quaysoitem[1]['percent']) {
                $item = $process->getItemLevel($quaysoitem[2]['percent'], $idingame);
            } elseif ($randint <= (int) $quaysoitem[0]['percent'] + (int) $quaysoitem[1]['percent'] + (int) $quaysoitem[2]['percent'] + (int) $quaysoitem[3]['percent'] && $randint > (int) $quaysoitem[0]['percent'] + (int) $quaysoitem[1]['percent'] + (int) $quaysoitem[2]['percent']) {
                $item = $process->getItemLevel($quaysoitem[3]['percent'], $idingame);
            } else {
                $item = $process->getItemLevel($quaysoitem[4]['percent'], $idingame);
            }           
            if ($type == 'GOLD') {
                $quayso_return = new UsersQuayso();
                $quayso_return = $quayso_return->find('userid=:userid AND server_id=:server_id', array(':userid' => $userid, ':server_id' => $server_id));
                if ($quayso_return->turn <= 0)
                    die();
                $itemid = $item['itemid'];
                $nameitem = $item['itemname'];
                $gold = $item['count'];
                $server = Servers::model()->find('server_id=:server_id', array(':server_id' => $server_id));
                ini_set('soap.wsdl_cache_enable', 0);
                ini_set('soap.wsdl_cache_ttl', 0);
                $urlService = $server['rechargeUrl'] . param('gold')['serviceUrl'];                
                $client = new SoapClient(null, array('location' => $urlService, 'uri' => "localhost"));
                $key = param('gold')['key'];
                $golden = $gold;
                $serverId = $server_id;
                $uname = app()->user->getId();//GHelpers::EncryptAccountName(app()->user->getName(), app()->user->getId());
                $sign = md5($uname . $golden . $key);
                $data = $client->__soapCall('naptien', array('uname' => $uname, 'golden' => $golden, 'dbname'=>$server->dbname, 'sign' => $sign));          
                //$data = explode('.', $data);
                $code = $data;
                if ($code == 1 && $golden > 0) {

                    $quayso_return->turn = $quayso_return->turn - 1;
                    $quayso_return->save();
                    $quayso = Quayso::model()->findAll('itemid=:itemid', array(':itemid' => $itemid));   
                    while (true) {
                        $rd = rand(0, sizeof($quayso) - 1);
                        $position = $quayso[$rd]['position'];
                        if ($position != 1)
                            break;
                    }
                    
                    $logquayso = new LogQuayso();
                    $logquayso->userid = $userid;
                    $logquayso->username = app()->user->getName();
                    $logquayso->content = number_format($gold) . '-' . $nameitem;
                    $logquayso->server_id = $server_id;
                    $logquayso->datequay = new CDbExpression('NOW()');
                    if ($item['idingame'] == 0)
                        $logquayso->type = 0;
                    else
                        $logquayso->type = 1;
                    $logquayso->quantily = $gold;
                    $logquayso->save();
                    echo("&prize=$position");
                    die();
                }
            } else {

            }
        }
    }

    public function listPhanThuong() {
        $quayso = new QuaySo('Search');
        return $quayso;
    }

    public function listHistory($serverid) {
        $logquayso = new LogQuayso('Search');
        $logquayso->server_id = $serverid;
        $logquayso->userid = app()->user->getId();
        return $logquayso;
    }
    
}

