<?php

/**
 * This is the model class for table "user_request_card".
 *
 * The followings are the available columns in table 'user_request_card':
 * @property string $request_id
 * @property string $user_id
 * @property string $card_type
 * @property string $serial
 * @property string $pin
 * @property integer $cost
 * @property string $transaction_id
 * @property string $error_code
 * @property string $error_message
 * @property string $client_id
 * @property integer $game_id
 * @property string $request_date
 * @property string $server
 * @property integer $gold
 */
class UserRequestCard extends CActiveRecord
{
    public $startdate;
    public $enddate;
    public $display_name;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_request_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, card_type, serial, pin, client_id', 'required'),
			array('cost, game_id, gold', 'numerical', 'integerOnly'=>true),
			array('user_id, serial, pin, client_id, server', 'length', 'max'=>20),
			array('card_type, error_code', 'length', 'max'=>5),
			array('transaction_id', 'length', 'max'=>50),
			array('error_message, request_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('request_id, user_id, card_type, serial, pin, cost, transaction_id, error_code, error_message, client_id, game_id, request_date, server, gold', 'safe', 'on'=>'search'),
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
            'servers'=>array(self::BELONGS_TO,'Servers','server'),
            'users'=>array(self::BELONGS_TO,'Users','user_id'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'request_id' => 'Request',
			'user_id' => 'User',
			'card_type' => 'Card Type',
			'serial' => 'Serial',
			'pin' => 'Pin',
			'cost' => 'Cost',
			'transaction_id' => 'Transaction',
			'error_code' => 'Error Code',
			'error_message' => 'Error Message',
			'client_id' => 'Client',
			'game_id' => 'Game',
			'request_date' => 'Request Date',
			'server' => 'Server',
			'gold' => 'Gold',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        
        $criteria->with = array('users');
        
		$criteria->compare('request_id',$this->request_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('card_type',$this->card_type,true);
		$criteria->compare('serial',$this->serial,true);
		$criteria->compare('pin',$this->pin,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('error_code',$this->error_code);
		$criteria->compare('error_message',$this->error_message,true);
		$criteria->compare('client_id',$this->client_id,true);
		$criteria->compare('game_id',$this->game_id);
		$criteria->compare('request_date',$this->request_date,true);
		$criteria->compare('server',$this->server,true);
		$criteria->compare('gold',$this->gold);
        
        $criteria->compare('users.display_name',$this->display_name,true);       

		if (isset($this->startdate) && isset($this->enddate))
            $criteria->addBetweenCondition('date(request_date)',$this->startdate,$this->enddate);    
        elseif (isset($this->startdate))
        {
            $criteria->addCondition('date(request_date) >= :pstartdate');
            $criteria->params = CMap::mergeArray($criteria->params,array('pstartdate'=>$this->startdate));
        }
        elseif (isset($this->enddate))
        {                           
            $criteria->addCondition('date(request_date) <= :penddate');
            $criteria->params = CMap::mergeArray($criteria->params,array('penddate'=>$this->enddate));
        }        
                     
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'request_date DESC',
            ),
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserRequestCard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
