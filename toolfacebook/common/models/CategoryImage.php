<?php

/**
 * This is the model class for table "category_image".
 *
 * The followings are the available columns in table 'category_image':
 * @property integer $category_image_id
 * @property string $category_name
 * @property string $created_date
 * @property string $updated_date
 * @property integer $slide
 */
class CategoryImage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CategoryImage the static model class
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
		return 'category_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('slide', 'numerical', 'integerOnly'=>true),
			array('category_name', 'length', 'max'=>50),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('category_image_id, category_name, created_date, updated_date, slide', 'safe', 'on'=>'search'),
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
			'category_image_id' => 'Category Image',
			'category_name' => 'Category Name',
			'created_date' => 'Created Date',
			'updated_date' => 'Updated Date',
			'slide' => 'Slide',
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

		$criteria->compare('category_image_id',$this->category_image_id);
		$criteria->compare('category_name',$this->category_name,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('slide',$this->slide);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}