<?php

/**
 * This is the model class for table "userfield".
 *
 * The followings are the available columns in table 'userfield':
 * @property string $userid
 * @property string $temp
 * @property string $field1
 * @property string $field2
 * @property string $field3
 * @property string $field4
 */
class Userfield extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Userfield the static model class
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
		return 'userfield';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid', 'length', 'max'=>10),
			array('temp, field1, field2, field3, field4', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userid, temp, field1, field2, field3, field4', 'safe', 'on'=>'search'),
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
			'userid' => 'Userid',
			'temp' => 'Temp',
			'field1' => 'Field1',
			'field2' => 'Field2',
			'field3' => 'Field3',
			'field4' => 'Field4',
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

		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('temp',$this->temp,true);
		$criteria->compare('field1',$this->field1,true);
		$criteria->compare('field2',$this->field2,true);
		$criteria->compare('field3',$this->field3,true);
		$criteria->compare('field4',$this->field4,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}