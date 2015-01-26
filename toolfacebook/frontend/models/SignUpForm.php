<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SignUpForm
 *
 * @author Luan.diep
 */
class SignUpForm extends CFormModel {

    public $loginname;
    public $email;
    public $password;
    public $re_password;
    public $verifyCode;
    public $usersource;
    public $pid;
    private $_identity;    

    public function rules() {
        return array(
            // username and password are required
            array('loginname, email, password', 'required'),
           //array('verifyCode', 'validateCaptcha'),
            array('re_password', 'required', 'message' => 'Mật Khẩu Xác Nhận Không Được Phép Rỗng'),
            // email has to be a valid email address
            array('email', 'email'),
            array('loginname', 'match', 'not' => true, 'pattern' => '/[^a-zA-Z_0-9]/', 'message' => t('COM_ERR_INVALID_CHAR', array('{item}' => '{attribute}'))),
            array('email, loginname', 'authenticate'),
            array('password', 'length', 'min' => 6, 'max' => 64),
            array('re_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Mật Khẩu Xác Nhận Không Chính Xác'),
            array('loginname','checkLoginName')
        );
    }      
  
    public function beforeValidate() {
        return parent::beforeValidate();
    }

    public function attributeLabels() {
        return array(
            'loginname' => Yii::t('labels', 'Tên đăng nhập'),
            'password' => Yii::t('labels', 'Mật khẩu'),
            'verifyCode' => Yii::t('labels', 'Mã Xác Nhận'),
        );
    }

    public function authenticate($attribute, $params) {

        if (!$this->hasErrors()) {
            $condition = $attribute == 'email' ? 'email=:email' : 'display_name=:loginname';
            $param = $attribute == 'email' ? array(':email' => $this->email) : array(':loginname' => $this->loginname);
            $this->_identity = Users::model()->find(array('condition' => $condition, 'params' => $param));
            if ($this->_identity != null) {
                $this->addError($attribute, Yii::t('errors', t('COM_ERR_' . strtoupper($attribute) . '_EXISTED')));
            }
        }              
   
    }

    public function signup(&$user) {
        if ($this->_identity === NULL) {
            //cho phep dang ky
            return $this->regUser($user);
        } else {
           
            Yii::app()->user->setFlash('error', 'Có lỗi vui lòng thử lại.');
        }
        return false;
    }

    public function validateCaptcha($attribute, $params) {
        CValidator::createValidator('captcha', $this, $attribute, $params)->validate($this);
    }

    public function regUser(&$user) {
        $salt = GHelpers::fetch_random_string();
        $this->password = md5($this->password);//md5(md5($this->password) . $salt);
        $o_user = new Users();
        $o_user->display_name = $this->loginname;
        $o_user->email = $this->email;
        $o_user->salt = $salt;
        $o_user->password = $this->password;
        $o_user->del_flg = GConst::DEL_FLG_NOT_DELETED;
        $o_user->activate_status = 1;
        $o_user->activate_key = GHelpers::activateKey($this->email);
        $o_user->enc_type = GConst::ENCRYPT_MD5;
        $o_user->usersource = $this->usersource; 
        $o_user->partner_id = $this->pid;           
        $check = $o_user->save();
        if ($check) {
            $user = $o_user;
        }
        
        return $check;
    }
    
    public function checkLoginName($attribute,$params)
    {                           
        $check_character = preg_match('/[a-z]|[A-Z]/',$this->loginname);        
        if (!$check_character)
            $this->addError($attribute, 'Tên Đăng Nhập Phải Bao Gồm Chứ Cái');      
    }
    
}

?>
