<?php

/**
 * This is the model class for table "store_coupon".
 *
 * The followings are the available columns in table 'store_coupon':
 * @property string $id
 * @property string $code
 * @property integer $type_id
 * @property string $value
 * @property integer $used_id
 * @property string $time_issue
 * @property string $time_used
 * 
 * @property-read array $types 
 * @property-read string $type 0-summa, 1-percent
 * @property-read array $usedValues 
 * @property-read string $used 0-unused, 1-permanent, 2-used
 */
class Coupon extends CActiveRecord {

  private $types = array(0 => 'Сумма', 1 => 'Процент');
  private $used = array(0 => 'Неиспользован', 1 => 'Многоразовый'
    , 2 => 'Использован');

  const DAYS_BEFORE_REUSE_CODE = 180;
  const CODE_LEGTH = 6;

  public function getTypes() {
    return $this->types;
  }

  public function getType() {
    return $this->types[$this->type_id];
  }

  public function getUsedValues() {
    return $this->used;
  }

  public function getUsed() {
    return $this->used[$this->used_id];
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'store_coupon';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('code, type_id, value, used_id', 'required'),
      array('type_id, used_id', 'numerical', 'integerOnly' => true),
      array('code', 'length', 'max' => 8),
      array('value', 'length', 'max' => 5),
      array('code', 'notUsedCode'),
      array('value', 'validValue'),
      // The following rule is used by search().
      // @todo Please remove those attributes that should not be searched.
      array('id, code, type_id, value, used_id, time_issue, time_used', 'safe', 'on' => 'search'),
    );
  }

  public function notUsedCode($attribute) {
    if (strlen($this->$attribute) != self::CODE_LEGTH)
      $this->addError($attribute, 'Код должен быть ' . self::CODE_LEGTH . ' символов');

    $exclude_codes = $this->getExcludeCodes();
    if (in_array($this->code, $exclude_codes))
      $this->addError($attribute, 'Код ' . $this->code . ' используется');
  }

  public function validValue($attribute) {
    if ($this->type_id == 1 && $this->value > 100)
      $this->addError($attribute, 'Скидка не может быть больше 100%');
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
      'code' => 'Код',
      'type_id' => 'Тип',
      'value' => 'Скидка',
      'used_id' => 'Статус',
      'time_issue' => 'Время создания',
      'time_used' => 'Время использования',
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
    $criteria->compare('code', $this->code, true);
    $criteria->compare('type_id', $this->type_id);
    $criteria->compare('value', $this->value, true);
    $criteria->compare('used_id', $this->used_id);
    $criteria->compare('time_issue', $this->time_issue, true);
    $criteria->compare('time_used', $this->time_used, true);

    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
    ));
  }

  /**
   * Returns the static model of the specified AR class.
   * Please note that you should have this exact method in all your CActiveRecord descendants!
   * @param string $className active record class name.
   * @return Coupon the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  public function generateCode() {

    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    $exclude_codes_array = $this->getExcludeCodes();

    $code = "";
    while (empty($code)) {
      for ($i = 0; $i < self::CODE_LEGTH; $i++) {
        $code .= $characters[mt_rand(0, strlen($characters) - 1)];
      }
      if (in_array($code, $exclude_codes_array))
        $code = '';
    }
    $this->code = $code;
  }

  private function getExcludeCodes() {

    function formatArray($element) {
      return $element['code'];
    }

    $date = date('Y-m-d', strtotime('-' . self::DAYS_BEFORE_REUSE_CODE . ' day'));

    $sql = array(
      'select' => array('code'),
      'from' => $this->tableName(),
    );
    if ($this->isNewRecord) {
      $sql['where'] = 'used_id<>2 OR (used_id=2 AND time_used<:date)';
      $sql['params'] = array(':date' => $date);
    }
    else {
      $sql['where'] = '(used_id<>2 OR (used_id=2 AND time_used<:date)) and id<>:id';
      $sql['params'] = array(':date' => $date, ':id' => $this->id);
    }
    $command = Yii::app()->db->createCommand($sql);
    $result = $command->queryAll();
    if (is_array($result))
      $exclude_codes = array_map('formatArray', $result);
    else
      $exclude_codes = array();
    return $exclude_codes;
  }

  public function afterFind() {
    $date = Yii::app()->dateFormatter->formatDateTime($this->time_issue);
    $this->time_issue = $date;

    if ($this->time_used == '0000-00-00 00:00:00')
      $date = '';
    else
      $date = Yii::app()->dateFormatter->formatDateTime($this->time_used);
    $this->time_used = $date;

    parent::afterFind();
    return TRUE;
  }

  public function beforeSave() {
    $date = Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm:ss', $this->time_issue);
    $this->time_issue = $date;

    if (!empty($this->time_used)) {
      $date = Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm:ss', $this->time_used);
      $this->time_used = $date;
    }

    parent::beforeSave();
    return TRUE;
  }

}
