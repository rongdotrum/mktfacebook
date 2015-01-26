<?php
    class forgetpassform extends CFormModel {
        public $email;
        private $_user;

        public function rules() {
            return array(
                array('email', 'required'),
                array('email', 'email','message'=>'Email nhập vào không hợp lệ'),
                array('email', 'authenticate'),
            );
        }

        public function attributeLabels() {
            return array(
                'email' => Yii::t('labels', 'Email đăng ký'),
            );
        }

        public function authenticate($attribute, $params) {
            if (!$this->hasErrors()) {
                $attribute = strpos($this->email, '@') ? 'email' : 'loginname';
                $this->_user = Users::model()->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->email)));                    
                if ($this->_user === null) {                
                    $this->addError('email', Yii::t('errors', 'Email không tồn tại'));
                }
                 elseif ($this->_user->social_name !=null)
                    $this->addError('email', Yii::t('errors', 'Tài Khoản Mạng Xã Hội Không Thể Thai Đổi Mật Khẩu'));               
                elseif($this->_user->del_flg == 1)
                    $this->addError('email', Yii::t('errors', 'Tài Khoản Của Bạn Đã Bị Khóa'));
            }
        }
        public function craete_verifycode() {
            $code = new Verificationcode();
            $code->userid = $this->_user->user_id;
            $code->active = 0;
            $code->created = date('Y-m-d H:i:s');
            $date = new DateTime($code->created);
            $date->modify('+7 day');
            $expires = $date->format('Y-m-d H:i:s');
            $code->expires = $expires;
            $code->email = $this->_user->email;
            $code->verifycode = GHelpers::activateKey($this->email);
            if (!$code->save())
                return false;
            else {
                return app()->createAbsoluteUrl('user/forgetpass', array('uid' => $this->_user->user_id, 'vid' => $code->verifyid, 'code' => $code->verifycode));
            }
        }

        public function update_PasswordRecover($user) {
            $obj = PasswordRecovery::model()->findByAttributes(array('member_id' => $user->member_id), array('condition' => 'status=' . GConst::STATUS_UNACTIVE . ' and del_flg=' . GConst::DEL_FLG_NOT_DELETED));
            if ($obj === null)                  
                $obj = new PasswordRecovery;   
            $obj->member_id = $user->member_id;
            $obj->password = $user->password;  
            $obj->passworddate = date('Y-m-d H:i:s');
            $obj->recover_key = GHelpers::activateKey($user->email);
            $user->activate_key = $obj->recover_key; 
            $obj->status = GConst::STATUS_UNACTIVE;
            $obj->del_flg = GConst::DEL_FLG_NOT_DELETED;  
            return $obj->save();
        }
    }
?>
