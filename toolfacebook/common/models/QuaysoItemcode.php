<?php

/**
 * This is the model class for table "quayso_itemcode".
 *
 * The followings are the available columns in table 'quayso_itemcode':
 * @property integer $id
 * @property integer $itemid
 * @property string $codeid
 * @property integer $del_flag
 */
class QuaysoItemcode extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return QuaysoItemcode the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'quayso_itemcode';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('del_flag', 'numerical', 'integerOnly' => true),
            array('codeid', 'length', 'max' => 20),
            array('itemid', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, itemid, codeid, del_flag', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'itemid' => 'Itemid',
            'codeid' => 'Codeid',
            'del_flag' => 'Del Flag',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('itemid', $this->itemid);
        $criteria->compare('codeid', $this->codeid, true);
        $criteria->compare('del_flag', $this->del_flag);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
