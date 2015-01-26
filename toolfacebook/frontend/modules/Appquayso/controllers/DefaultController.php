<?php

    class DefaultController extends FacebookController {
        public function actionIndex() {        
            if (!Yii::app()->user->isGuest){                 
                $now = new CDbExpression('now()');
                $model = Servers::model()->find(array('condition'=>'status NOT IN (0,2) and published_date <= now()','order'=>'published_date desc'));                                
                if(empty($model)) {                    
                    $model = Servers::model()->find(array('condition'=>'status NOT IN (0,2)','order'=>'published_date desc'));
                    if ($model != null ) {
                        $this->pageTitle = $model->server_name;
                        $this->renderPartial('/channelplay/maintenance',array('model' => $model));
                        Yii::app()->end();
                    }
                    else {
                        $this->redirect(Yii::app()->createAbsoluteUrl('play'));                    
                    }                                        
                }                
                Yii::app()->session['serverInfo'] = $model;                             
                $this->render('/channelplay/entergame',array());
                Yii::app()->end();
            }            
            $this->render('index');
        }
        public function actionError()
        {
            
            if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
            }
        }



    }
