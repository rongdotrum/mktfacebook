<?php

/**
 * LoginForm.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 8:37 PM
 */
class RequestCard extends CFormModel {

    // maximum number of login attempts before display captcha


    public $Serial;
    public $Pin;
    public $CardId;
    public $verifyCode;
    public $ServerId;

    /**
     * Model rules
     * @return array
     */
    public function rules() {
        return array(
            array('Serial,Pin,CardId,ServerId', 'required'),
            array('Serial', 'length', 'max' => 15, 'min' => 9),
            array('Pin', 'length', 'max' => 15, 'min' => 10),
            array('CardId','in','range'=>array_keys(GConst::$CardId),'message'=>'Loại thẻ nạp không phù hợp'),
           array('verifyCode', 'validateCaptcha'),
            array('ServerId','numerical', 'integerOnly' => true),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'CardId'=>'Loại Thẻ',
            'ServerId' => Yii::t('labels', 'Máy chủ'),
            'Pin' => Yii::t('labels', 'Mã thẻ'),         
        );
    }
    
    /**
     * Validates captcha code
     * @param $attribute
     * @param $params
     */
    public function validateCaptcha($attribute, $params) {

        CValidator::createValidator('captcha', $this, $attribute, $params)->validate($this);
    }

    public function resetForm() {
        $this->CardId = '';
        $this->Pin = '';
        $this->Serial = '';
        $this->verifyCode = '';
    }

}
