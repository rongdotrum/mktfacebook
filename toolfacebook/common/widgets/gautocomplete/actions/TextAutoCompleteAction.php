<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TextAutoCompleteAction
 *
 * @author Admin
 */
class TextAutoCompleteAction extends CAction
{

    public $model;
    public $attribute;
    public $condition;
    private $results = array();

    public function run()
    {
        if (isset($this->model) && isset($this->attribute)) {
            $criteria = new CDbCriteria();
            $criteria->select = array($this->attribute);
            $criteria->distinct = true;
            if (isset($this->condition))
                $criteria->condition = $this->condition;
            $criteria->compare($this->attribute, $_GET['term'], true);
            $model = new $this->model;
            foreach ($model->findAll($criteria) as $m) {
                $this->results[] = $m->{$this->attribute};
            }
        }
        echo CJSON::encode($this->results);
    }
}
?>
