<?php

class FormFindPlayer extends CFormModel {

    // maximum number of login attempts before display captcha

    public $username;

    /**
     * Model rules
     * @return array
     */
    public function rules() {
        return array(
            array('username', 'required'),
                //array('username', 'length', 'max' => 50, 'min' => 6)
        );
    }

    /**
     * Returns attribute labels
     * @return array
     */
    public function attributeLabels() {
        return array(
            'username' => 'Tên tài khoản',
        );
    }

}
