<?php

/**
 * This is the model class for table "sysconfig".
 *
 * The followings are the available columns in table 'sysconfig':
 * @property integer $id
 * @property string $configkey
 * @property string $configvalue
 * @property integer $delflg
 * @property string $description
 */
class Sysconfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sysconfig';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('configkey, configvalue', 'required'),
			array('delflg', 'numerical', 'integerOnly'=>true),
			array('configkey', 'length', 'max'=>255),
			array('configvalue', 'length', 'max'=>500),
			array('description', 'length', 'max'=>200),
            array('configkey','unique','className'=>'Sysconfig'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, configkey, configvalue, delflg, description', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'configkey' => 'Configkey',
			'configvalue' => 'Configvalue',
			'delflg' => 'Delflg',
			'description' => 'Description',

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

		$criteria->compare('id',$this->id);
		$criteria->compare('configkey',$this->configkey,true);
		$criteria->compare('configvalue',$this->configvalue,true);
		$criteria->compare('delflg',$this->delflg);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sysconfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
