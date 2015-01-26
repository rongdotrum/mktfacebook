<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GWGNewServer extends CWidget {

    public function run() {
        $server = new Servers();
        $crit = new CDbCriteria();
        // $crit->select = 'server_id,server_name,created_date';
        //$crit->limit = 2;
        $crit->condition = 'status = 1 and published_date <= now()';
        $crit->order = 'published_date desc';
        $crit->limit = 4;
        $model = $server->model()->findAll($crit);
        if ($model != null)
            $this->render('GWGNewServer', array('model' => $model));
    }

}
