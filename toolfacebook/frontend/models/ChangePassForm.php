<?php

class ChangePassForm extends CFormModel {

    // maximum number of login attempts before display captcha



    public $current_pass;
    public $new_pass;
    public $re_pass;
    private $_identity;
    private $_user = null;

    /**
     * Model rules
     * @return array
     */
    public function rules() {
        return array(
            array('current_pass,new_pass,re_pass', 'required'),
            array('current_pass', 'authenticate'),
            array('new_pass', 'length', 'min' => 6, 'max' => 64),
            array('re_pass', 'compare', 'compareAttribute' => 'new_pass', 'message' => 'Mật Khẩu Xác Nhận Không Chính Xác'),
        );
    }

    public function attributeLabels() {
        return array(
            'new_pass' => Yii::t('labels', 'Mật Khẩu Mới'),
            'current_pass' => Yii::t('labels', 'Mật Khẩu Hiện Tại'),
            're_pass' => Yii::t('labels', 'Mật Khẩu Xác Nhận'),
        );
    }

    public function checkActivate($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if ($user !== null && $user->activate_status == GConst::STATUS_UNACTIVE) {
                $this->addError($attribute, Yii::t('errors', t('COM_ERR_NOTYET_ACTIVATE')));
            }
            if ($user !== null && $user->del_flg == GConst::DEL_FLG_DELETED)
                $this->addError($attribute, Yii::t('errors', t('COM_ERR_DELETE_ACCOUNT')));
        }
    }

    /**
     * Authenticates user input against DB
     * @param $attribute
     * @param $params
     */
    public function authenticate($attribute, $params) {

        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity(app()->user->getName(), $this->current_pass);
            if (!$this->_identity->authenticate()) {
                $this->addError($attribute, Yii::t('errors', 'Mật Khẩu Hiện Tại Không Chính Xác'));
                return false;
            }
            return true;
        }
    }

    /**
     * Login
     * @return bool
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity(app()->user->getName(), $this->current_pass);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
    }

    public function change() {
        $user = new Users();
        $user = $user->model()->findByPk(app()->user->getId());
        $user->password = md5($this->new_pass);//md5(md5($this->new_pass) . $user->salt);
        return $user->save();
    }


}
