<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property integer $image_id
 * @property string $title
 * @property string $url
 * @property integer $category_image_id
 */
class Images extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Images the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'images';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('url,title,category_image_id,avatar', 'required', 'on' => 'insert'),
            array('title', 'required', 'on' => 'update'),
            array('category_image_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 50),
            array('url', 'length', 'max' => 100),
            array('typemedia', 'in', 'range' => array('image', 'video')),
            array('avatar', 'file', 'types' => 'jpg, gif, png', 'on' => 'insert', 'allowEmpty' => false),
            array('avatar', 'file', 'types' => 'jpg, gif, png', 'on' => 'update', 'allowEmpty' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('image_id, title, url, category_image_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'albums' => array(self::BELONGS_TO, 'CategoryImage', 'category_image_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'image_id' => 'Image',
            'title' => 'Tiêu Đề',
            'url' => 'Đường Dẫn',
            'avatar' => 'Ảnh Đại Diện',
            'typemedia' => 'Media',
            'category_image_id' => 'Chủ Đề Albums',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('image_id', $this->image_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('avatar', $this->avatar, true);
        $criteria->compare('typemedia', $this->typemedia, true);
        $criteria->compare('category_image_id', $this->category_image_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
