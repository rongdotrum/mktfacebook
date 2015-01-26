<?php

/**
 * This is the model class for table "event_gift".
 *
 * The followings are the available columns in table 'event_gift':
 * @property integer $eid
 * @property string $startdate
 * @property string $enddate
 * @property string $itemid
 * @property string $description
 * @property integer $cost
 * @property integer $status
 */
class EventGift extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'event_gift';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cost, status', 'numerical', 'integerOnly'=>true),
			array('itemid, description', 'length', 'max'=>255),
			array('startdate, enddate', 'safe'),
            array('itemid','filter','filter'=>'trim'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('eid, startdate, enddate, itemid, description, cost, status', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'eid' => 'Eid',
			'startdate' => 'Startdate',
			'enddate' => 'Enddate',
			'itemid' => 'Itemid',
			'description' => 'Description',
			'cost' => 'Cost',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('eid',$this->eid);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('itemid',$this->itemid,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventGift the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
