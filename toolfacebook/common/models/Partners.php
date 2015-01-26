<?php

/**
 * This is the model class for table "partners".
 *
 * The followings are the available columns in table 'partners':
 * @property integer $partner_id
 * @property string $partner_name
 * @property string $partner_pkey
 * @property string $createdate
 * @property string url
 * @property integer status
 * @property integer del_flg
 * @property string email
 * @property string address
 * @property string phone
 */
class Partners extends CActiveRecord
{
    public $userid;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Partners the static model class
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
		return 'partners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('partner_name,status,partner_pkey', 'required'),
			array('partner_name', 'length', 'max'=>255),
			array('partner_pkey', 'length', 'max'=>10),
            array('partner_pkey','unique'),
            array('email', 'length', 'max'=>50),
            array('phone', 'length', 'max'=>50),
            array('address', 'length', 'max'=>255),
            array('createdate','default','value'=>new CDbExpression('NOW()')),
            array('partner_pkey','unique'),            
            array('del_flg','default','value'=>0),
            array('status','default','value'=>1),
			array('createdate,email,address,phone,partner_pkey', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('partner_id, partner_name, partner_pkey, createdate,status,url,del_flg,email,address,phone', 'safe', 'on'=>'search'),
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
			'partner_id' => 'Partner',
			'partner_name' => 'Partner Name',
			'partner_pkey' => 'Partner Pkey',
			'createdate' => 'Createdate',
            'url'=>'Url',
            'status'=>'Status',
            'email'=>'Email',
            'address'=>'Địa Chỉ',
            'phone'=>'Số Điện Thoại'
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

		$criteria->compare('partner_id',$this->partner_id);
		$criteria->compare('partner_name',$this->partner_name,true);
		$criteria->compare('partner_pkey',$this->partner_pkey);
		$criteria->compare('createdate',$this->createdate,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('del_flg',0);
        $criteria->compare('email',$this->email);
        $criteria->compare('address',$this->address);
        $criteria->compare('phone',$this->phone);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}