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
class GRequestCardProcess extends GBaseBusinessProcess {

    protected function executeProcess() {

    }

    public function saveQuayso($server_id, $user_id, $turn) {
        if ($this->checkExistQuayso($server_id, $user_id))
            $this->updateQuayso($server_id, $user_id, $turn);
        else
            $this->insertQuayso($server_id, $user_id, $turn);
    }

    public function checkExistQuayso($server_id, $user_id) {
        $quayso = new UsersQuayso();
        $record = $quayso->find('userid=:userid AND server_id=:server_id', array(':userid' => $user_id, ':server_id' => $server_id));
        if ($record == null)
            return false;
        else
            return true;
    }

    public function updateQuayso($server_id, $user_id, $turn) {
        $quayso = UsersQuayso::model()->find('userid=:userid AND server_id=:server_id', array(':userid' => $user_id, ':server_id' => $server_id));
        $quayso->userid = $user_id;
        $quayso->server_id = $server_id;
        $quayso->turn += $turn;
        $quayso->save();
    }

    public function insertQuayso($server_id, $user_id, $turn) {
        $quayso = new UsersQuayso();
        $quayso->userid = $user_id;
        $quayso->server_id = $server_id;
        $quayso->turn = $turn;
        $quayso->save();
    }

    public function saveMoney($Money, $UserId) {
        if ($this->checkExistMoney($UserId))
            return $this->updateMoney($UserId, $Money);
        else
            return $this->insertMoney($UserId, $Money);
    }

    public function updateMoney($UserId, $Money) {
        $UsersMoney = new UsersMoney();
        $UsersMoney = $UsersMoney->find('user_id=:user_id', array(':user_id' => $UserId));
        $UsersMoney->current_money = $UsersMoney->current_money + $Money;
        $UsersMoney->sum_money = $UsersMoney->sum_money + $Money;
        return $UsersMoney->save();
    }

    public function insertMoney($UserId, $Money) {
        $UsersMoney = new UsersMoney();
        $UsersMoney->user_id = $UserId;
        $UsersMoney->current_money = $Money;
        $UsersMoney->sum_money = $Money;
        $UsersMoney->trans_money = 0;
        return $UsersMoney->save();
    }

    public function checkExistMoney($UserId) {
        $UsersMoney = new UsersMoney();
        $record = $UsersMoney->find('user_id=:user_id', array(':user_id' => $UserId));
        if ($record == null)
            return false;
        else
            return true;
    }

}

?>
