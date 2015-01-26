<?php

/**
 * This is the model class for table "player".
 *
 * The followings are the available columns in table 'player':
 * @property string $playerId
 * @property integer $adult
 * @property string $bindSilver
 * @property integer $branching
 * @property integer $camp
 * @property string $capacity
 * @property integer $continueDays
 * @property integer $continueMaxDays
 * @property string $coupon
 * @property string $createTime
 * @property integer $deletable
 * @property string $deleteTime
 * @property integer $exploit
 * @property integer $fashionShow
 * @property string $forbidChat
 * @property string $forbidLogin
 * @property string $golden
 * @property string $guide
 * @property integer $icon
 * @property integer $loginCount
 * @property integer $loginDays
 * @property string $loginTime
 * @property string $logoutTime
 * @property integer $maxBackSize
 * @property integer $maxPetSlotSize
 * @property integer $maxStoreSize
 * @property integer $monsterSoul
 * @property string $name
 * @property string $onlineTimes
 * @property string $password
 * @property integer $petexperience
 * @property string $platform
 * @property string $prestige
 * @property string $receiveInfo
 * @property integer $role
 * @property string $serverId
 * @property integer $sex
 * @property string $silver
 * @property string $superGreetCount
 * @property integer $title
 * @property string $userName
 * @property string $via
 * @property integer $weaponShow
 */
class Player extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Player the static model class
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
		return 'player';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bindSilver, branching, continueDays, continueMaxDays, coupon, deletable, exploit, golden, icon, loginCount, loginDays, maxBackSize, maxPetSlotSize, maxStoreSize, monsterSoul, onlineTimes, petexperience, prestige, role, silver, superGreetCount, title', 'required'),
			array('adult, branching, camp, continueDays, continueMaxDays, deletable, exploit, fashionShow, icon, loginCount, loginDays, maxBackSize, maxPetSlotSize, maxStoreSize, monsterSoul, petexperience, role, sex, title, weaponShow', 'numerical', 'integerOnly'=>true),
			array('playerId, bindSilver, coupon, golden, onlineTimes, prestige, silver, superGreetCount', 'length', 'max'=>20),
			array('capacity, forbidChat, forbidLogin, name, password, platform, serverId, userName, via', 'length', 'max'=>255),
			array('createTime, deleteTime, guide, loginTime, logoutTime, receiveInfo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('playerId, adult, bindSilver, branching, camp, capacity, continueDays, continueMaxDays, coupon, createTime, deletable, deleteTime, exploit, fashionShow, forbidChat, forbidLogin, golden, guide, icon, loginCount, loginDays, loginTime, logoutTime, maxBackSize, maxPetSlotSize, maxStoreSize, monsterSoul, name, onlineTimes, password, petexperience, platform, prestige, receiveInfo, role, serverId, sex, silver, superGreetCount, title, userName, via, weaponShow', 'safe', 'on'=>'search'),
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
			'playerId' => 'Player',
			'adult' => 'Adult',
			'bindSilver' => 'Bind Silver',
			'branching' => 'Branching',
			'camp' => 'Camp',
			'capacity' => 'Capacity',
			'continueDays' => 'Continue Days',
			'continueMaxDays' => 'Continue Max Days',
			'coupon' => 'Coupon',
			'createTime' => 'Create Time',
			'deletable' => 'Deletable',
			'deleteTime' => 'Delete Time',
			'exploit' => 'Exploit',
			'fashionShow' => 'Fashion Show',
			'forbidChat' => 'Forbid Chat',
			'forbidLogin' => 'Forbid Login',
			'golden' => 'Golden',
			'guide' => 'Guide',
			'icon' => 'Icon',
			'loginCount' => 'Login Count',
			'loginDays' => 'Login Days',
			'loginTime' => 'Login Time',
			'logoutTime' => 'Logout Time',
			'maxBackSize' => 'Max Back Size',
			'maxPetSlotSize' => 'Max Pet Slot Size',
			'maxStoreSize' => 'Max Store Size',
			'monsterSoul' => 'Monster Soul',
			'name' => 'Name',
			'onlineTimes' => 'Online Times',
			'password' => 'Password',
			'petexperience' => 'Petexperience',
			'platform' => 'Platform',
			'prestige' => 'Prestige',
			'receiveInfo' => 'Receive Info',
			'role' => 'Role',
			'serverId' => 'Server',
			'sex' => 'Sex',
			'silver' => 'Silver',
			'superGreetCount' => 'Super Greet Count',
			'title' => 'Title',
			'userName' => 'User Name',
			'via' => 'Via',
			'weaponShow' => 'Weapon Show',
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

		$criteria->compare('playerId',$this->playerId,true);
		$criteria->compare('adult',$this->adult);
		$criteria->compare('bindSilver',$this->bindSilver,true);
		$criteria->compare('branching',$this->branching);
		$criteria->compare('camp',$this->camp);
		$criteria->compare('capacity',$this->capacity,true);
		$criteria->compare('continueDays',$this->continueDays);
		$criteria->compare('continueMaxDays',$this->continueMaxDays);
		$criteria->compare('coupon',$this->coupon,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('deletable',$this->deletable);
		$criteria->compare('deleteTime',$this->deleteTime,true);
		$criteria->compare('exploit',$this->exploit);
		$criteria->compare('fashionShow',$this->fashionShow);
		$criteria->compare('forbidChat',$this->forbidChat,true);
		$criteria->compare('forbidLogin',$this->forbidLogin,true);
		$criteria->compare('golden',$this->golden,true);
		$criteria->compare('guide',$this->guide,true);
		$criteria->compare('icon',$this->icon);
		$criteria->compare('loginCount',$this->loginCount);
		$criteria->compare('loginDays',$this->loginDays);
		$criteria->compare('loginTime',$this->loginTime,true);
		$criteria->compare('logoutTime',$this->logoutTime,true);
		$criteria->compare('maxBackSize',$this->maxBackSize);
		$criteria->compare('maxPetSlotSize',$this->maxPetSlotSize);
		$criteria->compare('maxStoreSize',$this->maxStoreSize);
		$criteria->compare('monsterSoul',$this->monsterSoul);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('onlineTimes',$this->onlineTimes,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('petexperience',$this->petexperience);
		$criteria->compare('platform',$this->platform,true);
		$criteria->compare('prestige',$this->prestige,true);
		$criteria->compare('receiveInfo',$this->receiveInfo,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('serverId',$this->serverId,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('silver',$this->silver,true);
		$criteria->compare('superGreetCount',$this->superGreetCount,true);
		$criteria->compare('title',$this->title);
		$criteria->compare('userName',$this->userName,true);
		$criteria->compare('via',$this->via,true);
		$criteria->compare('weaponShow',$this->weaponShow);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}