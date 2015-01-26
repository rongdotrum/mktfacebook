<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GWGNavbar extends CWidget {

    public function run() {

        $control = new Controllers();
        $home = array(array('label' => 'Home', 'url' => array('/site/index')));

        $system = array(array(
                'label' => 'Quản Trị Hệ Thống',
                'url' => '#',
                'visible' => !app()->user->isGuest,
                'items' => array(
                    array(
                        'label' => 'Tài Khoản Hệ Thống',
                        'url' => app()->createUrl('systemusers'),
                    ),
                    array(
                        'label' => 'Phân Quyền',
                        'url' => app()->createUrl('rights')
                    ),
                    array(
                        'label' => 'Tạo Menu',
                        'url' => app()->createUrl('controllers')
                    )
                ),
        ));
        $navctr = array();
        foreach ($control->model()->findAll() as $obj) {
            if (empty($obj->parent)) {
                $visible = true;
                if (($obj->special == 1 && app()->user->getId() != 1) || app()->user->isGuest) {
                    $visible = false;
                }
                if ($obj->url != '#') {
                    $navctr[] = array(
                        'label' => $obj->description,
                        'url' => app()->createUrl($obj->url),
                        'visible' => $visible
                    );
                } else {
                    $navctr[] = array(
                        'label' => $obj->description,
                        'url' => $obj->url,
                        'items' => $this->subNav($obj->controller_id),
                        'visible' => $visible
                    );
                }
            }
        }
        $navctr = CMap::mergeArray($home, $system, $navctr);

        $this->render('GWGNavbar', array('itmes' => $navctr));
    }

    protected function subNav($id) {
        $ctr = new Controllers();
        $ctr->parent = $id;
        $subnav = array();
        foreach ($ctr->model()->findAll('parent = :p_id', array('p_id' => $id)) as $obj) {
            $visible = true;
            if (($obj->special == 1 && app()->user->getId() != 1) || app()->user->isGuest) {
                $visible = false;
            }
            $subnav[] = array(
                'label' => $obj->description,
                'url' => app()->createUrl($obj->url),
                'visible' => $visible
                    )
            ;
        }
        return $subnav;
    }

}
