<?php

/**
 * CCU.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 8:37 PM
 */
class CCU extends CFormModel {

    public $date;
    public $server_id;

    /**
     * Model rules
     * @return array
     */
    public function rules() {
        return array(
            array('server_id', 'required'),
            array('date', 'date', 'format' => 'yyyy-M-d'),
            array('server_id', 'numerical', 'integerOnly' => true),
        );
    }

    public function attributeLabels() {
        return array(
            'date' => Yii::t('labels', 'Ngày'),
            'server_id' => Yii::t('labels', 'Server'),
        );
    }

    /**
     * Validates captcha code
     * @param $attribute
     * @param $params
     */
    public function resetForm() {
        $this->date = '';
        $this->server_id = '';
    }

}
