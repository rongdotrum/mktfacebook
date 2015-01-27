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

    public function SubLimitItem($itemid) {
        $item = QuaysoItem::model()->find('itemid=:itemid', array(':itemid' => $itemid));
        $item->limititem = (int) $item->limititem - 1;
        return $item->save();
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

    public function getItemLevel($percent) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'percent=:percent';
        $Criteria->params = array(':percent' => $percent);
        $QuaysoItem = new QuaysoItem();
        $QuaysoItem = $QuaysoItem->findAll($Criteria);
        $count = sizeof($QuaysoItem);
        if ($count == 1)
            return $QuaysoItem[0];
        $rd = rand(0, $count - 1);
        return $QuaysoItem[$rd];
    }

    public function getListPercent() {
        $Criteria = new CDbCriteria();
        $Criteria->select = 'DISTINCT percent';
        $Criteria->condition = 'percent <> 0';
        $QuaysoItem = new QuaysoItem();
        $QuaysoItem = $QuaysoItem->findAll($Criteria);
        return $QuaysoItem;
    }

}

?>
