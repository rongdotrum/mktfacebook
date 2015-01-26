<?php

/**
 * This is the model class for table "gift_code_receive_log".
 *
 * The followings are the available columns in table 'gift_code_receive_log':
 * @property integer $id
 * @property integer $serverid
 * @property integer $userid
 * @property string $playername
 * @property integer $isGet
 * @property string $codeid
 */
class GiftCodeReceiveLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GiftCodeReceiveLog the static model class
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
		return 'gift_code_receive_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serverid, userid, playername, isGet', 'required'),
			array('serverid, userid, isGet', 'numerical', 'integerOnly'=>true),
			array('playername, codeid', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, serverid, userid, playername, isGet, codeid', 'safe', 'on'=>'search'),
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
			'userid' => 'Userid',
			'playername' => 'Playername',
			'isGet' => 'Is Get',
			'codeid' => 'Codeid',
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
		$criteria->compare('userid',$this->userid);
		$criteria->compare('playername',$this->playername,true);
		$criteria->compare('isGet',$this->isGet);
		$criteria->compare('codeid',$this->codeid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}