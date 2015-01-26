<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GWGFaceBook extends CWidget {

    public function run() {

        $facebook = app()->params['facebook'];
        if (isset($facebook) && $facebook != '') {
            $this->render('GWGFaceBook', array('facebook' => $facebook));
        }
    }

}
