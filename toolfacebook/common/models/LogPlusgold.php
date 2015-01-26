<?php

/**
 * This is the model class for table "log_plusgold".
 *
 * The followings are the available columns in table 'log_plusgold':
 * @property string $LogId
 * @property string $UserName
 * @property integer $ServerId
 * @property integer $Gold
 * @property string $PlusDate
 * @property string $Admin
 * @property integer $Status
 */
class LogPlusgold extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogPlusgold the static model class
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
		return 'log_plusgold';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UserName, ServerId, Gold', 'required'),
			array('ServerId, Gold, Status', 'numerical', 'integerOnly'=>true),
			array('UserName, Admin', 'length', 'max'=>50),
			array('PlusDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('LogId, UserName, ServerId, Gold, PlusDate, Admin, Status', 'safe', 'on'=>'search'),
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
			'LogId' => 'Log',
			'UserName' => 'User Name',
			'ServerId' => 'Server',
			'Gold' => 'Gold',
			'PlusDate' => 'Plus Date',
			'Admin' => 'Admin',
			'Status' => 'Status',
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

		$criteria->compare('LogId',$this->LogId,true);
		$criteria->compare('UserName',$this->UserName,true);
		$criteria->compare('ServerId',$this->ServerId);
		$criteria->compare('Gold',$this->Gold);
		$criteria->compare('PlusDate',$this->PlusDate,true);
		$criteria->compare('Admin',$this->Admin,true);
		$criteria->compare('Status',$this->Status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}