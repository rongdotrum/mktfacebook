<?php

/**
* This is the model class for table "users".
*
* The followings are the available columns in table 'users':
* @property integer $user_id
* @property string $display_name
* @property string $password
* @property string $email
* @property integer $activate_status
* @property integer $del_flg
* @property string $salt
* @property string $activate_key
* @property string $enc_type
* @property integer $userforum_id
* @property string $registerdate
* @property string $usersource
* @property string $social_name
* @property integer $partner_id
* @property string $partner_key_url
*/
class Users extends CActiveRecord
{
    /**
    * @return string the associated database table name
    */
    public function tableName()
    {
        return 'users';
    }

    /**
    * @return array validation rules for model attributes.
    */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
        array('display_name, password, email, activate_status', 'required'),
        array('activate_status, del_flg, userforum_id, partner_id', 'numerical', 'integerOnly'=>true),
        array('display_name, password, email, salt, activate_key', 'length', 'max'=>50),
        array('enc_type, partner_key_url', 'length', 'max'=>10),
        array('usersource, social_name', 'length', 'max'=>255),   
        array('registerdate', 'safe'),
        array('registerdate','default','value'=> new CDbExpression('NOW()')),
        array('email,display_name','unique'),
        // The following rule is used by search().
        // @todo Please remove those attributes that should not be searched.
        array('user_id, display_name, password, email, activate_status, del_flg, salt, activate_key, enc_type, userforum_id, registerdate, usersource, social_name, partner_id, partner_key_url', 'safe', 'on'=>'search'),
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
        'partners'=>array(self::BELONGS_TO,'Partners','partner_id')      
        );
    }

    /**
    * @return array customized attribute labels (name=>label)
    */
    public function attributeLabels()
    {
        return array(
        'user_id' => 'User',
        'display_name' => 'Display Name',
        'password' => 'Password',
        'email' => 'Email',
        'activate_status' => 'Activate Status',
        'del_flg' => 'Del Flg',
        'salt' => 'Salt',
        'activate_key' => 'Activate Key',
        'enc_type' => 'Enc Type',
        'userforum_id' => 'Userforum',
        'registerdate' => 'Registerdate',
        'usersource' => 'Usersource',
        'social_name' => 'Social Name',
        'partner_id' => 'Partner',
        'partner_key_url' => 'Partner Key Url',     
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

        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('display_name',$this->display_name,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activate_status',$this->activate_status);
        $criteria->compare('del_flg',$this->del_flg);
        $criteria->compare('salt',$this->salt,true);
        $criteria->compare('activate_key',$this->activate_key,true);
        $criteria->compare('enc_type',$this->enc_type,true);
        $criteria->compare('userforum_id',$this->userforum_id);
        $criteria->compare('registerdate',$this->registerdate,true);
        $criteria->compare('usersource',$this->usersource,true);
        $criteria->compare('social_name',$this->social_name,true);
        $criteria->compare('partner_id',$this->partner_id);
        $criteria->compare('partner_key_url',$this->partner_key_url,true);       

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                 'defaultOrder'=>'user_id DESC',
            ),
            'pagination'=>array(
                'pageSize'=>100
            ),
        ));

    }

    /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return Users the static model class
    */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    /**
    * Returns User model by its email
    * 
    * @param string $email 
    * @access public
    * @return User
    */
    public function findByEmail($email)
    {
        return self::model()->findByAttributes(array('email' => $email));
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {            
                if (isset(Yii::app()->session['pid']))
                {       
                    $this->partner_key_url = Yii::app()->session['pid'];                                    
                }                
            }
            return true;
        }
        return false;        
    }
}
