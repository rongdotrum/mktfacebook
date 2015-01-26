<?php
  class changeemailform extends CFormModel {
      public $email;
      public $password;
      
      
        public function rules() {
            return array(
                array('email', 'required'),
                array('email', 'checkemail'),
                array('password','checkpass'),
            );
        }
      
      
        public function attributeLabels() {
            return array(
                'email' => 'Email',  
                'password'=>'Mật Khẩu'              
            );
        }
      
      public function checkemail($attribute,$params) {
          $check = Users::model()->find('user_id != :puid and email = :pemail',array('puid'=>Yii::app()->user->getId(),'pemail'=>$this->email));
          if (Yii::app()->user->social_name() != null )
                $this->addError('email','Tài Khoản Mạng Xã Hội Không Thể Thay Đổi Email');                
          if (isset($check))
               $this->addError('email','Email Đã Tồn Tại');                
      }
      public function checkpass($attribute,$params)
      {
          $check = Users::model()->findByPk(Yii::app()->user->getId());
          if (isset($check))
          {
              if ($check->password != md5($this->password))
                    $this->addError('password','Mật Khẩu Không Chính Xác');                
          }
      }
      public function setmail() {
          $user = Users::model()->findByPk(Yii::app()->user->getId());
          if (isset($user))
          {
            $user->email = $this->email;
            return $user->save();
          }
          return false;
          
          
      }
  }
?>
