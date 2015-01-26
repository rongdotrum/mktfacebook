<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Rules {

    public function getRules($id) {


        if (!isset($id)) {

            return array(
                array('deny', // deny all users
                    'users' => array('*'),
                ),
            );
        } else
        if ($id == 1) {

            return array(
                array('allow',
                    'actions' => array('index,view,update,create,delete'),
                    'users' => array('@')),
            );
        } else {
            $control = new Controllers();
            $result = array();
            foreach ($control->model()->findAll() as $obj) {
                $user = AdminUser::model()->findByPk($id);
                $rule = array(array('deny', // deny all users
                        'users' => array('*'),
                    ),
                );
                $ctrId = $this->getControlId($obj->controller_name);
                $permissionId = $this->getPermissionId($user->id, $ctrId);
                $permissionName = $this->getNamePermission($permissionId);
                if (!empty($permissionName)) {
                    $rule = array(
                        array(
                            'allow',
                            'actions' => $permissionName,
                            'users' => array('@'),
                        ),
                        array('deny', // deny all users
                            'users' => array('*'),
                        ),);
                }

                $result[strtolower($obj->controller_name)] = $rule;
            }
            return $result;
        }
    }

    private function getControlId($name) {
        $control = Controllers::model()->find('controller_name = :p_name', array('p_name' => $name));
        if (isset($control->controller_id))
            return $control->controller_id;
        else
            return 0;
    }

    private function getPermissionId($userid, $ctrId) {
        $role = Roles::model()->find('user_id = :p_userid and controller_id = :p_ctrid ', array('p_userid' => $userid, 'p_ctrid' => $ctrId));
        if (isset($role))
            return $role->permission_id;
        else
            return 0;
    }

    private function getNamePermission($id) {
        $permiss = Permission::model()->findByPk($id);
        $result = array();
        if (isset($permiss->permission_name))
            $result = explode(',', $permiss->permission_name);
        return $result;
    }

    private function createArrayController() {
        $control = new Controllers();
        $result = array();
        foreach ($control->model()->findAll() as $obj) {
            $result[$obj->controller_name] = null;
        }
        return $result;
    }

}
