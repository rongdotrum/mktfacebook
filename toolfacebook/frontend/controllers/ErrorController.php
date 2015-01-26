<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorController
 *
 * @author Admin
 */
class ErrorController extends Controller {

    public function actionError() {
        $this->layout = '//layouts/home';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('//site/error', $error);
        }
    }

}

?>
