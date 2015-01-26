<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GTextAutoComplete
 *
 * @author Admin
 */
class GTextAutoComplete extends CWidget
{

    public $model;
    public $attribute;
    public $source = array('url' => '#', 'params' => array());
    public $options = array();
    public $htmlOptions = array();
    private $sourceUrl;

    public function init()
    {
        parent::init();
        $this->sourceUrl = isset($this->source['params']) ? Yii::app()->createAbsoluteUrl($this->source['url'] . '.aclist', $this->source['params']) : Yii::app()->createAbsoluteUrl($this->source['url'] . '.aclist');
    }
    public function run()
    {
        $this->render('GTextAutoComplete', array(
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => $this->options,
            'htmlOptions' => $this->htmlOptions,
            'sourceUrl' => $this->sourceUrl));
    }
    public static function actions()
    {
        return array(
            'aclist' => array(
                'class' => 'common.widgets.gautocomplete.actions.TextAutoCompleteAction',
                'model' => 'MasterCode',
                'attribute' => 'display_value',
            ),
        );
    }
}
?>
