<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GPhpMessageSource
 *
 * @author Huynh Nhien
 */
class GPhpMessageSource extends CPhpMessageSource{
    public function init() {
        //$this->basePath=Yii::getPathOfAlias('common.messages');
        parent::init();
    }
    public function getMessageFile($category, $language) {        
        parent::getMessageFile($category, $language);
    }
}

?>
