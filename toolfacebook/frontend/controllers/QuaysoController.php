<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

class QuaysoController extends Controller {

    public function accessRules() {

        return array(
        );
    }

    private $maxfree = 3;
    private $maxshare = 1;
    private $maxfreeday = 3;

    public function actionIndex() {           
        if (app()->user->isGuest) {
            app()->user->setReturnUrl(app()->request->url);
        }
        if (isset($_POST['game_code']) && $_POST['game_code'] == '!@#cuongma#@!') {
            $username = app()->user->getName();
            $userid = app()->user->getId();
            $quayso = $this->initquayso($userid);
            $turn = (int) $quayso['turn'];
            $shared = (int)$quayso['turnfree'];
            if ($turn == 0)
                $newday = 'Đã hết lượt quay! Hãy chia sẽ cho bạn bè để nhận tiếp lượt quay.';
            else
                $newday = 'Mẹo nhỏ: Mỗi ngày bạn được nhận '. $this->maxfreeday .' lượt quay. Bạn có thể share thêm ' . $this->maxshare . ' lần. Mỗi lần share nhận được ' . $this->maxfree . ' lượt quay miễn phí.' ;

            $item = Quayso::model()->findAll();
            $user = Users::model()->findByPk($userid);
            $str_item = '';
            foreach($item as $key => $value ) {
                if (isset($value->items->itemname)) {                
                    $pluskey = $value->position;
                    if ($value->items->count != 0)
                    $str_item .= "&item$pluskey=".urlencode($value->items->count.'-'.$value->items->itemname);
                    else
                    $str_item .= "&item$pluskey=".urlencode($value->items->itemname);
                }
            }           
            echo "&share=$shared&username={$user->social_name}&turn=$turn&newday=$newday".$str_item;
            die();
        } else {                        
            $userid = app()->user->getId();
            
	    $crit = new CDbCriteria();
            $crit->compare('userid',$userid);
            $crit->order = 'datequay desc';
            $logprovider = new CActiveDataProvider('LogQuayso', array(
                'criteria'=>$crit,                
                'pagination'=>array(
                    'pageSize'=>10,
                ),
            ));
              
            $this->render('index',array('logquayso'=>$logprovider));
            
            
            return;
        }
    }

    private function initquayso($userid) {
        $quayso = UsersQuayso::model()->find('userid=:userid', array(':userid' => $userid));
        if ($quayso == null) {
            $quayso = new UsersQuayso();
            $quayso->userid = $userid;
            $quayso->turn = $this->maxfreeday;
            $quayso->turnfree = 0;
            $quayso->datefree = new CDbExpression('NOW()');
            $quayso->save();
        } else {
            $datefree = $quayso->datefree;
            $datenow = date('Y-m-d');
            if ($datefree != $datenow) {
                $quayso->turn = $this->maxfreeday;
                $quayso->turnfree = 0;
                $quayso->datefree = $datenow;
                $quayso->save();
            }
        }
        return $quayso;
    }

    public function actionPhatthuong() {
        if (app()->user->isGuest) {
            die();
        }
        
        if (isset($_POST['game_code']) && $_POST['game_code'] == '!@#cuongma#@!') {
            //kiem tra count quay so trong ngay free > 5?
            //neu > 5 && khong co turn nao từ nạp card
            // die();
            $userid = app()->user->getId();

            $quayso = UsersQuayso::model()->find('userid=:userid AND turn>0', array(':userid' => $userid));
            if ($quayso == null) {
                die();
            }
            //end
            $process = new GQuaysoProcess();
            $quaysoitem = $process->getListPercent();
            $max = 0;
            foreach ($quaysoitem as $value) {
                $max += (int) $value['percent'];
            }
            randquayso:
            $randint = rand(1, $max);
            //$idingame = 0;
            $item = array();
            //$item = $process->getItemLevel($quaysoitem[0]['percent']);
            $temp2 = 0;
            for ($i = 0; $i < sizeof($quaysoitem); $i++) {
                if ($i == 0)
                    $temp1 = 0;
                else
                    $temp1 += $quaysoitem[$i - 1]['percent'];

                $temp2 = $temp1 + $quaysoitem[$i]['percent'];
                if ($randint >= $temp1 && $randint <= $temp2) {
                    $item = $process->getItemLevel($quaysoitem[$i]['percent']);
                    if ((int) $item['typeitem'] != 0) {
                        if ((int) $item['limititem'] <= 0 || (int) $item['percent'] == 0)
                            goto randquayso;
                        else {
                            //tru limititem
                            if (!$process->SubLimitItem($item['itemid']))
                                die('quá trình trừ số lượng thất bại');
                        }
                    }
                }
            }
            /* if ($randint <= (int) $quaysoitem[0]['percent']) {
            $item = $process->getItemLevel($quaysoitem[0]['percent']);
            } elseif ($randint <= (int) $quaysoitem[0]['percent'] + (int) $quaysoitem[1]['percent'] && $randint > $quaysoitem[0]['percent']) {
            $item = $process->getItemLevel($quaysoitem[1]['percent']);
            } elseif ($randint <= (int) $quaysoitem[0]['percent'] + (int) $quaysoitem[1]['percent'] + (int) $quaysoitem[2]['percent'] && $randint > (int) $quaysoitem[0]['percent'] + (int) $quaysoitem[1]['percent']) {
            $item = $process->getItemLevel($quaysoitem[2]['percent']);
            } elseif ($randint <= (int) $quaysoitem[0]['percent'] + (int) $quaysoitem[1]['percent'] + (int) $quaysoitem[2]['percent'] + (int) $quaysoitem[3]['percent'] && $randint > (int) $quaysoitem[0]['percent'] + (int) $quaysoitem[1]['percent'] + (int) $quaysoitem[2]['percent']) {
            $item = $process->getItemLevel($quaysoitem[3]['percent']);
            } else {
            $item = $process->getItemLevel($quaysoitem[4]['percent']);
            } */
                      
            $itemid = $item['itemid'];
            $quayso = Quayso::model()->findAll('itemid=:itemid', array(':itemid' => $itemid));
                        
            //xu ly random khi co 2 vi tri cung 1 item.
            $count = sizeof($quayso);
            
            if ($count == 1)
                $quayso = $quayso[0];            
            else {
                $rd = rand(0, $count - 1);            
                $quayso = $quayso[$rd];
            }
           
            //end

            $position = $quayso['position'];
            $nameitem = $item['itemname'];
            $code = $item['codeingame'];
            if ($item['count'] != 0)
                $content = $item['count'] . '-' . $nameitem;
            else
                $content = $nameitem;
            # tru luot quay so
            $quayso_return = new UsersQuayso();
            $quayso_return = $quayso_return->find('userid=:userid AND turn > 0', array(':userid' => $userid));
            $quayso_return->turn = $quayso_return->turn - 1;
            $quayso_return->save();
            #end

                        
            #luu log quay so

            $logquayso = new LogQuayso();
            $logquayso->userid = $userid;
            $logquayso->username = app()->user->getName();
            $logquayso->content = $content;
            $logquayso->datequay = new CDbExpression('NOW()');
            $logquayso->type = $item['typeitem'];
            $logquayso->quantily = $item['count'];
            $logquayso->codeingame = $code;
            $logquayso->isfreeday = 0;
            $logquayso->save();
            #end
            //truyen bien ve flash
            echo("&prize=$position&contentrs=$content&coders=$code");
            die();

            //end
        }
    }

