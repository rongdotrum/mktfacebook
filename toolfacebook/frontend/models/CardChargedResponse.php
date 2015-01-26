<?php
class CardChargedResponse
{
    public $retCode;
    public $retMsg;
    public $data_transId;
    public $data_cardValue;
        
    public $golden = 0; //vang duoc quy doi tu menh gia the + vang duoc khuyen mai neu co
    public $isPromotion = false; //co khuyen mai hay khong
    
}
?>
