<?php

/**
 * This is the model class for table "{{tbl_user}}".
 *
 * The followings are the available columns in table '{{tbl_user}}':
 * @property string $Id
 * @property string $LoginName
 * @property string $Email
 * @property string $Pwd
 * @property string $DisplayName
 * @property string $UserType
 * @property string $OnlineStatus
 */
class ExtUsers extends Users {

    public $avatar_path;

    /**
     * @var string attribute used for new passwords on user's edition
     */
    public $newPassword;

    /**
     * @var string attribute used to confirmation fields
     */
    public $passwordConfirm;
    public $salt;
    public $validation_key;
    public $request_status;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeNames() {
        return parent::attributeNames();
    }

    /**
     * Behaviors
     * @return array
     */
    public function behaviors() {
        Yii::import('common.extensions.behaviors.password.*');
        return array(
            // Password behavior strategy
            "APasswordBehavior" => array(
                "class" => "APasswordBehavior",
                "passwordAttribute" => "password",
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

    /**
     * Helper property function
     * @return string the full name of the customer
     */
    public function getFullName() {
        return $this->display_name;
    }

    /**
     * Generates a new validation key (additional security for cookie)
     */
    public function regenerateValidationKey() {
//		$this->saveAttributes(array(
//			'validation_key' => md5(mt_rand() . mt_rand() . mt_rand()),
//		));
        $this->validation_key = md5(mt_rand() . mt_rand() . mt_rand());
    }

}
