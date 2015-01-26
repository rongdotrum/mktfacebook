<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Newsdetail
 *
 * @author toantn
 */
class Newsdetail extends GBaseAction {

    public function run() {
        $controller = $this->getController();
        $Id = app()->request->getParam('id');
        $process = new GNewsProcess();
        $News = $process->GetNewsDetail($Id);
        $Cat = $process->GetCat($News['CatId']);
        $controller->render('application.views.news.detail', array('Cat' => $Cat, 'News' => $News));
    }

}

?>