    public function listPhanThuong() {
        /*
        $checkpercent = QuaysoItem::model()->find('percent != 0 AND typeitem = 2');

        if ($checkpercent == null)
        $sql = 'select it.*,qs.position from quayso as qs inner join (
        (select itemname,itemid,count from quayso_item where percent !=0  and typeitem != 2)
        union (select itemname,itemid,count from quayso_item where percent =0  and typeitem = 2 order by rand() limit 1)
        ) as it on it.itemid = qs.itemid order by position asc';
        else
        $sql = 'select *,it.itemname from quayso as qs inner join (
        (select itemname,itemid,count from quayso_item where percent !=0)
        ) as it on it.itemid = qs.itemid order by position asc';
        $data = new CSqlDataProvider($sql, array(
        'keyField' => 'itemid',
        ));
        */
        $data = new Quayso('Search');
        return $data;
    }

    public function listHistory() {
        if (app()->user->isGuest)
            return null;
        $logquayso = new LogQuayso('Search');
        $logquayso->userid = app()->user->getId();
        return $logquayso;
    }

    public function giftOutGame() {
        $model = new LogQuayso('Search');
        $model->type = 2;
        return $model;
    }

    public function topGiftPoint() {
        $sql = 'select sum(quantily) as total,username
        from log_quayso
        where type = 0
        group by userid
        order by total desc';

        $data = new CSqlDataProvider($sql, array(
        'keyField' => 'username',
        'totalItemCount' => 10,
        'pagination' => array(
        'pageSize' => 10,
        ),
        ));
        return $data;
    }

    private function checkTurNotFree() {
        $quayso = new UsersQuayso();
        $quayso = $quayso->find('userid=:userid', array(':userid' => app()->user->getId()));
        if ($quayso == null)
            return false;
        if ($quayso->datefree != date('Y-m-d'))
            return false;
        $turnfree = (int) $quayso->turnfree;
        return $turnfree == 0;
    }

    private function getCode($itemid) {
        $code = QuaysoItemcode::model()->find('itemid=:itemid AND (del_flag <> 1 OR del_flag is null)', array(':itemid' => $itemid));
        if ($code == null)
            return '';
        $code->del_flag = 1;
        $code->save();
        return $code['codeid'];
    }

    private function pointCurrent() {
        if (app()->user->isGuest)
            return 0;
        $crit = new CDbCriteria();
        $crit->select = 'sum(quantily) as quantily';
        $crit->compare('userid', app()->user->id);
        $crit->compare('type', 0);
        $crit->group = 'userid';
        $data = LogQuayso::model()->find($crit);
        return $data['quantily'];
    }
    public function actiontichluy() {
        if (app()->request->isAjaxRequest && !app()->user->isGuest){
            $pointcurrent = $this->pointCurrent();  
            echo 'Điểm Tích Lũy: '.number_format($pointcurrent);
        }
    }

    public function actionSharefb() {
        if (!Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest) {
            $quayso = UsersQuayso::model()->find('userid = :uid and (turnfree < :maxshare or turnfree is null) and datefree = date(now())',array(':uid'=>Yii::app()->user->getId(),':maxshare' => $this->maxshare));
            if (isset($quayso->id)) {
                $quayso->turnfree = $quayso->turnfree + 1;
                $quayso->turn += $this->maxfree;
                if ($quayso->save())
                {
                    echo 1;
                    Yii::app()->end();
                }
                    
            }
        }
        echo 0;        
        Yii::app()->end();
    }

}
