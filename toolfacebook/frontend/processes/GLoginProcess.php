<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GLoginProcess
 *
 * @author 060007HDN
 */
class GLoginProcess extends GBaseBusinessProcess {

    protected function executeProcess() {
        //$this->params=array('loginname'=>'abc','password'=>'abc');

        $user = new UserIdentity($this->params['username'], $this->params['pwd']);
        $user->authenticate();

        if ($user->errorCode === UserIdentity::ERROR_NONE) {
            $this->setReturnModel($user);
            return parent::BL_RET_SUCCESS;
        } else {
            $this->errorAdd(t('COM_ERR_LOGIN_NOT_MATCH'));
            return parent::BL_RET_ERROR;
        }
        //Thuc hien truy van db hoac goi model class de thuc hien tuong tac DB
        //return parent::BL_RET_SUCCESS;
    }

}

?>
