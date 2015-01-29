<?php

/**
 * This is the model class for table "quayso_item".
 *
 * The followings are the available columns in table 'quayso_item':
 * @property integer $itemid
 * @property string $itemname
 * @property integer $count
 * @property string $percent
 * @property string $codeingame
 * @property integer $typeitem
 * @property integer $limititem
 */
class QuaysoItem extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return QuaysoItem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'quayso_item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('count, typeitem, limititem,percent', 'numerical', 'integerOnly' => true),
            array('itemname', 'length', 'max' => 100),
            array('codeingame,image,image_hover', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('itemid, itemname, count, percent, codeingame, typeitem, limititem,image,image_hover', 'safe', 'on' => 'search'),
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
            'itemid' => 'Itemid',
            'itemname' => 'Itemname',
            'count' => 'Count',
            'percent' => 'Percent',
            'codeingame' => 'Codeingame',
            'typeitem' => 'Typeitem',
            'limititem' => 'Limititem',
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

        $criteria->compare('itemid', $this->itemid);
        $criteria->compare('itemname', $this->itemname, true);
        $criteria->compare('count', $this->count);
        $criteria->compare('percent', $this->percent, true);
        $criteria->compare('codeingame', $this->codeingame, true);
        $criteria->compare('typeitem', $this->typeitem);
        $criteria->compare('limititem', $this->limititem);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
