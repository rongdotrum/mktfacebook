<?php
class PlusGold extends CFormModel {

    public $display_name;
    public $email;
    public $server_id;
    public $gold;

    /**
    * Model rules
    * @return array
    */
    public function rules() {
        return array(
            array('server_id,gold', 'required'),
            array('server_id,gold','numerical', 'integerOnly' => true),
        );
    }

    public function attributeLabels()
    {
        return array(
            'server_id' => Yii::t('labels', 'Máy chủ'),
        );
    }
}
?>