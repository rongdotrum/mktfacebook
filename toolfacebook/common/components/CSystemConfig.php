<?php
class CSystemConfig
{
    public static function GetAllSysConfig($rerurn = false)
    {
        $sysConfig = Sysconfig::model()->findAll(array('condition'=>'delflg=true'));
        $temp = array();
        if(!is_null($sysConfig))
        {
            foreach($sysConfig as $cofig)
            {
                $temp[$cofig->configkey]=$cofig->configvalue;
            }
            Yii::app()->setParams(array('sysconfig'=>$temp));
        }
        if($rerurn) return $temp;
    }
}
?>
