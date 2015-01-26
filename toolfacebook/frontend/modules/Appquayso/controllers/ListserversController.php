<?php

class ListserversController extends FacebookController {

    private $size = 100;

    public function actionIndex() {
        /* if (app()->user->isGuest) {
          app()->user->setReturnUrl(app()->request->url);
          app()->user->setFlash('error', t('COM_ERR_NOT_LOGIN'));
          $this->redirect(app()->createUrl('user/login'));
          } */
        $now = new CDbExpression('now()');
        $lst_Server = Servers::model()->findAll(array('condition'=>'status=1 and published_date <= '.$now,'order' => 'created_date DESC'));
        $this->render('index', array('model' => $lst_Server));
        
    }

}
