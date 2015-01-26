<?php

/**
 * This is the model class for table "log_user".
 *
 * The followings are the available columns in table 'log_user':
 * @property string $username
 * @property string $ip
 * @property string $createddate
 * @property integer $loguserid
 * @property string $content
 * @property string $action
 */
class LogUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogUser the static model class
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
		return 'log_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ip, createddate, content, action', 'required'),
			array('username', 'length', 'max'=>100),
			array('ip, action', 'length', 'max'=>50),
			array('content', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('username, ip, createddate, loguserid, content, action', 'safe', 'on'=>'search'),
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
			'username' => 'Tên Tài Khoản',
			'ip' => 'Ip',
			'createddate' => 'Thời Gian',
			'loguserid' => 'Loguserid',
			'content' => 'Nội Dung',
			'action' => 'Hành Động',
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

		$criteria->compare('username',$this->username,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('createddate',$this->createddate,true);
		$criteria->compare('loguserid',$this->loguserid);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('action',$this->action,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}