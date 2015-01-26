<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GWGPermission extends CWidget {

    public $user_id;

    function run() {
        $control = new Controllers();
        $permission = new Permission();
        $crit = new CDbCriteria();
        $crit->addNotInCondition('url', array('#', ''));
        $crit->addCondition('url is not null');
        $crit->addNotInCondition('controller_name', array('controllers'));
        $getControl = $control->model()->findAll($crit);
        foreach ($getControl as $obj) {
            echo '<div>';
            $roles = new Roles();
            app()->clientScript->registerCss('showpermission', '.row > div { display:inline-block; margin: 5px;} ');
            $roles = $roles->model()->find('user_id = :p_uid and controller_id = :p_pid', array('p_uid' => $this->user_id, 'p_pid' => $obj->controller_id));
            if (isset($roles->permission_id))
                echo '<input checked=yes type=checkbox name="controllers[controller_id][]" value="' . $obj->controller_id . '" /> <span class="label label-success">' . $obj->description . '</span>';
            else
                echo '<input type=checkbox name="controllers[controller_id][]" value="' . $obj->controller_id . '" /> <span class="label label-success">' . $obj->description . '</span>';
            echo '<div style="margin-left:20px;margin-bottom:10px">';
            foreach ($permission->model()->findAll() as $per) {
                echo '<div>';
                if (isset($roles->permission_id) && $roles->permission_id == $per->permission_id)
                    echo '<input checked=yes type="radio" name="permission[' . $obj->controller_id . ']" id="permission_' . $obj->controller_id . '" value="' . $per->permission_id . '" /><label>' . $per->description . '</label>';
                elseif (!isset($roles->permission_id) && $per->permission_id == 4) {
                    echo '<input checked=yes type="radio" name="permission[' . $obj->controller_id . ']" id="permission_' . $obj->controller_id . '" value="' . $per->permission_id . '" /><label>' . $per->description . '</label>';
                } else
                    echo '<input type="radio" name="permission[' . $obj->controller_id . ']" id="permission_' . $obj->controller_id . '" value="' . $per->permission_id . '" /><label>' . $per->description . '</label>';

                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        }
        $this->render('GWGPermission');
    }

}
