<?php

/**
* This is the model class for table "event_card".
*
* The followings are the available columns in table 'event_card':
* @property string $event_card_id
* @property integer $user_id
* @property integer $payment_id
* @property integer $cnt
* @property string $last_date
* @property integer $total_cash
* @property integer $total_gold
* @property integer $serverid
*/
class Eventcard extends CActiveRecord
{
    
    public $display_name;
    
    /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return Eventcard the static model class
    */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
    * @return string the associated database table name
    */
    public function tableName()
    {
        return 'event_card';
    }

    /**
    * @return array validation rules for model attributes.
    */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, payment_id', 'required'),
            array('user_id, payment_id, cnt, total_cash, total_gold,serverid', 'numerical', 'integerOnly'=>true),
            array('last_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('event_card_id, user_id, payment_id, cnt, last_date, total_cash, total_gold,serverid,display_name', 'safe', 'on'=>'search'),
        );
    }

    /**
    * @return array relational rules.
    */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'users'=>array(self::BELONGS_TO,'Users','user_id'),
            'server'=>array(self::BELONGS_TO,'Servers','serverid')
        );
    }

    /**
    * @return array customized attribute labels (name=>label)
    */
    public function attributeLabels()
    {
        return array(
            'event_card_id' => 'Event Card',
            'user_id' => 'User',
            'payment_id' => 'Payment',
            'cnt' => 'Cnt',
            'last_date' => 'Last Date',
            'total_cash' => 'Total Cash',
            'total_gold' => 'Total Gold',
            'serverid' => 'Serverid'
        );
    }

    /**
    * Retrieves a list of models based on the current search/filter conditions.
    * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
    */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->with = array('users');
        
        
        $criteria->compare('event_card_id',$this->event_card_id,true);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('payment_id',$this->payment_id);
        $criteria->compare('cnt',$this->cnt);
        $criteria->compare('last_date',$this->last_date,true);
        $criteria->compare('total_cash',$this->total_cash);
        $criteria->compare('total_gold',$this->total_gold);        
        $criteria->compare('serverid',$this->serverid);        
        $criteria->compare('users.display_name',$this->display_name,true);
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'last_date DESC',
            )
        ));
    }
}