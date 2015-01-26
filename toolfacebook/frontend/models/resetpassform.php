<?php
    class resetpassform extends CFormModel {

        public $password;
        public $repeat_password;

        public function rules() {
            return array(
                array('password, repeat_password', 'required'),
                array('password, repeat_password', 'length', 'min' => 6, 'max' => 64),
                array('password', 'compare', 'compareAttribute' => 'repeat_password','message'=>'Mật Khẩu Xác Nhận Không Chính Xác'),
            );
        }
        public function attributeLabels() {
            return array(
                'password' => Yii::t('labels', 'Mật Khẩu Mới'),
                'repeat_password' => Yii::t('labels', 'Xác Nhận Mật Khẩu'),
            );
        }

        public function RecoverPass($userId, $password,$verifyid) {
            $user = Users::model()->findByPk($userId,array('condition' => 'del_flg=' . GConst::DEL_FLG_NOT_DELETED));        
            if (!empty($user)) {
                $salt = $user->salt;
                $new_pass = md5($password);//md5(md5($password).$salt);
                $user->password = $new_pass;
                if ($user->save())
                {
                    $verifycode = new Verificationcode();
                    return $verifycode->updateAll(array('active'=>1,array('condition'=>'verifyid = :vid'),array(':vid'=>$verifyid)));
                }                    
            }
            else
                $this->addErrors(Yii::t('errors', t('COM_ERR_DELETE_ACCOUNT')));
            return false;
        }

        public function check_code($userid, $verifyid, $code) {
            $model = new Verificationcode();
            $model = $model->model()->find('verifyid = :p_vid and userid = :p_uid and verifycode = :p_code', array(
                'p_vid' => $verifyid,
                'p_uid' => $userid,
                'p_code' => $code,
            ));

            if (!empty($model)) {
                $expires = new DateTime($model->expires);
                $create = new DateTime(date('Y-m-d H:i:s'));
                if ($model->active == 0 && ($expires > $create )) {
                    return true;
                } else {
                    if ($model->active == 1) {
                        app()->user->setFlash('error', 'Mã Xác Thực Đã Hết Hiệu Lực Bạn Đã Kích Hoạt Một Lần <br/>Vui Lòng Thực Hiện Lại');
                    } else if ($expires <= $create) {
                        app()->user->setFlash('error', 'Mã Xác Thực Đã Quá Hạn Vui Lòng Thực Hiện Lại');
                    }
                    return false;
                }
            } else {
                app()->user->setFlash('error', 'Mã Xác Nhận Không Xác Định');
                return false;
            }
        }

    }
?>
