<?php

class ChannelplayController extends FacebookController {

    protected $assetsUrl;
 

    public function actionEntergame() {   
        
        if (app()->user->isGuest) {
            $this->redirect(app()->createUrl($this->module->name.'/default'));
        }
        
        $serverId = r()->getParam('serverid'); 
        $serverId = Encrypts::instance()->Decrypt('server',$serverId);
        if(!$serverId) $this->redirect(Yii::app()->createUrl($this->module->name.'/default'));
        $line = r()->getParam('line');
        $now = new CDbExpression('now()');  
        $model = Servers::model()->findByPk($serverId,array('condition'=>'status NOT IN (0,2) '));
        if(empty($model)) $this->redirect(array('/play'));     
        $time_end = strtotime($model->published_date);
        $time_wait = $time_end - time();
        if($time_wait > 0 && in_array($model->status,array(1,3)))
        {
            $this->pageTitle = $model->server_name;            
            $this->renderPartial('maintenance',array('model' => $model),false,true);
        }
        else
        {            
            Yii::app()->session['serverInfo'] = $model;
            $this->render('entergame', array('model' => $model, 'line' => $line));
        }
    }
   
    public function actionCallUrlserver() {
                   
        $server = new Servers();
        $server = Yii::app()->session['serverInfo'];
        
        /** thong ke dang nhap game **/
        $statistic = new Statisticlogingame();
        $statistic = $statistic->find('date = date(now()) and serverid = :p_sid',array(':p_sid'=>$server->server_id));
        if (!empty($statistic))
        {
            $statistic->count = $statistic->count+1;
            $statistic->save() ;
        }
        else
        {
            $statistic = new Statisticlogingame();      
            $statistic->serverid = $server->server_id;
            $statistic->count = 1;
            $statistic->date = new CDbExpression('Now()');
            $statistic->save();
        }
        
         if(!isset($_SESSION['serverInfo']) || empty($_SESSION['serverInfo']))
        {
            $this->redirect('play');
            app()->end();
        }
        $server = new Servers();
        $server = $_SESSION['serverInfo'];
        $serverurl = $server->dx;
        $timestamp = time();
        $username = app()->user->getId();//GHelpers::EncryptAccountName(app()->user->getName(),app()->user->getId());
        $sign = md5($username.$timestamp.param('server')['MXDHKEY']);
        $arr_params = array(
            'enterAccount'=>$username,
            'sign'=>$sign,
            'timestamp'=>$timestamp
        );        
        $gotourl = 'http://'.$serverurl.':'.$server->port.'/'.$server->fileUrl .'?'. http_build_query($arr_params);
        header('Location:'.$gotourl);
   
    }

    private function LogPlay($server_id) {
        $user_id = app()->user->getId();
        $checkexist = UserServers::model()->find('user_id=:user_id AND server_id=:server_id', array(':user_id' => $user_id, ':server_id' => $server_id));
        if ($checkexist == null) {
            $checkexist = new UserServers();
            $checkexist->user_id = $user_id;
            $checkexist->server_id = $server_id;
            $checkexist->lastplay = new CDbExpression('NOW()');
            $checkexist->save();
        } else {
            $checkexist->lastplay = new CDbExpression('NOW()');
            $checkexist->save();
        }
    }

}
