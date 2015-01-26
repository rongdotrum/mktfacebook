<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AlbumController extends Controller {

    public function accessRules() {

        return array(
        );
    }

    public function actionIndex() {
        $category = new CategoryImage();
        $data_category = $category->model()->findAll();
        $img_data = Images::model()->findAll();
        $this->render('index', array('model' => $data_category, 'image' => $img_data));
    }

    public function actionGetGallery($id) {
        $result = array();
        if (isset($id)) {
            $result = Images::model()->findAll('category_image_id = :p_id', array('p_id' => $id));
        }
        app()->clientScript->scriptMap['jquery.min.js'] = false;
        app()->clientScript->registerScriptFile(app()->request->baseUrl . '/js/html5gallery/html5gallery.js');
        $this->renderPartial('gallery', array('result' => $result), false, true);
    }

    public function actionCategory($id) {
        $image = new Images();
        $cat_name = CategoryImage::model()->findByPk($id);
        $data_image = $image->model()->findAll('category_image_id = :p_id', array('p_id' => $id));
        $this->render('image', array('model' => $data_image, 'cat_name' => $cat_name->category_name));
    }

}
