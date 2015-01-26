<?php

/**
 * This is the model class for table "usertextfield".
 *
 * The followings are the available columns in table 'usertextfield':
 * @property string $userid
 * @property string $subfolders
 * @property string $pmfolders
 * @property string $buddylist
 * @property string $ignorelist
 * @property string $signature
 * @property string $searchprefs
 * @property string $rank
 */
class Usertextfield extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usertextfield the static model class
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
		return 'usertextfield';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid', 'length', 'max'=>10),
			array('subfolders, pmfolders, buddylist, ignorelist, signature, searchprefs, rank', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userid, subfolders, pmfolders, buddylist, ignorelist, signature, searchprefs, rank', 'safe', 'on'=>'search'),
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
			'subfolders' => 'Subfolders',
			'pmfolders' => 'Pmfolders',
			'buddylist' => 'Buddylist',
			'ignorelist' => 'Ignorelist',
			'signature' => 'Signature',
			'searchprefs' => 'Searchprefs',
			'rank' => 'Rank',
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
		$criteria->compare('subfolders',$this->subfolders,true);
		$criteria->compare('pmfolders',$this->pmfolders,true);
		$criteria->compare('buddylist',$this->buddylist,true);
		$criteria->compare('ignorelist',$this->ignorelist,true);
		$criteria->compare('signature',$this->signature,true);
		$criteria->compare('searchprefs',$this->searchprefs,true);
		$criteria->compare('rank',$this->rank,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}