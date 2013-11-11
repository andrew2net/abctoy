<?php

/**
 * This is the model class for table "store_action".
 *
 * The followings are the available columns in table 'store_action':
 * @property string $id
 * @property integer $type_id
 * @property string $name
 * @property string $text
 * @property string $date
 * @property string $img
 * @property string $product_id
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property int $type 
 * @property Int[] $types 
 */
class Action extends CActiveRecord {

  private $types = array(0 => 'Новость', 1 => 'Акция');

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
    return 'store_action';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
//      array('type_id', 'required'),
      array('type_id', 'numerical', 'integerOnly' => true),
      array('name', 'length', 'max' => 30),
      array('img', 'length', 'max' => 255),
      array('product_id', 'length', 'max' => 11),
      array('text, date', 'safe'),
      // The following rule is used by search().
      // @todo Please remove those attributes that should not be searched.
      array('id, type_id, name, text, date, img, product_id', 'safe', 'on' => 'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id' => 'ID',
      'type_id' => 'Вид',
      'name' => 'Наименование',
      'text' => 'Текст',
      'date' => 'Дата окончания',
      'img' => 'Изображение',
      'product_id' => 'Товар',
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
    $criteria->compare('type_id', $this->type_id);
    $criteria->compare('name', $this->name, true);
    $criteria->compare('text', $this->text, true);
    $criteria->compare('date', $this->date, true);
    $criteria->compare('img', $this->img, true);
    $criteria->compare('product_id', $this->product_id, true);

    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
    ));
  }

  /**
   * Returns the static model of the specified AR class.
   * Please note that you should have this exact method in all your CActiveRecord descendants!
   * @param string $className active record class name.
   * @return Action the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  public function beforeSave() {

    if (!empty($this->date)) {
      $date = Yii::app()->dateFormatter->format('yyyy-MM-dd', $this->begin_date);
      $this->date = $date;
    }

    parent::beforeSave();
    return TRUE;
  }

  public function afterFind() {

    if ($this->date == '0000-00-00')
      $date = '';
    else
      $date = Yii::app()->dateFormatter->format('dd.MM.yyyy', $this->date);
    $this->date = $date;

    parent::afterFind();
    return TRUE;
  }

}
