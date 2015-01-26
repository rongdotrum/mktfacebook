<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author toantn
 */
class Index extends GBaseAction {

    public function run() {
        $controller = $this->getController();
        $controller->render('index');
    }

}

?>
