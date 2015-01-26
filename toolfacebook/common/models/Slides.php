<?php

/**
 * This is the model class for table "slides".
 *
 * The followings are the available columns in table 'slides':
 * @property integer $slideId
 * @property string $slideUrl
 * @property string $Image
 */
class Slides extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Slides the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'slides';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('slideUrl, Image', 'length', 'max' => 500),
            array('slideUrl', 'required'),
            array('slideUrl', 'unique'),
            array('Image', 'required', 'on' => 'insert'),
            array('Image', 'file', 'types' => 'jpg, gif, png', 'on' => 'insert', 'allowEmpty' => false),
            array('Image', 'file', 'types' => 'jpg, gif, png', 'on' => 'update', 'allowEmpty' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('slideId, slideUrl, Image,DateCreate,Status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'slideId' => 'Slide',
            'slideUrl' => 'Slide Url',
            'Image' => 'Image',
            'DateCreate' => 'Ngày Tạo',
            'Status' => 'Trạng Thái'
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

        $criteria->compare('slideId', $this->slideId);
        $criteria->compare('slideUrl', $this->slideUrl, true);
        $criteria->compare('Image', $this->Image, true);
        $criteria->compare('DateCreate', $this->DateCreate, true);
        $criteria->compare('Status', $this->Status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
