<?php

/**
 * This is the model class for table "store_payment".
 *
 * The followings are the available columns in table 'store_payment':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $mnt_id
 * @property string $mnt_signature
 * @property string $type_id
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Payment extends CActiveRecord {

  private $types = array(0 => 'Наличными', 1 => 'Монета');

  public function getTypes() {
    return $this->types;
  }

  public function getType() {
    return $this->types[$this->type_id];
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'store_payment';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('name, description, type_id','required'),
      array('type_id', 'numerical', 'integerOnly' => true),
      array('name', 'length', 'max' => 255),
      array('mnt_id, mnt_signature', 'safe'),
      // The following rule is used by search().
      // @todo Please remove those attributes that should not be searched.
      array('id, name, description', 'safe', 'on' => 'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'orders' => array(self::HAS_MANY, 'Order', 'payment_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id' => 'ID',
      'name' => 'Наименование',
      'description' => 'Описание',
      'mnt_id' => 'Номер счета',
      'mnt_signature' => 'Код проверки целостности данных',
      'type' => 'Платежная система',
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
    $criteria->compare('name', $this->name, true);
    $criteria->compare('description', $this->description, true);

    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
    ));
  }

  /**
   * Returns the static model of the specified AR class.
   * Please note that you should have this exact method in all your CActiveRecord descendants!
   * @param string $className active record class name.
   * @return Payment the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  public static function getPaymentList() {
    $models = self::model()->findAll();
    $list = array();
    foreach ($models as $payment) {
      $output = CHtml::tag('div', array('class' => 'payment' . $payment->id));
      $output .= CHtml::closeTag('div');
      $output .= CHtml::tag('div', array('style' => 'display:inline-block;width:320px'));
      $output .= CHtml::tag('div', array(
            'class' => 'bold',
            'style' => 'margin-bottom:5px',
              ), $payment->name);
      $output .= ' (' . $payment->description . ') ';
      $output .= CHtml::closeTag('div');
      $list[$payment->id] = $output;
    }
    return $list;
  }

}
