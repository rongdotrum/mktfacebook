<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GNewsProcess
 *
 * @author toantn@vieauto.com
 */
class GNewsProcess extends GBaseBusinessProcess {

    protected function executeProcess() {

    }

    public function getPowerFight($limit, $serverid) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'server_id =:server_id';
        $Criteria->order = 'power DESC';
        //$Criteria->condition = 'CatId = 1';
        if ($limit != null) {
            $Criteria->limit = $limit;
        }
        $Criteria->params = array(':server_id' => $serverid);
        $PowerFight = new PowerFight();
        $PowerFight = $PowerFight->findAll($Criteria);
        $dataProvider = new CArrayDataProvider($PowerFight, array(
            'keyField' => 'powerId',
            'id' => 'powers',
            'pagination' => array(
                'pageSize' => 10,
        )));
        return $dataProvider;
        //return $PowerFight;
    }

    public function getHotLink($limit) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'Status = 1 AND HotLink = 1';
        $Criteria->order = 'DatePost DESC';
        //$Criteria->condition = 'CatId = 1';
        if ($limit != null) {
            $Criteria->limit = $limit;
        }
        //$Criteria->params = array(':valuesukien' => $valuesukien, ':valuetintuc' => $valuetintuc);
        $News = new ExtNews();
        $News = $News->findAll($Criteria);
        return $News;
    }

    public function getSlide($limit) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'Status = 1';
        $Criteria->order = 'DateCreate DESC';
        //$Criteria->condition = 'CatId = 1';
        if ($limit != null) {
            $Criteria->limit = $limit;
        }
        //$Criteria->params = array(':valuesukien' => $valuesukien, ':valuetintuc' => $valuetintuc);
        $Slides = new Slides();
        $Slides = $Slides->findAll($Criteria);
        return $Slides;
    }

    public function getModule($Position) {
        $NewsCat = new ExtNewsCat();
        $Cat = $NewsCat->findAll('Position = :Position AND Status = 1', array(':Position' => $Position));
        return $Cat;
    }

    public function getCatObject($CatAction) {
        $NewsCat = new NewsCat();
        $Cat = $NewsCat->find('CatAction = :CatAction', array(':CatAction' => $CatAction));
        return $Cat;
    }

    public function GetCatName($NewsId) {
        $News = $this->GetNewsDetail($NewsId);
        $Cat = $this->GetCat($News['CatId']);
        return $Cat['CatName'];
    }

    public function GetNewsDetail($NewsId) {
        $News = new News();
        $result = $News->find('NewsId = :NewsId', array(':NewsId' => $NewsId));
        return $result;
    }

    public function GetCat($CatId) {
        $NewsCat = new NewsCat();
        $Cat = $NewsCat->find('CatId = :CatId', array(':CatId' => $CatId));
        return $Cat;
    }

    public function GetTongHopNews($limit) {
        //$valuesukien = GConst::Cat_SuKien;
        //$valuetintuc = GConst::Cat_TinTuc;
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'Status = 1';
        $Criteria->order = 'DatePost DESC';
        //$Criteria->condition = 'CatId = 1';
        if ($limit != null) {
            $Criteria->limit = $limit;
        }
        //$Criteria->params = array(':valuesukien' => $valuesukien, ':valuetintuc' => $valuetintuc);
        $News = new News();
        $News = $News->findAll($Criteria);
        return $News;
    }

    public function GetListNews($CatId, $limit) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'CatId = :CatId  AND Status = 1';
        $Criteria->order = 'DatePost DESC';
        //$Criteria->condition = 'CatId = 1';
        if ($limit != null) {
            $Criteria->limit = $limit;
        }
        $Criteria->params = array(':CatId' => $CatId);
        $News = new News();
        $News = $News->findAll($Criteria);
        return $News;
    }

    public function getListNewsTonghop() {
        //$valuesukien = GConst::Cat_SuKien;
        //$valuetintuc = GConst::Cat_TinTuc;
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'Status = 1';
        $Criteria->order = 'DatePost DESC';
        //$Criteria->condition = 'CatId = 1';
        //$Criteria->params = array(':valuesukien' => $valuesukien, ':valuetintuc' => $valuetintuc);
        $dataProvider = new CArrayDataProvider(News::model()->findAll($Criteria), array(
            'keyField' => 'NewsId',
            'id' => 'news',
            'pagination' => array(
                'pageSize' => 10,
        )));
        return $dataProvider;
    }

    public function getListNewsCat($CatId) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'CatId = :CatId  AND Status = 1';
        $Criteria->order = 'DatePost DESC';
        $Criteria->params = array(':CatId' => $CatId);
        $dataProvider = new CArrayDataProvider(News::model()->findAll($Criteria), array(
            'keyField' => 'NewsId',
            'id' => 'news',
            'pagination' => array(
                'pageSize' => 10,
        )));
        return $dataProvider;
    }

}

?>
