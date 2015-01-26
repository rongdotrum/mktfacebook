<?php

/**
 * This is the model class for table "giftcode_gameitem".
 *
 * The followings are the available columns in table 'giftcode_gameitem':
 * @property integer $id
 * @property integer $serverid
 * @property string $giftid
 * @property integer $itemit
 * @property string $itemname
 * @property integer $count
 */
class GiftcodeGameitem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GiftcodeGameitem the static model class
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
		return 'giftcode_gameitem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serverid, giftid, itemit, itemname', 'required'),
			array('serverid, itemit, count', 'numerical', 'integerOnly'=>true),
			array('giftid, itemname', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, serverid, giftid, itemit, itemname, count', 'safe', 'on'=>'search'),
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
			'serverid' => 'Serverid',
			'giftid' => 'Giftid',
			'itemit' => 'Itemit',
			'itemname' => 'Itemname',
			'count' => 'Count',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('serverid',$this->serverid);
		$criteria->compare('giftid',$this->giftid,true);
		$criteria->compare('itemit',$this->itemit);
		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('count',$this->count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}