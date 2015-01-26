<?php

/**
 * This is the model class for table "giftcode_input".
 *
 * The followings are the available columns in table 'giftcode_input':
 * @property string $code
 * @property string $itemid
 * @property integer $status
 * @property integer $del_flg
 * @property string $createdate
 * @property string $key_code
 */
class GiftcodeInput extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'giftcode_input';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, itemid,key_code', 'required'),
			array('status, del_flg', 'numerical', 'integerOnly'=>true),
			array('code,key_code', 'length', 'max'=>100),
			array('itemid', 'length', 'max'=>255),
            array('code','unique'),
            array('del_flg','default','value'=>0),
            array('code','filter','filter'=>'trim'),
            array('createdate', 'default','value'=>new CDbExpression('now()')),
			array('createdate,key_code', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('code, itemid, status, del_flg, createdate,key_code', 'safe', 'on'=>'search'),
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
              'items'=>array(self::BELONGS_TO,'ItemGiftcodeInput','itemid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'code' => 'Code',
			'itemid' => 'Itemid',
			'status' => 'Status',
			'del_flg' => 'Del Flg',
			'createdate' => 'Createdate',
            'key_code' =>'Key code'
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

		$criteria->compare('code',$this->code,true);
		$criteria->compare('itemid',$this->itemid,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('del_flg',$this->del_flg);
        $criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('key_code',$this->key_code);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>100
            )
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GiftcodeInput the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
