<?php

/**
 * LoginForm.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 8:37 PM
 */
class StatisticPm_result extends CFormModel {

    public $tongsolan_thanhtoan;
    public $tongsolan_thanhcong;
    public $tongsolan_thatbai;
    public $tong_tien;
    public $tong_tien_arr;

    public function attributeLabels() {
        return array(
            'tongsolan_thanhtoan' => Yii::t('labels', 'Tổng số lần thanh toán'),
            'tongsolan_thanhcong' => Yii::t('labels', 'Tổng số lần thanh toán thành công'),
            'tongsolan_thatbai' => Yii::t('labels', 'Tổng số lần thanh toán thất bại'),
            'tong_tien' => Yii::t('labels', 'Tổng số tiền'),
        );
    }

}
