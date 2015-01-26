<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminUserExt
 *
 * @author Admin
 */
class AdminUserExt extends AdminUser {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeNames() {
        return parent::attributeNames();
    }

    public function behaviors() {
        Yii::import('common.extensions.behaviors.password.*');
        return array(
            // Password behavior strategy
            "APasswordBehavior" => array(
                "class" => "APasswordBehavior",
                "passwordAttribute" => "login_password",
                "saltAttribute" => '',
                "defaultStrategyName" => "legacy",
                "strategies" => array(
                    "bcrypt" => array(
                        "class" => "ABcryptPasswordStrategy",
                        "workFactor" => 14,
                        "minLength" => 8
                    ),
                    "legacy" => array(
                        "class" => "ALegacyMd5PasswordStrategy",
                        'minLength' => 4
                    )
                ),
            )
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_date = new CDbExpression('NOW()');
            $this->created_by = app()->user->getName();
        }
        else {
            $this->updated_date = new CDbExpression('NOW()');
            $this->updated_by = app()->user->getName();
        }
        return parent::beforeSave();
    }
}

?>
