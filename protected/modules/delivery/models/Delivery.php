<?php

/**
 * This is the model class for table "store_delivery".
 *
 * The followings are the available columns in table 'store_delivery':
 * @property string $id
 * @property string $name
 * @property string $description
 *
 * The followings are the available model relations:
 * @property CityDelivery[] $cityDeliveries
 */
class Delivery extends CActiveRecord {

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'store_delivery';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('name', 'length', 'max' => 30),
      array('description', 'safe'),
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
      'cityDeliveries' => array(self::HAS_MANY, 'CityDelivery', 'delivery_id'),
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
   * @return Delivery the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  public function city($city) {
    $this->getDbCriteria()->mergeWith(array(
      'with' => array(
        'cityDeliveries' => array(
          'select' => array(
            'price AS price',
            'summ AS summ',
            ),
          'with' => array(
            'city' => array(
              'condition' => 'city.name=:city'
            )
          )
        )
      ),
//      'together' => TRUE,
//      'select'=>array('t.*', 'price'),
      'params' => array(':city' => $city)
    ));
    return $this;
  }

  public static function getDeliveryList($city) {
    Yii::import('application.modules.delivery.models.CityDelivery');
    Yii::import('application.modules.delivery.models.City');
    $models = self::model()->city($city)->findAll();
    if (count($models) == 0) {
      $models = self::model()->findAllByAttributes(array('name' => 'Другой город'));
    }
    $list = array();
    foreach ($models as $delivery) {
      if (count($delivery->cityDeliveries) > 0) {
        foreach ($delivery->cityDeliveries as $item) {
          $output = CHtml::tag('span', array(
                'class' => 'bold delivery-data',
                'price' => (float)$item->price,
                'summ' => (float)$item->summ,
                  ), $delivery->name);
          if ($delivery->name == 'ЭКСПРЕСС ДОСТАВКА')
            $output .= CHtml::tag('span', array('class' => 'bold'), ' (' . $delivery->description . ') ');
          else
            $output .= ' (' . $delivery->description . ') ';
          if ($item->price > 0)
            $output .= CHtml::tag('span', array('class' => 'red delivery-price'), $item->price . ' руб.');
          else
            $output .= CHtml::tag('span', array('class' => 'red delivery-price'), 'бесплатно');
          $list[$delivery->id] = $output;
        }
      }else {
        $output = CHtml::tag('span', array('class' => 'bold'), $delivery->name);
        $output .= ' (' . $delivery->description . ') ';
        $list[$delivery->id] = $output;
      }
    }
    return $list;
  }

}
