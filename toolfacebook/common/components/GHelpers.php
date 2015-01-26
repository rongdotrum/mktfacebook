<?php


class GHelpers {

    static function activateKey($email) {
        return sha1(mt_rand(10000, 99999) . time() . $email);
    }

    /**
     * Lấy Id tiếp theo của bảng truyền vào
     * @param type $table : tên bảng
     * @param type $key : trường khóa.
     * @param type $value : giá trị trường khóa
     * @param type $fieldget : trường muốn lấy Id kế tiếp
     * @return type
     */
    static function getNextId($table, $key, $value, $fieldget) {
        $db = app()->db;
        $sql = "SELECT (MAX($fieldget)) as NextId FROM $table WHERE $key = $value";
        $array = $db->createCommand($sql)->query()->read();
        return (int) $array['NextId'] + 1;
    }

    static function getNextVal($name) {
        $db = app()->db;
        $year = date('Y');
        $sql = "SELECT next_val FROM sequence_mng Where name = '$name' AND year = '$year'";
        $result = $db->createCommand($sql)->query()->read();
        $sql2 = "UPDATE sequence_mng set next_val = next_val+1 where name='$name' AND year = '$year'";
        $update = $db->createCommand($sql2)->query();
        return $result['next_val'];
    }

    static function getDropDownList($model, $valueAttribute, $textAttribute, $condition = null,$order = null) {
        $results = array();
        if (isset($model) && isset($valueAttribute) && isset($textAttribute)) {
            $colums[] = $valueAttribute;
            $colums[] = $textAttribute;
            $criteria = new CDbCriteria();
            $criteria->select = $colums;
            $criteria->distinct = true;
            if (isset($condition)) $criteria->condition = $condition;
            if (isset($order)) $criteria->order = $order;
            $model = new $model;
            $results = $model->findAll($criteria);
        }
        return CHtml::listData($results, $valueAttribute, $textAttribute);
    }

    static function EncryptAccountName($username,$iduser)
    {
        $infopack = "NoiDungPack";
        $usergame = md5($username.$infopack);
        $uidpack = substr($usergame,0,8).$iduser;
        
        return $uidpack;
    }
    
     static function fetch_random_string($length = 32) {
        $hash = sha1(time() . microtime() . uniqid(mt_rand(), true) . @implode('', @fstat(@fopen(__FILE__, 'r'))));
        $hash = base64_encode($hash);
        return substr($hash, 0, $length);
    }
}

?>
