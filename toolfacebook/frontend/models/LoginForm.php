<?php

/**
 * LoginForm.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 8:37 PM
 */
class LoginForm extends CFormModel {

    // maximum number of login attempts before display captcha

    const MAX_LOGIN_ATTEMPTS = 3;

    public $username;
    public $pwd;
    public $rememberMe;
    public $verifyCode;
    private $_identity;
    private $_user = null;
    private $login_attempts = 0;

    /**
     * Model rules
     * @return array
     */
    public function rules() {
        return array(
            array('pwd, username', 'required'),
            array('verifyCode', 'validateCaptcha'),
            array('username', 'checkActivate'),
            array('pwd', 'authenticate'),
            array('rememberMe', 'boolean'),
        );
    }

    public function checkActivate($attribute, $params) {
        if (!$this->hasErrors() || $this->login_attempts < 6) {
            $user = $this->getUser();

//            if ($user !== null && $user->activate_status == GConst::STATUS_UNACTIVE) {
//                $this->addError($attribute, Yii::t('errors', t('COM_ERR_NOTYET_ACTIVATE')));
//            }
            if ($user !== null && $user->del_flg == GConst::DEL_FLG_DELETED)
                $this->addError($attribute, Yii::t('errors', t('COM_ERR_DELETE_ACCOUNT')));
        }
    }

    /**
     * Returns attribute labels
     * @return array
     */
    public function attributeLabels() {
        return array(
            'username' => Yii::t('labels', 'Tài khoản/Email'),
            'pwd' => Yii::t('labels', 'Mật khẩu'),
            'rememberMe' => Yii::t('labels', 'Duy trì đăng nhập'),
        );
    }

    /**
     * Authenticates user input against DB
     * @param $attribute
     * @param $params
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            if ($this->login_attempts < 6) {
                $this->_identity = new UserIdentity($this->username, $this->pwd);
                if (!$this->_identity->authenticate()) {
                    $this->login_attempts = Yii::app()->user->getState("login_attempt", 0);
                    if ($this->login_attempts < 100)
                        Yii::app()->user->setState("login_attempt", $this->login_attempts + 1);
                    $this->addError($attribute, Yii::t('errors', t('COM_ERR_LOGIN_NOT_MATCH')));
                }

            }
            /** khoa acc dang nhap qua 5 lan **/
           // else {
//                $attribute = strpos($this->username, '@') ? 'email' : 'display_name';
//                $user = new Users();
//                $user = $user->model()->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username)));
//                if (!empty($user)) {
//                    $user->del_flg = 1;
//                    $user->save();
//                }
//                $this->addError($attribute, 'Bạn Đăng Nhập Vượt Quá Số Lần Cho Phép');
//            }
        }
    }

    /**
     * Validates captcha code
     * @param $attribute
     * @param $params
     */
    public function validateCaptcha($attribute, $params) {
        if ($this->getRequireCaptcha()) {

            CValidator::createValidator('captcha', $this, $attribute, $params)->validate($this);
        }
    }

    /**
     * Login
     * @return bool
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->pwd);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
    }

    /**
     * Returns
     * @return null
     */
    public function getUser() {
        if ($this->_user === null) {
            $attribute = strpos($this->username, '@') ? 'email' : 'display_name';
            $this->_user = Users::model()->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username)));
        }
        return $this->_user;
    }
    


    /**
     * Returns whether it requires captcha or not
     * @return bool
     */
    public function getRequireCaptcha() {
        return ($this->login_attempts = Yii::app()->user->getState("login_attempt", 0)) !== null && $this->login_attempts >= self::MAX_LOGIN_ATTEMPTS;
    }
    
  

}
