<?php

/**
 * This is the model class for table "admin_user".
 *
 * The followings are the available columns in table 'admin_user':
 * @property string $id
 * @property string $login_name
 * @property string $login_password
 * @property string $role
 * @property string $email
 * @property string $del_flg
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 */
class AdminUser extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AdminUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'admin_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('login_name, login_password', 'required', 'on' => 'insert'),
            array('login_name', 'required', 'on' => 'update'),
            array('login_name', 'length', 'max' => 50),
            array('login_name,email', 'unique'),
            array('login_password', 'length', 'max' => 255),
            array('role, del_flg, created_by, updated_by', 'length', 'max' => 10),
            array('email', 'length', 'max' => 45),
            array('email', 'email'),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, login_name, login_password, role, email, del_flg, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
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
            'login_name' => 'Tên Đăng Nhập',
            'login_password' => 'Mật Khẩu',
            'role' => 'Role',
            'email' => 'Email',
            'del_flg' => 'Del Flg',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('login_name', $this->login_name, true);
        $criteria->compare('login_password', $this->login_password, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('del_flg', $this->del_flg, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_date = new CDbExpression('NOW()');
            $this->created_by = app()->user->getName();
        } else {
            $this->updated_date = new CDbExpression('NOW()');
            $this->updated_by = app()->user->getName();
        }
        return parent::beforeSave();
    }

}
