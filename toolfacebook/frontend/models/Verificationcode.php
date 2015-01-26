<?php

/**
 * This is the model class for table "verificationcode".
 *
 * The followings are the available columns in table 'verificationcode':
 * @property integer $verifyid
 * @property integer $userid
 * @property integer $active
 * @property string $verifycode
 * @property string $created
 * @property string $expires
 */
class Verificationcode extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Verificationcode the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'verificationcode';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userid, active, verifycode', 'required'),
            array('userid, active', 'numerical', 'integerOnly' => true),
            array('verifycode', 'length', 'max' => 50),
            array('created, expires', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('verifyid, userid, active, verifycode, created, expires', 'safe', 'on' => 'search'),
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
            'verifyid' => 'Verifyid',
            'userid' => 'Userid',
            'active' => 'Active',
            'verifycode' => 'Verifycode',
            'created' => 'Created',
            'expires' => 'Expires',
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

        $criteria->compare('verifyid', $this->verifyid);
        $criteria->compare('userid', $this->userid);
        $criteria->compare('active', $this->active);
        $criteria->compare('verifycode', $this->verifycode, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('expires', $this->expires, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
