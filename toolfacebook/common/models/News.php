<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $NewsId
 * @property string $Title
 * @property string $TitleUrl
 * @property string $Content
 * @property integer $Status
 * @property string $DatePost
 * @property integer $CatId
 * @property string $Description
 * @property string $ThumbImage
 * @property string $From
 * @property string $To
 * @property string $Location
 * @property int $HotLink
 */
class News extends CActiveRecord {

    public $CatName;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return News the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Title, Content, Status, DatePost, CatId', 'required'),
            array('Status, CatId, HotLink', 'numerical', 'integerOnly' => true),
            array('Title, Location', 'length', 'max' => 512),
            array('Description', 'default', 'setOnEmpty' => true, 'value' => null),
            array('From,To', 'default', 'setOnEmpty' => true, 'value' => date('Y-m-d')),
            array('ThumbImage', 'file', 'types' => 'jpg, gif, png', 'on' => 'insert,update', 'allowEmpty' => true),
            array('Description, From, To', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('NewsId, Title, Content, Status, DatePost, CatId, Description, ThumbImage, From, To, Location,HotLink', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'newscat' => array(self::BELONGS_TO, 'NewsCat', 'CatId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'NewsId' => 'News',
            'Title' => 'Tiêu Đề',
            'Content' => 'Nội Dung',
            'Status' => 'Trạng Thái',
            'DatePost' => 'Ngày Đăng',
            'CatId' => 'Chủ Đề',
            'Description' => 'Miêu Tả',
            'ThumbImage' => 'Ảnh Đại Diện',
            'From' => 'From',
            'To' => 'To',
            'Location' => 'Địa Điểm',
            'HotLink' => 'Hot Link',
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
        $criteria->with = array('newscat');
        $criteria->compare('CatName', $this->CatName);
        $criteria->compare('NewsId', $this->NewsId);
        $criteria->compare('Title', $this->Title, true);
        $criteria->compare('Content', $this->Content, true);
        $criteria->compare('t.Status', $this->Status);
        $criteria->compare('DatePost', $this->DatePost, true);
        $criteria->compare('t.CatId', $this->CatId);
        $criteria->compare('Description', $this->Description, true);
        $criteria->compare('ThumbImage', $this->ThumbImage, true);
        $criteria->compare('From', $this->From, true);
        $criteria->compare('To', $this->To, true);
        $criteria->compare('Location', $this->Location, true);
        $criteria->compare('HotLink', $this->HotLink, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'DatePost DESC',
            )
        ));
    }
    
    public function afterFind() {
        $this->TitleUrl=  urlencode($this->TitleUrl);
        parent::afterFind();
    }
}
