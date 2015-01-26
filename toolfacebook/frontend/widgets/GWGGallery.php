<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GWGGallery extends CWidget {

    public function run() {
        $result = array();
        if (!isset($category)) {
            $result['category'] = CategoryImage::model()->find('slide = 1');
            if (!empty($result['category'])) {
                $id = $result['category']['category_image_id'];
                $result['image'] = Images::model()->findAll('category_image_id = :p_id', array('p_id' => $id));
                if (!empty($result['image']))
                    $this->render('GWGGallery', array('result' => $result));        
            }
        }
      
            
    }

}
