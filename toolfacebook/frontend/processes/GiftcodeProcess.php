<?php
  class GiftcodeProcess extends GBaseBusinessProcess {
        protected function executeProcess() {        
        $params = $this->params;   
        $service = new GService();    
        $server = Servers::model()->findByPk($params['serverid'],'status in (1,2) and published_date <= now()');
        if ($server == null) {
            $this->errorAdd('Không tìm thấy server');
            return parent::BL_RET_ERROR;
        }        
        if ($params['tanthu'] == 0) {           
            $giftcode = GiftcodeInput::model()->findByPk($params['code'],'status != 0');
            $GiftID = $giftcode['code'];
            if ($giftcode == null)
            {
                $this->errorAdd('Giftcode không tồn tại');
                return parent::BL_RET_ERROR; 
            }
            if ($giftcode['del_flg']==1)
            {
                $this->errorAdd('Code đã được nhập');
                return parent::BL_RET_ERROR; 
            }    
            else {
                $single = true;
                if ($giftcode['status'] == 2)
                    $single = false;
                $crit = new CDbCriteria();
                $crit->compare('serverid',$params['serverid']);
                $crit->compare('userid',$params['userid']);
                $crit->compare('isGet',1);
                $crit->compare('codeid',$giftcode['key_code'],$single);                
                $loggift = GiftCodeReceiveLog::model()->find($crit);            
                if ($loggift != null) {
                    $this->errorAdd('bạn đã nhận event code này ở server '.$server->server_name);
                    return parent::BL_RET_ERROR;          
                }
            }
        }
        elseif($params['tanthu'] == 3) {
           $giftonline = $this->giftonline($params,$server);
           if ($giftonline == 'success' ) {
               return parent::BL_RET_SUCCESS;
           }
           else {
               $this->errorAdd($giftonline);
               return parent::BL_RET_ERROR;   
           }
        }
        else {
            $giftcode['itemid'] = '';
            $GiftID = 'TANTHU';            
            $loggift = GiftCodeReceiveLog::model()->find('serverid=:serverid AND userid=:userid AND isGet=1 and codeid = :code', array(':serverid' => $params['serverid'], ':userid' => $params['userid'],':code'=>$GiftID));
            if ($loggift != null) {
                $this->errorAdd('Bạn đã nhận quà tân thủ ở server này');
                return parent::BL_RET_ERROR;          
            }
        }
        
        
        $urlService = $server->rechargeUrl . param('gold')['serviceUrl'];
        if (!remote_file_exists($urlService))  {
            $this->errorAdd('Kết nối đến hệ thống server thất bại');
            return parent::BL_RET_ERROR; 
        }  
        $checkuser = $service->checkPlayer($server,$params['username'],$params['userid']);
           
        $key = param('gold')['key'];
        $username = $params['username'];
        $userid = $params['userid'];
        $AccountGame = $userid; // GHelpers::EncryptAccountName($username, $userid);
        $vip = 0;
        $sign = md5($AccountGame . $vip . $key);
        $param_service = array('AccountGame' => $AccountGame,'vip'=>$vip, 'code' => $giftcode['itemid'],'dbname'=>$server->dbname, 'sign' => $sign);
           
        ini_set('soap.wsdl_cache_enable', 0);
        ini_set('soap.wsdl_cache_ttl', 0);
        $client = new SoapClient(null, array('location' => $urlService, 'uri' => "localhost"));        
        
        // check user
        $result = $client->__soapCall('giftcode', $param_service);              
        if ($result != 1) {
            switch ($result) {
                case -15:
                    $this->errorAdd('Sai địa chỉ IP');
                    return parent::BL_RET_ERROR;                             
                case -11:
                    $this->errorAdd('Xác thực không hợp lệ');
                    return parent::BL_RET_ERROR;       
                case 0:
                    $this->errorAdd('Server này chưa tạo nhân vật. Hãy tạo nhân vật');
                    return parent::BL_RET_ERROR;                                          
            }
        } else {            
            $isGet = 1;
            $codeid = $GiftID;
            $sign = md5($AccountGame . $key);
            $param_service = array('AccountGame' => $AccountGame,'dbname'=>$server->dbname, 'sign' => $sign);
            ini_set('soap.wsdl_cache_enable', 0);
            ini_set('soap.wsdl_cache_ttl', 0);
            $client = new SoapClient(null, array('location' => $urlService, 'uri' => "localhost"));
            // check user
            $player = $client->__soapCall('getplayer', $param_service);
            $GiftCodeReceiveLog = new GiftCodeReceiveLog();
            $GiftCodeReceiveLog->serverid = $server->server_id;
            $GiftCodeReceiveLog->userid = $params['userid'];
            $GiftCodeReceiveLog->playername = $player;
            $GiftCodeReceiveLog->isGet = $isGet;
            $GiftCodeReceiveLog->codeid = $codeid;
            if ($GiftCodeReceiveLog->save())    
            {
                if ($params['tanthu']== 0) {
                     $giftcode->del_flg = 1;
                     $giftcode->save();      
                }
                 return parent::BL_RET_SUCCESS;//$redirecturl = 'Nhận giftcode thành công';                 
            }
        }
        if ($params['tanthu'] == 0)
            $this->errorAdd('Nhận giftcode không thành công. Vui lòng thử lại sau.');
        else
            $this->errorAdd('Nhận quà tân thủ không thành công. Vui lòng thử lại sau.');
        return parent::BL_RET_ERROR;           
    }
    
    private function giftonline($params,$servers) {
        $crit = new CDbCriteria();
        $crit->compare('cost',0);
        $crit->compare('status',1);
        $crit->compare('date(startdate)',date('Y-m-d'));
        $crit->compare('date(enddate)',date('Y-m-d'));
        $gift = EventGift::model()->find($crit);            
        if (!isset($gift->eid))
            return 'Quà Online Chưa Có'; 
        
        $dategift = date('Y-m-d',strtotime($gift->startdate));
        
        $log = EventGiftLog::model()->find('userid = :uid and serverid = :sid and eid = :eid and
        date(receive_date) = :pdate',array('uid'=>Yii::app()->user->getId(),'sid'=>$params['serverid'],'eid'=>$gift->eid,'pdate'=>$dategift));               
        if (!isset($log->eid)) {                
            $service = new GService();
            $result = $service->senditem($servers,Yii::app()->user->getId(),$gift->itemid,'QUA ONLINE');
            if ( $result == 1)  {
                $log = new EventGiftLog();
                $log->serverid = $params['serverid'];
                $log->userid = Yii::app()->user->getId();
                $log->eid = $gift->eid;
                $log->itemid = $gift->itemid;
                $log->save();
                return 'success';
            }
            else 
                return 'Có lỗi xảy ra vui lòng thử lại';                  
        }  
        else
            return 'Bạn đã nhận quà ở server này';                  
    }
  }
?>
