<?php

/**
 * This is the model class for table "popups".
 *
 * The followings are the available columns in table 'popups':
 * @property integer $popupId
 * @property string $Image
 * @property string $url
 * @property integer $status
 * @property string $date
 */
class Popups extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Popups the static model class
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
		return 'popups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>255),
            array('Image', 'file', 'types' => 'jpg, gif, png', 'on' => 'insert', 'allowEmpty' => false),        
            array('Image', 'file', 'types' => 'jpg, gif, png', 'on' => 'update', 'allowEmpty' => true),        
            array('date','default','value'=>new CDbExpression('Now()')),
            array('url','url'),
			array('date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('popupId, Image, url, status, date', 'safe', 'on'=>'search'),
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
			'popupId' => 'Popup',
			'Image' => 'File Ảnh',
			'url' => 'Link',
			'status' => 'Trạng Thái',
			'date' => 'Ngày Tạo',
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

		$criteria->compare('popupId',$this->popupId);
		$criteria->compare('Image',$this->Image,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function afterSave()
    {
            parent::afterSave();
            if ($this->status == 1)
            {
                $sql = 'update popups set status = 0 where popupid != :p_id';
                app()->db->createCommand($sql)->execute(array(':p_id'=>$this->popupId));
            }
    }
    
    
}