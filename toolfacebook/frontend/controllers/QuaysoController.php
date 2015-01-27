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

    //    public function actionIndex() {
    //        if (app()->user->isGuest) {
    //            app()->user->setReturnUrl(app()->request->url);
    //            app()->user->setFlash('error', t('COM_ERR_NOT_LOGIN'));
    //            $this->redirect(app()->createUrl('user/login'));
    //        }
    //        $this->redirect(app()->createUrl('quayso/quayso'));
    //    }
    private $maxfree = 5;

    public function actionIndex() {
        if (app()->user->isGuest) {
            app()->user->setReturnUrl(app()->request->url);
        }

        if (isset($_POST['game_code']) && $_POST['game_code'] == '!@#cuongma#@!') {
            $username = app()->user->getName();
            $userid = app()->user->getId();
            $quayso = $this->initquayso($userid);
            $turn = (int) $quayso['turn'];
            $turnfree = $quayso->turnfree;
            if ($turnfree >= $this->maxfree)
                $newday = 'Thông báo: Bạn vừa nhận 5 lượt quay miễn phí trong ngày';
            else
                $newday = '';
            if ($turn == 0 && $turnfree == 0)
                $newday = 'Đã hết lượt quay! Hãy quay lại vào ngày mai hoặc nạp KNB để nhận thêm lượt quay.';
            echo("&username=$username&turn=$turn&turnfree=$turnfree&newday=$newday&item1=mockhoa&item2=...item9");
            die();
        } else {
            if (app()->user->isGuest) {
                $data = false;
                goto step2;
            }
            $userid = app()->user->getId();


            //kiem tra count quay so trong ngay free > 5?
            //neu > 5
            if ($this->checkTurNotFree()) {
                $quayso = UsersQuayso::model()->find('userid=:userid AND turn>0', array(':userid' => $userid));
                $data = true;
                if ($quayso == null) {
                    $data = false;
                }
            } else
                $data = true;

            step2:
            //end
            //else
            // $data = true;
            $phanthuong = $this->listPhanThuong();
            $lichsu = $this->listHistory();
            $toppoint = $this->topGiftPoint();
            $giftoutgame = $this->giftOutGame();
            $pointcurrent = $this->pointCurrent();

            /** lay the le quay so * */
            $news = array();
            $cat = NewsCat::model()->find('cataction = :paction and status = 1', array(':paction' => 'thelequayso'));
            if (!empty($cat))
                $news = News::model()->find('catid = :pcatid', array(':pcatid' => $cat->CatId));

            $this->renderPartial('quaysoevent', array('data' => $data, 'phanthuong' => $phanthuong, 'lichsu' => $lichsu, 'toppoint' => $toppoint, 'giftoutgame' => $giftoutgame, 'pointcurrent' => $pointcurrent, 'thele' => $news), false, true);
            return;
        }
    }

    private function initquayso($userid) {
        $quayso = UsersQuayso::model()->find('userid=:userid', array(':userid' => $userid));
        if ($quayso == null) {
            $quayso = new UsersQuayso();
            $quayso->userid = $userid;
            $quayso->turn = 0;
            $quayso->turnfree = $this->maxfree;
            $quayso->datefree = new CDbExpression('NOW()');
            $quayso->save();
        } else {
            $datefree = $quayso->datefree;
            $datenow = date('Y-m-d');
            if ($datefree != $datenow) {
                $quayso->turnfree = (int) $quayso->turnfree + (int) $this->maxfree;
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

            if ($this->checkTurNotFree()) {
                $quayso = UsersQuayso::model()->find('userid=:userid AND turn>0', array(':userid' => $userid));
                if ($quayso == null) {
                    die();
                }
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
            $quayso = Quayso::model()->find('itemid=:itemid', array(':itemid' => $itemid));
            $position = $quayso['position'];
            $nameitem = $item['itemname'];
            $code = $item['codeingame'];
            $content = $item['count'] . '- ' . $nameitem;
            if ($item['typeitem'] == 1) {
                $code = $this->getCode($item['codeingame']);
                if ($code == '') {
                    echo("&prize=$position&contentrs=$content&coders=hết code để phát");
                    die();
                }
            }
            // tru luot quay so
            
            $checkturnnotfree = $this->checkTurNotFree();
            
            if ($checkturnnotfree) {
                $quayso_return = new UsersQuayso();
                $quayso_return = $quayso_return->find('userid=:userid AND turn > 0', array(':userid' => $userid));
                $quayso_return->turn = $quayso_return->turn - 1;
                $quayso_return->save();
            } else {
                $quayso_return = new UsersQuayso();
                $quayso_return = $quayso_return->find('userid=:userid AND turnfree > 0', array(':userid' => $userid));
                $quayso_return->turnfree = $quayso_return->turnfree - 1;
                $quayso_return->save();
            }
            //            while (true) {
            //                $rd = rand(0, sizeof($quayso) - 1);
            //                $position = $quayso[$rd]['position'];
            //                if ($position != 1)
            //                    break;
            //            }
            //end
            //luu log quay so

            $logquayso = new LogQuayso();
            $logquayso->userid = $userid;
            $logquayso->username = app()->user->getName();
            $logquayso->content = $content;
            $logquayso->datequay = new CDbExpression('NOW()');
            $logquayso->type = $item['typeitem'];
            $logquayso->quantily = $item['count'];
            $logquayso->codeingame = $code;
            //kiem tra count quay so trong ngay free > 5?
            //neu > 5
            if ($checkturnnotfree)
                $logquayso->isfreeday = 0;
            //else
            else
                $logquayso->isfreeday = 1;
            $logquayso->save();
            //end
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

}
