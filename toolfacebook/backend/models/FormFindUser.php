<?php

class FormFindUser extends CFormModel {

    // maximum number of login attempts before display captcha

    public $username;
    public $servername;

    /**
     * Model rules
     * @return array
     */
    public function rules() {
        return array(
            array('username,servername', 'required'),
            array('servername', 'numerical', 'integerOnly' => true)
        );
    }

    /**
     * Returns attribute labels
     * @return array
     */
    public function attributeLabels() {
        return array(
            'username' => 'Tên Nhân Vật',
            'servername' => 'Tên Server'
        );
    }

}
