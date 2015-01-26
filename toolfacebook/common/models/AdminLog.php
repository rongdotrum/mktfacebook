<?php

/**
 * This is the model class for table "admin_log".
 *
 * The followings are the available columns in table 'admin_log':
 * @property integer $Log_Id
 * @property integer $Admin_Id
 * @property string $Admin_name
 * @property string $Action
 * @property string $Content
 * @property string $Ip
 * @property string $Datetime
 */
class AdminLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdminLog the static model class
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
		return 'admin_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Admin_Id, Admin_name, Action, Content, Ip, Datetime', 'required'),
			array('Admin_Id', 'numerical', 'integerOnly'=>true),
			array('Admin_name', 'length', 'max'=>50),
			array('Action', 'length', 'max'=>100),
			array('Content', 'length', 'max'=>300),
			array('Ip', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Log_Id, Admin_Id, Admin_name, Action, Content, Ip, Datetime', 'safe', 'on'=>'search'),
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
			'Log_Id' => 'Log',
			'Admin_Id' => 'Admin',
			'Admin_name' => 'Admin Name',
			'Action' => 'Action',
			'Content' => 'Content',
			'Ip' => 'Ip',
			'Datetime' => 'Datetime',
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

		$criteria->compare('Log_Id',$this->Log_Id);
		$criteria->compare('Admin_Id',$this->Admin_Id);
		$criteria->compare('Admin_name',$this->Admin_name,true);
		$criteria->compare('Action',$this->Action,true);
		$criteria->compare('Content',$this->Content,true);
		$criteria->compare('Ip',$this->Ip,true);
		$criteria->compare('Datetime',$this->Datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}