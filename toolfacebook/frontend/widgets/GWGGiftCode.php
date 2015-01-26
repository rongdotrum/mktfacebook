<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GWGGiftCode extends CWidget {
    
    public $tanthu = 0;

    public function run() {
        $server = new Servers();
        $model = $server->model()->findAll('status = 1');
        $status = false;
        if (!app()->user->isGuest) {
            $status = true;
            $this->render('GWGGiftCode', array('model' => $model, 'status' => $status));
        }
    }

}
