<?php

/**
 * Controller.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:55 AM
 */
class Controller extends RController {

    public $breadcrumbs = array();
    public $menu = array();
    public $_assets;

    public function init() {

        if ($this->_assets === null)
            $this->_assets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('www') . '/css');
        Yii::app()->clientScript->registerCssFile($this->_assets . '/customer.css');
    }

    public function filters() {

        return array(
            'rights',
                // 'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /*   public function accessRules() {

      $control = app()->user->getState('rules');
      $crtrname = strtolower(app()->controller->getId());
      if (!empty($control[$crtrname])) {
      return $control[$crtrname];
      } else {
      if (isset($control))
      return $control;
      else {
      return array(
      array('deny', 'users' => array('*'))
      );
      }
      }
      } */
}
