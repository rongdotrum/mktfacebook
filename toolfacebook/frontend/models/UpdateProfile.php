<?php
  class UpdateProfile extends Users {
      public $phone;
      public $re_phone;
      public $cmnd; 
      public $re_cmnd;
      
      
       /**
     * Model rules
     * @return array
     */
    public function rules() {
        return array(
            array('phone, cmnd', 'required'),
            array('cmnd','length','min'=>9),
            array('cmnd','unique'),           
            array('re_cmnd,re_phone','safe')            
        //    array('re_phone,re_cmnd','checkuser'),            
        );
    }
    
    public function checkuser($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = Users::model()->findByPk(Yii::app()->user->getId());  
            if ($user !== null && $user->phone != null && $user->phone != $this->re_phone) {
                $this->addError($attribute, Yii::t('errors', 'Số điện thoại đã lưu không đúng'));
            }
            if ($user !== null && $user->cmnd != null && $user->cmnd != $this->re_cmnd) {
                $this->addError($attribute, Yii::t('errors', 'Chứng minh nhân dân đã lưu không đúng'));
            }
        }
    }
      
      public function attributeLabels() {
        return array(
            'phone' => Yii::t('labels', 'Số điện thoại'),
            'cmnd' => Yii::t('labels', 'Chứng minh nhân dân'),     
            're_phone' => Yii::t('labels', 'Số điện thoại cũ'),
            're_cmnd' => Yii::t('labels', 'Chứng minh nhân dân cũ'),               
        );
    }
      
      public function saveprofile() {
            $user = Users::model()->findByPk(Yii::app()->user->getId());
            if ($user != null) {
                $user->phone = $this->phone;
                $user->cmnd = $this->cmnd;
                  return $user->save();                   
            }
            return false;
      }
  }
?>
