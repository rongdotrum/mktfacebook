<?php

/**
 * This is the model class for table "log_quayso".
 *
 * The followings are the available columns in table 'log_quayso':
 * @property integer $LogId
 * @property integer $userid
 * @property string $username
 * @property string $content
 * @property integer $server_id
 * @property string $datequay
 * @property integer $type
 * @property integer $quantily
 */
class LogQuayso extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LogQuayso the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'log_quayso';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userid, server_id, type, quantily', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'max' => 50),
            array('content', 'length', 'max' => 100),
            array('datequay, codeingame,isfreeday', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('LogId, userid, username, content, server_id, datequay, type, quantily, codeingame, isfreeday', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'servers' => array(self::BELONGS_TO, 'Servers', 'server_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'LogId' => 'Log',
            'userid' => 'Userid',
            'username' => 'Username',
            'content' => 'Content',
            'server_id' => 'Server',
            'datequay' => 'Datequay',
            'type' => 'Type',
            'quantily' => 'Quantily',
            'codeingame' => 'CodeInGame',
            'isfreeday' => 'IsFreeDay'
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

        $criteria->compare('LogId', $this->LogId);
        $criteria->compare('userid', $this->userid);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('server_id', $this->server_id);
        $criteria->compare('datequay', $this->datequay, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('quantily', $this->quantily);
        $criteria->compare('codeingame', $this->codeingame);
        $criteria->compare('isfreeday', $this->isfreeday);
        $criteria->order = 'datequay desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
