<?php

/**
 * This is the model class for table "session".
 *
 * The followings are the available columns in table 'session':
 * @property string $sessionhash
 * @property string $userid
 * @property string $host
 * @property string $idhash
 * @property string $lastactivity
 * @property string $location
 * @property string $useragent
 * @property integer $styleid
 * @property integer $languageid
 * @property integer $loggedin
 * @property integer $inforum
 * @property string $inthread
 * @property integer $incalendar
 * @property integer $badlocation
 * @property integer $bypass
 * @property integer $profileupdate
 * @property string $apiclientid
 * @property string $apiaccesstoken
 * @property integer $isbot
 */
class Session extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Session the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('styleid, languageid, loggedin, inforum, incalendar, badlocation, bypass, profileupdate, isbot', 'numerical', 'integerOnly'=>true),
			array('sessionhash, idhash, apiaccesstoken', 'length', 'max'=>32),
			array('userid, lastactivity, inthread, apiclientid', 'length', 'max'=>10),
			array('host', 'length', 'max'=>15),
			array('location', 'length', 'max'=>255),
			array('useragent', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sessionhash, userid, host, idhash, lastactivity, location, useragent, styleid, languageid, loggedin, inforum, inthread, incalendar, badlocation, bypass, profileupdate, apiclientid, apiaccesstoken, isbot', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sessionhash' => 'Sessionhash',
			'userid' => 'Userid',
			'host' => 'Host',
			'idhash' => 'Idhash',
			'lastactivity' => 'Lastactivity',
			'location' => 'Location',
			'useragent' => 'Useragent',
			'styleid' => 'Styleid',
			'languageid' => 'Languageid',
			'loggedin' => 'Loggedin',
			'inforum' => 'Inforum',
			'inthread' => 'Inthread',
			'incalendar' => 'Incalendar',
			'badlocation' => 'Badlocation',
			'bypass' => 'Bypass',
			'profileupdate' => 'Profileupdate',
			'apiclientid' => 'Apiclientid',
			'apiaccesstoken' => 'Apiaccesstoken',
			'isbot' => 'Isbot',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sessionhash',$this->sessionhash,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('host',$this->host,true);
		$criteria->compare('idhash',$this->idhash,true);
		$criteria->compare('lastactivity',$this->lastactivity,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('useragent',$this->useragent,true);
		$criteria->compare('styleid',$this->styleid);
		$criteria->compare('languageid',$this->languageid);
		$criteria->compare('loggedin',$this->loggedin);
		$criteria->compare('inforum',$this->inforum);
		$criteria->compare('inthread',$this->inthread,true);
		$criteria->compare('incalendar',$this->incalendar);
		$criteria->compare('badlocation',$this->badlocation);
		$criteria->compare('bypass',$this->bypass);
		$criteria->compare('profileupdate',$this->profileupdate);
		$criteria->compare('apiclientid',$this->apiclientid,true);
		$criteria->compare('apiaccesstoken',$this->apiaccesstoken,true);
		$criteria->compare('isbot',$this->isbot);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}