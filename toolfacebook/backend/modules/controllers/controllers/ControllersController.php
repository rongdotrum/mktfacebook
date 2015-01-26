<?php

class ControllersController extends Controller {

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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Controllers;
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        if (isset($_POST['Controllers'])) {
            if (!empty($_POST['Controllers']['url']))
                $_POST['Controllers']['controller_name'] = app()->getModule($_POST['Controllers']['url'])->defaultController;
            $model->attributes = $_POST['Controllers'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->controller_id));
        }
        $modules = $this->getModules(1);

        $this->render('create', array(
            'model' => $model, 'modules' => $modules
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        if (isset($_POST['Controllers'])) {
            if (!empty($_POST['Controllers']['url']))
                $_POST['Controllers']['controller_name'] = app()->getModule($_POST['Controllers']['url'])->defaultController;
            $model->attributes = $_POST['Controllers'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->controller_id));
        }
        $modules = $this->getModules();
        $this->render('update', array(
            'model' => $model, 'modules' => $modules
        ));
    }

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
        $model = new Controllers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Controllers']))
            $model->attributes = $_GET['Controllers'];
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin12312() {
        $model = new Controllers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Controllers']))
            $model->attributes = $_GET['Controllers'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Controllers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'controllers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function getParent($parent) {
        $control = Controllers::model()->findByPk($parent);
        return $control;
    }

    protected function getModules($case = 0) {
        $extend = array('rights', 'controllers', 'systemusers', 'gii');
        $modules = app()->modules;
        $result = array();
        if (empty($case)) {
            foreach ($modules as $key => $value) {
                if ($key != 'rights' && !array_search($key, $extend))
                    $result[]['url'] = $key;
            }
        } else {
            $crit = new CDbCriteria();
            $crit->select = 'url,controller_name';
            $data_control = Controllers::model()->findAll($crit);
            foreach ($modules as $key => $value) {
                $flg = true;

                if ($key != 'rights' && !array_search($key, $extend)) {
                    //if ($key != 'gii' && $key != 'rights') {
                    foreach ($data_control as $obj) {
                        $filter = preg_replace('/\//', '', $obj->url);
                        if ($filter == $key || $key == 'controllers')
                            $flg = false;
                    }
                    if ($flg)
                        $result[]['url'] = $key;
                }
            }
        }
        return $result;
    }

}
