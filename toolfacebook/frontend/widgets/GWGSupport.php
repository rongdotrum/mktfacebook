<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GWGSupport extends CWidget {

    public function run() {
        
        if (isset(Yii::app()->params['sysconfig']['email_support']))
            $email = Yii::app()->params['sysconfig']['email_support'];
        if (isset($email))
            $this->render('GWGSupport', array('email' => $email));
    }

}
