<?php

/**
 * This is the model class for table "golden_config".
 *
 * The followings are the available columns in table 'golden_config':
 * @property string $ID
 * @property integer $Cash
 * @property integer $Gold
 * @property double $Rate
 * @property integer $Status
 * @property string $CreatedDate
 */
class GoldenConfig extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return GoldenConfig the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'golden_config';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Cash, Gold, Rate, Status', 'required'),
            array('Cash, Gold, Status', 'numerical', 'integerOnly' => true),
            array('Status', 'in', 'range' => array(0, 1)),
            array('CreatedDate', 'default', 'value' => date('Y-m-d H:i:s'), 'on' => 'insert'),
            array('Rate', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID, Cash, Gold, Rate, Status, CreatedDate', 'safe', 'on' => 'search'),
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
            'ID' => 'ID',
            'Cash' => 'Cash',
            'Gold' => 'Gold',
            'Rate' => 'Rate',
            'Status' => 'Status',
            'CreatedDate' => 'Created Date',
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

        $criteria->compare('ID', $this->ID, true);
        $criteria->compare('Cash', $this->Cash);
        $criteria->compare('Gold', $this->Gold);
        $criteria->compare('Rate', $this->Rate);
        $criteria->compare('Status', $this->Status);
        $criteria->compare('CreatedDate', $this->CreatedDate, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
