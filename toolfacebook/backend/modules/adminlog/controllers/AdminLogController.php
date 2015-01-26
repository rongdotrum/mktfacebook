<?php

class AdminLogController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

  

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    

   

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new AdminLog('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AdminLog']))
            $model->attributes = $_GET['AdminLog'];

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
        $model = AdminLog::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-log-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
