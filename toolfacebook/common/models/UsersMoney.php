<?php

/**
 * This is the model class for table "users_money".
 *
 * The followings are the available columns in table 'users_money':
 * @property integer $user_id
 * @property double $current_money
 * @property double $sum_money
 * @property double $trans_money
 */
class UsersMoney extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsersMoney the static model class
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
		return 'users_money';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, current_money, sum_money, trans_money', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('current_money, sum_money, trans_money', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, current_money, sum_money, trans_money', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'current_money' => 'Current Money',
			'sum_money' => 'Sum Money',
			'trans_money' => 'Trans Money',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('current_money',$this->current_money);
		$criteria->compare('sum_money',$this->sum_money);
		$criteria->compare('trans_money',$this->trans_money);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}