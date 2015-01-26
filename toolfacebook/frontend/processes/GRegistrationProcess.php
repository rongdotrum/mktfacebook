<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GRegistrationProcess extends GBaseBusinessProcess {

    protected function executeProcess() {
        $user = new Users;
        if ($this->form->signup($user)) {
            $this->setReturnModel($user);
            return parent::BL_RET_SUCCESS;
        } else {

            $this->errorAdd(t('COM_REGISTER_ERROR'));
            return parent::BL_RET_ERROR;
        }
    }

}

