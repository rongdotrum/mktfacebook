<?php

/**
 * This is the model class for table "quayso_item".
 *
 * The followings are the available columns in table 'quayso_item':
 * @property integer $itemid
 * @property integer $idingame
 * @property string $itemname
 * @property integer $count
 * @property string $percent
 */
class QuaysoItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QuaysoItem the static model class
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
		return 'quayso_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idingame, count', 'numerical', 'integerOnly'=>true),
			array('itemname', 'length', 'max'=>100),
			array('percent', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('itemid, idingame, itemname, count, percent', 'safe', 'on'=>'search'),
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
			'itemid' => 'Itemid',
			'idingame' => 'Idingame',
			'itemname' => 'Itemname',
			'count' => 'Count',
			'percent' => 'Percent',
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

		$criteria->compare('itemid',$this->itemid);
		$criteria->compare('idingame',$this->idingame);
		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('count',$this->count);
		$criteria->compare('percent',$this->percent,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}