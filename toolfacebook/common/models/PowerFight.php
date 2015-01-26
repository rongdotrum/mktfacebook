<?php

/**
 * This is the model class for table "power_fight".
 *
 * The followings are the available columns in table 'power_fight':
 * @property integer $powerId
 * @property integer $server_id
 * @property integer $power
 * @property string $character
 */
class PowerFight extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PowerFight the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'power_fight';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('server_id, power, character', 'required'),
            array('server_id, power', 'numerical', 'integerOnly' => true),
            array('character', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('powerId, server_id, power, character', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'servers' => array(self::BELONGS_TO, 'Servers', 'server_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'powerId' => 'Power',
            'server_id' => 'Server',
            'power' => 'Power',
            'character' => 'Character',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $server = Servers::model()->find();
        $criteria = new CDbCriteria;

        $criteria->compare('powerId', $this->powerId);
        $criteria->compare('server_id', $this->server_id);
        $criteria->compare('power', $this->power);
        $criteria->compare('character', $this->character, true);
        $criteria->limit = 10;
        if ($this->server_id == '') {
            $criteria->condition = 'server_id=:server_id';
            $criteria->params = array(':server_id' => $server['server_id']);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'power DESC',
            ),
            'pagination' => false
        ));
    }

}

