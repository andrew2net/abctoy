<?php

/**
 * This is the model class for table "store_child".
 *
 * The followings are the available columns in table 'store_child':
 * @property string $id
 * @property string $profile_id
 * @property string $name
 * @property integer $gender_id
 * @property string $birthday
 *
 * The followings are the available model relations:
 * @property CustomerProfile $profile
 */
class Child extends CActiveRecord {

  private $genders = array('1' => 'Мальчик', '2' => 'Девочка');

  public function getGenders() {
    return $this->genders;
  }

  public function getGender() {
    return isset($this->genders[$this->gender_id]) ?
        $this->genders[$this->gender_id] : '';
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'store_child';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('profile_id, gender_id, birthday, name', 'required', 'on'=>'insert'),
      array('gender_id', 'numerical', 'integerOnly' => true),
      array('profile_id', 'length', 'max' => 11, 'on'=>'insert'),
      array('name', 'length', 'max' => 30, 'on'=>'insert'),
      array('birthday', 'safe', 'on'=>'insert'),
      array('birthday, name', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
      // The following rule is used by search().
      // @todo Please remove those attributes that should not be searched.
      array('id, profile_id, name, gender_id, birthday', 'safe', 'on' => 'search'),
      array('name, gender_id, birthday', 'required', 'on' => 'popup'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'profile' => array(self::BELONGS_TO, 'CustomerProfile', 'profile_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id' => 'ID',
      'profile_id' => 'Profile',
      'name' => 'Имя',
      'gender_id' => 'Пол ребенка',
      'birthday' => 'День рождения',
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
  public function search() {
    // @todo Please modify the following code to remove attributes that should not be searched.

    $criteria = new CDbCriteria;

    $criteria->compare('id', $this->id, true);
    $criteria->compare('profile_id', $this->profile_id, true);
    $criteria->compare('name', $this->name, true);
    $criteria->compare('gender_id', $this->gender_id);
    $criteria->compare('birthday', $this->birthday, true);

    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
    ));
  }

  public function userChildren() {
    $this->getDbCriteria()->mergeWith(array(
      'with' => array('profile'),
      'condition' => 'profile.user_id=:uid',
      'params' => array(':uid' => Yii::app()->user->id),
    ));
    return $this;
  }

  /**
   * Returns the static model of the specified AR class.
   * Please note that you should have this exact method in all your CActiveRecord descendants!
   * @param string $className active record class name.
   * @return Child the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  public function afterFind() {

    $this->birthday = Yii::app()->dateFormatter->format('dd.MM.yyyy', $this->birthday);
    parent::afterFind();
  }

  public function beforeSave() {
    $this->birthday = Yii::app()->dateFormatter->format('yyyy-MM-dd', $this->birthday);
    return parent::beforeSave();
  }

  public function getSelectParams() {
    $childs = self::model()->userChildren()->findAll();
    $genders = array();
    $ages = array();
    $now = new DateTime;
    foreach ($childs as $child) {
      $genders[] = $child->gender_id;
      $age = DateTime::createFromFormat('d.m.Y', $child->birthday)->diff($now)->y;
      $ages[] = $age;
    }
    $params = array();
    if (count($ages) > 0) {
      $params['ageFrom'] = min($ages) < 10 ? min($ages) : 10;
      $params['ageTo'] = max($ages) < 10 ? max($ages) : 10;
    }
    if (count($genders) > 0 && min($genders) == max($genders))
      $params['gender'] = min($genders);
    else
      $params['gender'] = 0;
    return $params;
  }

}
