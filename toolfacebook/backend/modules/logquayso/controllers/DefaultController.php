<?php

class DefaultController extends Controller {

  

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

 

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new LogQuayso('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['LogQuayso']))
            $model->attributes = $_GET['LogQuayso'];

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
        $model = LogQuayso::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'log-quayso-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionReset() {
        $model = LogQuayso::model()->updateAll(array('quantily' => 0), 'type = 0');
    }
    
    public function actionDelList(){
        $check = 0;   
        if (isset($_POST['code']) && is_array($_POST['code']))
        {           
            foreach($_POST['code'] as $obj) {
                $logquayso = new LogQuayso();
                $logquayso = $logquayso->findByPk($obj);// GiftcodeInput::model()->findByPk($obj);
                if ($logquayso != null) {
                    $logquayso->status = 1;
                    if ($logquayso->save()) 
                        $check++;
                }
            }         
        }
        echo $check;
    }

}
