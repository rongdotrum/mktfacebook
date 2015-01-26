<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GWGPopup extends CWidget {

    public function run() {

        $popup = Popups::model()->find('status=1');
        if (!empty($popup))
            $this->render('GWGPopup', array('popup' => $popup));
    }

}
