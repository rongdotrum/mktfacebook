<?php

/*
 * Chua cac dinh nghia hang so dung trong du an
 */

class GConst {

    const DEL_FLG_NOT_DELETED = 0;
    const DEL_FLG_DELETED = 1;
    const USER_TYPE_INTERNAL = 1;
    const USER_TYPE_EXTERNAL = 2;
    const STATUS_UNACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const ENCRYPT_MD5 = 0;
    const ENCRYPT_SHA = 1;
    const EMAIL_REGISTER = 1;
    const EMAIL_RESET_PASS = 2;
    const Cat_SuKien = 1;
    const Cat_TinTuc = 2;
    const Cat_HuongDan = 3;
    const Cat_ThongBao = 4;
    const TOP_RIGHT_MODULE = 1;


    public static $Quayso = array('10000' => 0, '20000' => 1, '30000' => 1, '50000' => 3, '100000' => 6, '200000' => 12, '300000' => 18, '500000' => 30);

}

