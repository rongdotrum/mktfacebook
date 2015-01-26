<?php

/**
 * This is the model class for table "servers".
 *
 * The followings are the available columns in table 'servers':
 * @property integer $server_id
 * @property integer $gameserver_id
 * @property string $server_name
 * @property string $created_date
 * @property string $published_date
 * @property string $wt
 * @property string $dx
 * @property integer $port
 * @property string $fileUrl
 * @property string $thenew
 * @property string $rechargeUrl
 * @property string $bbsUrl
 * @property string $homeUrl
 * @property string $maintenanceUrl
 * @property integer $status
 */
class Servers extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Servers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'servers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('gameserver_id, server_name, wt, dx, port, fileUrl', 'required'),
            array('gameserver_id, port, status', 'numerical', 'integerOnly' => true),
            array('server_name, wt, fileUrl, thenew', 'length', 'max' => 50),
            array('dx', 'length', 'max' => 150),
            array('rechargeUrl, bbsUrl, homeUrl, maintenanceUrl', 'length', 'max' => 200),
            array('created_date, published_date,dbname', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('server_id, gameserver_id, server_name, created_date, published_date, wt, dx, port, fileUrl, thenew, rechargeUrl, bbsUrl, homeUrl, maintenanceUrl, status,dbname', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'server_id' => 'Server',
            'gameserver_id' => 'Gameserver',
            'server_name' => 'Server Name',
            'created_date' => 'Created Date',
            'published_date' => 'Published Date',
            'wt' => 'Wt',
            'dx' => 'Dx',
            'port' => 'Port',
            'fileUrl' => 'File Url',
            'thenew' => 'Thenew',
            'rechargeUrl' => 'Recharge Url',
            'bbsUrl' => 'Bbs Url',
            'homeUrl' => 'Home Url',
            'maintenanceUrl' => 'Maintenance Url',
            'status' => 'Status',
            'dbname'=>'Db name'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('server_id', $this->server_id);
        $criteria->compare('gameserver_id', $this->gameserver_id);
        $criteria->compare('server_name', $this->server_name, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('published_date', $this->published_date, true);
        $criteria->compare('wt', $this->wt, true);
        $criteria->compare('dx', $this->dx, true);
        $criteria->compare('port', $this->port);
        $criteria->compare('fileUrl', $this->fileUrl, true);
        $criteria->compare('thenew', $this->thenew, true);
        $criteria->compare('rechargeUrl', $this->rechargeUrl, true);
        $criteria->compare('bbsUrl', $this->bbsUrl, true);
        $criteria->compare('homeUrl', $this->homeUrl, true);
        $criteria->compare('maintenanceUrl', $this->maintenanceUrl, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('dbname', $this->dbname); 

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
