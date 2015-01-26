<?php

class PlayController extends Controller
{
        
    public function actionComming()
    {
        $now = new CDbExpression('now()');
        $crit = new CDbCriteria();
        $crit->compare('status',1);  
        $crit->addCondition('published_date > '.$now);      
        $server_sap_mo = Servers::model()->find($crit);         
        $this->renderPartial('comming',array('model'=>$server_sap_mo),false,true);         
    }
    
    
    public function actionIndex()
    {
        if (app()->user->isGuest) {
            app()->user->setReturnUrl(app()->request->url);
            app()->user->setFlash('error', t('COM_ERR_NOT_LOGIN'));
            $this->redirect(app()->createUrl('user/login'));
        }
        $now = new CDbExpression('now()');  
        $lst_Server = Servers::model()->findAll(array('condition'=>'status=1 and published_date <= '.$now,'order' => 'created_date DESC'));         
        /**server sap mo **/        
        $crit = new CDbCriteria();
        $crit->compare('status',1);  
        $crit->addCondition('published_date > '.$now);      
        $server_sap_mo = Servers::model()->find($crit);  
        if ($server_sap_mo == null && $lst_Server == null)
            $this->redirect('/site');
        $this->render('index', array('model' => $lst_Server,'server_sap_mo'=>$server_sap_mo));
    }
    public function actionEntergame()
    {
        if (app()->user->isGuest) {
            app()->user->setReturnUrl(app()->request->url);
            app()->user->setFlash('error', t('COM_ERR_NOT_LOGIN'));
            $this->redirect(app()->createUrl('user/login'));
        }
        $serverId = Encrypts::instance()->Decrypt('server',r()->getParam('serverid'));
        $line = r()->getParam('line');
        $model = Servers::model()->findByPk($serverId,array('condition'=>'status IN (1,4) and published_date <= now()'));        
        if($model===null)
            $this->renderPartial('maintenance');
        else
        {
            $this->pageTitle .= ' '.$model->server_name;
            $_SESSION['serverInfo'] = $model;
            $this->renderPartial('entergame', array('model' => $model, 'line' => $line),false,true);
        }
    }
    public function actionCallUrlserver()
    {
        if (app()->user->isGuest) {
            app()->user->setReturnUrl(app()->createUrl('play'));
            app()->user->setFlash('error', t('COM_ERR_NOT_LOGIN'));
            $this->redirect(app()->createUrl('user/login'));
        }
        if(!isset($_SESSION['serverInfo']) || empty($_SESSION['serverInfo']))
        {
            $this->redirect('play');
            app()->end();
        }
               
        
        $server = new Servers();
        $server = $_SESSION['serverInfo'];
        
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
    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
    // return the filter configuration for this controller, e.g.:
    return array(
    'inlineFilterName',
    array(
    'class'=>'path.to.FilterClass',
    'propertyName'=>'propertyValue',
    ),
    );
    }

    public function actions()
    {
    // return external action classes, e.g.:
    return array(
    'action1'=>'path.to.ActionClass',
    'action2'=>array(
    'class'=>'path.to.AnotherActionClass',
    'propertyName'=>'propertyValue',
    ),
    );
    }
    */
}
