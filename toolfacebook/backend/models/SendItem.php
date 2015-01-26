<?php
    class SendItem extends CFormModel {

        public $user_id;
        public $title;      
        public $message;
        public $itemid;
        public $serverid;

        public function rules() {
            return array(
            array('user_id,title,message,itemid,serverid', 'required'),
            array('itemid','filter','filter'=>'trim')
            );
        }
        public function attributeLabels()
        {
            return array(
                'serverid'=>'Server',
                'title' => 'Tiêu đề mail',
                'message' => 'Nội dung mail',
                'itemid' => 'itemid',
            );
        } 


    }
?>
