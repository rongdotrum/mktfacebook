<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $userid
 * @property integer $usergroupid
 * @property string $membergroupids
 * @property integer $displaygroupid
 * @property string $username
 * @property string $password
 * @property string $passworddate
 * @property string $email
 * @property integer $styleid
 * @property string $parentemail
 * @property string $homepage
 * @property string $icq
 * @property string $aim
 * @property string $yahoo
 * @property string $msn
 * @property string $skype
 * @property integer $showvbcode
 * @property integer $showbirthday
 * @property string $usertitle
 * @property integer $customtitle
 * @property string $joindate
 * @property integer $daysprune
 * @property string $lastvisit
 * @property string $lastactivity
 * @property string $lastpost
 * @property string $lastpostid
 * @property string $posts
 * @property integer $reputation
 * @property string $reputationlevelid
 * @property string $timezoneoffset
 * @property integer $pmpopup
 * @property integer $avatarid
 * @property string $avatarrevision
 * @property string $profilepicrevision
 * @property string $sigpicrevision
 * @property string $options
 * @property string $birthday
 * @property string $birthday_search
 * @property integer $maxposts
 * @property integer $startofweek
 * @property string $ipaddress
 * @property string $referrerid
 * @property integer $languageid
 * @property string $emailstamp
 * @property integer $threadedmode
 * @property integer $autosubscribe
 * @property integer $pmtotal
 * @property integer $pmunread
 * @property string $salt
 * @property string $ipoints
 * @property string $infractions
 * @property string $warnings
 * @property string $infractiongroupids
 * @property integer $infractiongroupid
 * @property string $adminoptions
 * @property string $profilevisits
 * @property string $friendcount
 * @property string $friendreqcount
 * @property string $vmunreadcount
 * @property string $vmmoderatedcount
 * @property string $socgroupinvitecount
 * @property string $socgroupreqcount
 * @property string $pcunreadcount
 * @property string $pcmoderatedcount
 * @property string $gmmoderatedcount
 * @property string $assetposthash
 * @property string $fbuserid
 * @property string $fbjoindate
 * @property string $fbname
 * @property string $logintype
 * @property string $fbaccesstoken
 * @property integer $newrepcount
 * @property string $bloggroupreqcount
 * @property integer $showblogcss
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usergroupid, displaygroupid, styleid, showvbcode, showbirthday, customtitle, daysprune, reputation, pmpopup, avatarid, maxposts, startofweek, languageid, threadedmode, autosubscribe, pmtotal, pmunread, infractiongroupid, newrepcount, showblogcss', 'numerical', 'integerOnly'=>true),
			array('userid, joindate, lastvisit, lastactivity, lastpost, lastpostid, posts, reputationlevelid, avatarrevision, profilepicrevision, sigpicrevision, options, birthday, referrerid, emailstamp, ipoints, infractions, warnings, adminoptions, profilevisits, friendcount, friendreqcount, vmunreadcount, vmmoderatedcount, socgroupinvitecount, socgroupreqcount, pcunreadcount, pcmoderatedcount, gmmoderatedcount, fbjoindate, bloggroupreqcount', 'length', 'max'=>10),
			array('membergroupids, usertitle', 'length', 'max'=>250),
			array('username, email, homepage, msn', 'length', 'max'=>100),
			array('password, yahoo, skype, assetposthash', 'length', 'max'=>32),
			array('parentemail', 'length', 'max'=>50),
			array('icq, aim', 'length', 'max'=>20),
			array('timezoneoffset', 'length', 'max'=>4),
			array('ipaddress', 'length', 'max'=>15),
			array('salt', 'length', 'max'=>30),
			array('infractiongroupids, fbuserid, fbname, fbaccesstoken', 'length', 'max'=>255),
			array('logintype', 'length', 'max'=>2),
			array('passworddate, birthday_search', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userid, usergroupid, membergroupids, displaygroupid, username, password, passworddate, email, styleid, parentemail, homepage, icq, aim, yahoo, msn, skype, showvbcode, showbirthday, usertitle, customtitle, joindate, daysprune, lastvisit, lastactivity, lastpost, lastpostid, posts, reputation, reputationlevelid, timezoneoffset, pmpopup, avatarid, avatarrevision, profilepicrevision, sigpicrevision, options, birthday, birthday_search, maxposts, startofweek, ipaddress, referrerid, languageid, emailstamp, threadedmode, autosubscribe, pmtotal, pmunread, salt, ipoints, infractions, warnings, infractiongroupids, infractiongroupid, adminoptions, profilevisits, friendcount, friendreqcount, vmunreadcount, vmmoderatedcount, socgroupinvitecount, socgroupreqcount, pcunreadcount, pcmoderatedcount, gmmoderatedcount, assetposthash, fbuserid, fbjoindate, fbname, logintype, fbaccesstoken, newrepcount, bloggroupreqcount, showblogcss', 'safe', 'on'=>'search'),
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
			'userid' => 'Userid',
			'usergroupid' => 'Usergroupid',
			'membergroupids' => 'Membergroupids',
			'displaygroupid' => 'Displaygroupid',
			'username' => 'Username',
			'password' => 'Password',
			'passworddate' => 'Passworddate',
			'email' => 'Email',
			'styleid' => 'Styleid',
			'parentemail' => 'Parentemail',
			'homepage' => 'Homepage',
			'icq' => 'Icq',
			'aim' => 'Aim',
			'yahoo' => 'Yahoo',
			'msn' => 'Msn',
			'skype' => 'Skype',
			'showvbcode' => 'Showvbcode',
			'showbirthday' => 'Showbirthday',
			'usertitle' => 'Usertitle',
			'customtitle' => 'Customtitle',
			'joindate' => 'Joindate',
			'daysprune' => 'Daysprune',
			'lastvisit' => 'Lastvisit',
			'lastactivity' => 'Lastactivity',
			'lastpost' => 'Lastpost',
			'lastpostid' => 'Lastpostid',
			'posts' => 'Posts',
			'reputation' => 'Reputation',
			'reputationlevelid' => 'Reputationlevelid',
			'timezoneoffset' => 'Timezoneoffset',
			'pmpopup' => 'Pmpopup',
			'avatarid' => 'Avatarid',
			'avatarrevision' => 'Avatarrevision',
			'profilepicrevision' => 'Profilepicrevision',
			'sigpicrevision' => 'Sigpicrevision',
			'options' => 'Options',
			'birthday' => 'Birthday',
			'birthday_search' => 'Birthday Search',
			'maxposts' => 'Maxposts',
			'startofweek' => 'Startofweek',
			'ipaddress' => 'Ipaddress',
			'referrerid' => 'Referrerid',
			'languageid' => 'Languageid',
			'emailstamp' => 'Emailstamp',
			'threadedmode' => 'Threadedmode',
			'autosubscribe' => 'Autosubscribe',
			'pmtotal' => 'Pmtotal',
			'pmunread' => 'Pmunread',
			'salt' => 'Salt',
			'ipoints' => 'Ipoints',
			'infractions' => 'Infractions',
			'warnings' => 'Warnings',
			'infractiongroupids' => 'Infractiongroupids',
			'infractiongroupid' => 'Infractiongroupid',
			'adminoptions' => 'Adminoptions',
			'profilevisits' => 'Profilevisits',
			'friendcount' => 'Friendcount',
			'friendreqcount' => 'Friendreqcount',
			'vmunreadcount' => 'Vmunreadcount',
			'vmmoderatedcount' => 'Vmmoderatedcount',
			'socgroupinvitecount' => 'Socgroupinvitecount',
			'socgroupreqcount' => 'Socgroupreqcount',
			'pcunreadcount' => 'Pcunreadcount',
			'pcmoderatedcount' => 'Pcmoderatedcount',
			'gmmoderatedcount' => 'Gmmoderatedcount',
			'assetposthash' => 'Assetposthash',
			'fbuserid' => 'Fbuserid',
			'fbjoindate' => 'Fbjoindate',
			'fbname' => 'Fbname',
			'logintype' => 'Logintype',
			'fbaccesstoken' => 'Fbaccesstoken',
			'newrepcount' => 'Newrepcount',
			'bloggroupreqcount' => 'Bloggroupreqcount',
			'showblogcss' => 'Showblogcss',
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

		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('usergroupid',$this->usergroupid);
		$criteria->compare('membergroupids',$this->membergroupids,true);
		$criteria->compare('displaygroupid',$this->displaygroupid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('passworddate',$this->passworddate,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('styleid',$this->styleid);
		$criteria->compare('parentemail',$this->parentemail,true);
		$criteria->compare('homepage',$this->homepage,true);
		$criteria->compare('icq',$this->icq,true);
		$criteria->compare('aim',$this->aim,true);
		$criteria->compare('yahoo',$this->yahoo,true);
		$criteria->compare('msn',$this->msn,true);
		$criteria->compare('skype',$this->skype,true);
		$criteria->compare('showvbcode',$this->showvbcode);
		$criteria->compare('showbirthday',$this->showbirthday);
		$criteria->compare('usertitle',$this->usertitle,true);
		$criteria->compare('customtitle',$this->customtitle);
		$criteria->compare('joindate',$this->joindate,true);
		$criteria->compare('daysprune',$this->daysprune);
		$criteria->compare('lastvisit',$this->lastvisit,true);
		$criteria->compare('lastactivity',$this->lastactivity,true);
		$criteria->compare('lastpost',$this->lastpost,true);
		$criteria->compare('lastpostid',$this->lastpostid,true);
		$criteria->compare('posts',$this->posts,true);
		$criteria->compare('reputation',$this->reputation);
		$criteria->compare('reputationlevelid',$this->reputationlevelid,true);
		$criteria->compare('timezoneoffset',$this->timezoneoffset,true);
		$criteria->compare('pmpopup',$this->pmpopup);
		$criteria->compare('avatarid',$this->avatarid);
		$criteria->compare('avatarrevision',$this->avatarrevision,true);
		$criteria->compare('profilepicrevision',$this->profilepicrevision,true);
		$criteria->compare('sigpicrevision',$this->sigpicrevision,true);
		$criteria->compare('options',$this->options,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('birthday_search',$this->birthday_search,true);
		$criteria->compare('maxposts',$this->maxposts);
		$criteria->compare('startofweek',$this->startofweek);
		$criteria->compare('ipaddress',$this->ipaddress,true);
		$criteria->compare('referrerid',$this->referrerid,true);
		$criteria->compare('languageid',$this->languageid);
		$criteria->compare('emailstamp',$this->emailstamp,true);
		$criteria->compare('threadedmode',$this->threadedmode);
		$criteria->compare('autosubscribe',$this->autosubscribe);
		$criteria->compare('pmtotal',$this->pmtotal);
		$criteria->compare('pmunread',$this->pmunread);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('ipoints',$this->ipoints,true);
		$criteria->compare('infractions',$this->infractions,true);
		$criteria->compare('warnings',$this->warnings,true);
		$criteria->compare('infractiongroupids',$this->infractiongroupids,true);
		$criteria->compare('infractiongroupid',$this->infractiongroupid);
		$criteria->compare('adminoptions',$this->adminoptions,true);
		$criteria->compare('profilevisits',$this->profilevisits,true);
		$criteria->compare('friendcount',$this->friendcount,true);
		$criteria->compare('friendreqcount',$this->friendreqcount,true);
		$criteria->compare('vmunreadcount',$this->vmunreadcount,true);
		$criteria->compare('vmmoderatedcount',$this->vmmoderatedcount,true);
		$criteria->compare('socgroupinvitecount',$this->socgroupinvitecount,true);
		$criteria->compare('socgroupreqcount',$this->socgroupreqcount,true);
		$criteria->compare('pcunreadcount',$this->pcunreadcount,true);
		$criteria->compare('pcmoderatedcount',$this->pcmoderatedcount,true);
		$criteria->compare('gmmoderatedcount',$this->gmmoderatedcount,true);
		$criteria->compare('assetposthash',$this->assetposthash,true);
		$criteria->compare('fbuserid',$this->fbuserid,true);
		$criteria->compare('fbjoindate',$this->fbjoindate,true);
		$criteria->compare('fbname',$this->fbname,true);
		$criteria->compare('logintype',$this->logintype,true);
		$criteria->compare('fbaccesstoken',$this->fbaccesstoken,true);
		$criteria->compare('newrepcount',$this->newrepcount);
		$criteria->compare('bloggroupreqcount',$this->bloggroupreqcount,true);
		$criteria->compare('showblogcss',$this->showblogcss);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}