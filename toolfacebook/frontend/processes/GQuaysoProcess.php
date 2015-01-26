<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GQuaysoProcess.php
 *
 * @author toantn@vieauto.com
 */
class GQuaysoProcess extends GBaseBusinessProcess {

    protected function executeProcess() {

    }

    public function getTongGoldNap($userid, $server_id) {
        $Criteria = new CDbCriteria();
        $Criteria->select = 'sum(gold) as gold';
        $Criteria->condition = 'userid =:userid AND server_id=:server_id';
        $Criteria->params = array(':userid' => $userid, ':server_id' => $server_id);
        $Logpayment = new LogPayment();
        $Logpayment = $Logpayment->find($Criteria);
        return $Logpayment['gold'];
    }

    public function getItemLevel($percent, $idingame) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'idingame=:idingame AND percent=:percent';
        $Criteria->params = array(':idingame' => $idingame, ':percent' => $percent);
        $QuaysoItem = new QuaysoItem();
        $QuaysoItem = $QuaysoItem->find($Criteria);
        return $QuaysoItem;
    }

}

?>
