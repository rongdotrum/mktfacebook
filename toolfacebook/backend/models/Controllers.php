<?php

/**
 * This is the model class for table "controllers".
 *
 * The followings are the available columns in table 'controllers':
 * @property integer $controller_id
 * @property string $controller_name
 * @property string $description
 * @property integer $parent
 * @property string $url
 * @property integer $special
 */
class Controllers extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Controllers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'controllers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('parent, special', 'numerical', 'integerOnly' => true),
            array('description', 'required'),
            array('url', 'default', 'value' => '#'),
            array('controller_name', 'default', 'value' => '#'),
            array('parent', 'default', 'value' => 0),
            //array('parent','in','range'=>$this->model()->findAll('')))
            array('controller_name, url', 'length', 'max' => 50),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('controller_id, controller_name, description, parent, url, special', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'parents' => array(self::BELONGS_TO, 'Controllers', 'parent'),
            'childs' => array(self::HAS_MANY, 'Controllers', 'parent')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'controller_id' => 'Controller',
            'controller_name' => 'Tên Controller',
            'description' => 'Tên Hiển Thị Menu',
            'parent' => 'Thuộc Menu',
            'url' => 'Tên Modules',
            'special' => 'Hiển Thị',
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

        $criteria->compare('controller_id', $this->controller_id);
        $criteria->compare('controller_name', $this->controller_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('parent', $this->parent);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('special', $this->special);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
