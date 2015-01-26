<?php

/**
 * LoginForm.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 8:37 PM
 */
class StatisticPm extends CFormModel {

    public $server_id;
    public $startdate;
    public $enddate;

    /**
     * Model rules
     * @return array
     */
    public function rules() {
        return array(
            array('startdate,enddate', 'date', 'format' => 'yyyy-M-d'),
            array('server_id', 'numerical', 'integerOnly' => true),
        );
    }

    public function attributeLabels() {
        return array(
            'server_id' => Yii::t('labels', 'Máy chủ'),
            'startdate' => Yii::t('labels', 'Từ ngày'),
            'enddate' => Yii::t('labels', 'Đến ngày'),
        );
    }

    /**
     * Validates captcha code
     * @param $attribute
     * @param $params
     */
    public function resetForm() {
        $this->server_id = '';
        $this->startdate = '';
        $this->enddate = '';
    }

}
