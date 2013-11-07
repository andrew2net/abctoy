<?php

/**
 * This is the model class for table "store_product".
 *
 * The followings are the available columns in table 'store_product':
 * @property string $id
 * @property string $name
 * @property string $img
 * @property string $article
 * @property integer $brand_id
 * @property integer $age
 * @property integer $gender_id
 * @property integer $remainder
 * @property string $description
 * @property string $price
 * @property boolean $show_me
 *
 * The followings are the available model relations:
 * @property Brand $brand
 * @property Category[] $category 
 * @property Discount[] $discount
 * @property Top10 $top10 
 */
class Product extends CActiveRecord {

  private $genders = array('0' => 'Для всех', '1' => 'Мальчик', '2' => 'Девочка');

  public function getGenders() {
    return $this->genders;
  }

  public function getGender() {
    return $this->genders[$this->gender_id];
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'store_product';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('age, gender_id, remainder', 'numerical', 'integerOnly' => true),
      array('name, article, brand_id, price', 'required'),
      array('name', 'length', 'max' => 30),
      array('img', 'length', 'max' => 255),
      array('article', 'length', 'max' => 25),
      array('brand_id', 'length', 'max' => 11),
      array('price', 'length', 'max' => 12),
      array('description, show_me', 'safe'),
      array('article', 'unique'),
      // The following rule is used by search().
      // @todo Please remove those attributes that should not be searched.
      array('name, article, brand_id, age, gender_id, remainder, price, show_me', 'safe', 'on' => 'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
      'category' => array(self::MANY_MANY, 'Category',
        'store_product_category(product_id, category_id)'),
      'discount' => array(self::MANY_MANY, 'Discount'
        , 'store_discount_product(discount_id, product_id)'),
      'top10' => array(self::HAS_ONE, 'Top10', 'product_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id' => 'ID',
      'name' => 'Наименование',
      'img' => 'Изображение',
      'article' => 'Артикул',
      'brand_id' => 'Бренд',
      'age' => 'Возраст',
      'gender_id' => 'Пол',
      'remainder' => 'Остаток',
      'description' => 'Описание',
      'price' => 'Цена',
      'show_me' => 'Показывать',
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

    return new CActiveDataProvider($this, array(
      'criteria' => $this->searchCriteria(),
    ));
  }

  private function searchCriteria() {
    $criteria = new CDbCriteria;

    $criteria->compare('name', $this->name, true);
    $criteria->compare('article', $this->article, true);
    $criteria->compare('age', $this->age);
    $criteria->compare('remainder', $this->remainder);
    $criteria->compare('price', $this->price);
    $criteria->compare('show_me', $this->show_me);
    $criteria->with = array('brand');
    $criteria->compare('brand_id', $this->brand_id, TRUE);
    $criteria->compare('gender_id', $this->gender_id, TRUE);

    return $criteria;
  }

  public function searchTop10() {
    $criteria = $this->searchCriteria();
    $criteria->with = array('top10');
    $criteria->addCondition('top10.product_id is null');
    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
      'pagination' => array('pageSize' => 5),
    ));
  }

  public function searchDiscount() {
    $criteria = $this->searchCriteria();
    $criteria->addNotInCondition('t.id', $_SESSION['discount_product']);
    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
      'pagination' => array('pageSize' => 5),
    ));
  }

  /**
   * Returns the static model of the specified AR class.
   * Please note that you should have this exact method in all your CActiveRecord descendants!
   * @param string $className active record class name.
   * @return Product the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  public function getBrandOptions() {
    $brands = Brand::model()->findAll(array('order' => 'name'));
    return $list = CHtml::listData($brands, 'id', 'name');
  }

  public function getCategoryTree() {

    $checked = CHtml::listData($this->category, 'id', 'name');

    $tree = '';
    $categories = Category::model()->findAll(array('order' => 'root,lft'));
    $level = 0;

    foreach ($categories as $n => $category) {

      if ($category->level == $level)
        $tree .= CHtml::closeTag('li');
      else if ($category->level > $level)
        $tree .= CHtml::openTag('ul');
      else {
        $tree .= CHtml::closeTag('li');

        for ($i = $level - $category->level; $i; $i--) {
          $tree .= CHtml::closeTag('ul');
          $tree .= CHtml::closeTag('li');
        }
      }
      $class = "";
      if (array_key_exists($category->primaryKey, $checked))
        $class .= "jstree-checked";

      $tree .= CHtml::openTag('li', array(
            'id' => 'node_' . $category->primaryKey,
            "class" => $class,
//        'rel' => $category->getAttribute('name')
      ));
      $tree .= CHtml::openTag('a', array('href' => '#'));
      $tree .= CHtml::encode($category->getAttribute('name'));
      $tree .= CHtml::closeTag('a');

      $level = $category->level;
    }

    for ($i = $level; $i; $i--) {
      $tree .= CHtml::closeTag('li');
      $tree .= CHtml::closeTag('ul');
    }

    return $tree;
  }

}

