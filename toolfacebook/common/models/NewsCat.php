<?php

/**
 * This is the model class for table "news_cat".
 *
 * The followings are the available columns in table 'news_cat':
 * @property integer $CatId
 * @property string $CatName
 * @property string $CatAction
 * @property integer $Position
 * @property integer $Status
 */
class NewsCat extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return NewsCat the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'news_cat';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('CatName, CatAction', 'required'),
            array('Position, Status', 'numerical', 'integerOnly' => true),
            array('CatName, CatAction', 'length', 'max' => 100),
            array('Status', 'in', 'range' => array(1, 0), 'message' => '{attribute} Không Hợp Lệ'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('CatId, CatName, CatAction, Position, Status', 'safe', 'on' => 'search'),
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
            'CatId' => 'Cat',
            'CatName' => 'Thể Loại',
            'CatAction' => 'Tên Action',
            'Position' => 'Vị Trí',
            'Status' => 'Trạng Thái',
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

        $criteria->compare('CatId', $this->CatId);
        $criteria->compare('CatName', $this->CatName, true);
        $criteria->compare('CatAction', $this->CatAction, true);
        $criteria->compare('Position', $this->Position);
        $criteria->compare('Status', $this->Status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
