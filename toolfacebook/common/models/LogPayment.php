<?php

/**
 * This is the model class for table "log_payment".
 *
 * The followings are the available columns in table 'log_payment':
 * @property string $id
 * @property integer $userid
 * @property string $username
 * @property string $content
 * @property string $time
 * @property string $cardtype
 * @property string $serial
 * @property string $code
 * @property string $trans_no
 * @property string $respond_id
 * @property string $amount
 * @property integer $gold
 * @property integer $server_id
 */
class LogPayment extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LogPayment the static model class
     */
    public $startdate;
    public $enddate;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'log_payment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userid', 'required'),
            array('userid, gold, server_id', 'numerical', 'integerOnly' => true),
            array('username, trans_no', 'length', 'max' => 50),
            array('cardtype, serial, code, respond_id, amount', 'length', 'max' => 20),
            array('startdate,enddate,content, time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, userid, username, content, time, cardtype, serial, code, trans_no, respond_id, amount, gold, server_id', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'userid' => 'Userid',
            'username' => 'Username',
            'content' => 'Content',
            'time' => 'Time',
            'cardtype' => 'Cardtype',
            'serial' => 'Serial',
            'code' => 'Code',
            'trans_no' => 'Trans No',
            'respond_id' => 'Respond',
            'amount' => 'Amount',
            'gold' => 'Gold',
            'server_id' => 'Server',
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
        if (isset($this->startdate) and isset($this->enddate)) {
            if (empty($this->enddate))
                $criteria->compare('date(time)', '>=' . $this->startdate);
            elseif (empty($this->startdate))
                $criteria->compare('date(time)', '<=' . $this->enddate);
            else
                $criteria->addBetweenCondition('date(time)', $this->startdate, $this->enddate);
        }

        $criteria->compare('id', $this->id, true);
        $criteria->compare('userid', $this->userid);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('cardtype', $this->cardtype, true);
        $criteria->compare('serial', $this->serial, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('trans_no', $this->trans_no, true);
        $criteria->compare('respond_id', $this->respond_id, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('gold', $this->gold);
        $criteria->compare('server_id', $this->server_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
