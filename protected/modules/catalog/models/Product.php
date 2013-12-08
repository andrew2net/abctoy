<?php

/**
 * This is the model class for table "store_product".
 *
 * The followings are the available columns in table 'store_product':
 * @property string $id
 * @property string $name
 * @property string $img
 * @property string $small_img
 * @property string $article
 * @property integer $brand_id
 * @property integer $age
 * @property integer $age_to
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
 * @property-read array $genders
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
      array('age, age_to, gender_id, remainder', 'numerical', 'integerOnly' => true),
      array('name, article, brand_id, price', 'required'),
      array('name, img, small_img', 'length', 'max' => 255),
      array('article', 'length', 'max' => 25),
      array('brand_id', 'length', 'max' => 11),
      array('price', 'length', 'max' => 12),
      array('description, show_me', 'safe'),
      array('img, small_img', 'unsafe'),
      array('article', 'unique'),
      // The following rule is used by search().
      // @todo Please remove those attributes that should not be searched.
      array('name, article, brand_id, age, age_to, gender_id, remainder, price, show_me', 'safe', 'on' => 'search'),
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
      'small_img' => 'Миниатюра',
      'article' => 'Артикул',
      'brand_id' => 'Бренд',
      'age' => 'Возраст с',
      'age_to' => 'по',
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

    $criteria->compare('t.name', $this->name, true);
    $criteria->compare('article', $this->article, true);
    $criteria->compare('age', $this->age);
    $criteria->compare('age_to', $this->age_to);
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

  protected function afterDelete() {
    if (strlen($this->img) > 0) {
      $file = Yii::getPathOfAlias('webroot') . $this->img;
      if (file_exists($file))
        unlink($file);
    }
    if (strlen($this->small_img) > 0) {
      $file = Yii::getPathOfAlias('webroot') . $this->small_img;
      if (file_exists($file))
        unlink($file);
    }
    parent::afterDelete();
  }

  public function getActualDiscount() {
    $categories = Yii::app()->db->createCommand()
            ->select('category_id')->from('store_product_category')
            ->where("product_id={$this->id}")->text;

    $discount_category = Yii::app()->db->createCommand()
            ->select('discount_id')->from('store_discount_category')
            ->where("category_id in ({$categories})")->text;

    $discount_id = Yii::app()->db->createCommand()
            ->select('discount_id')->from('store_discount_product')
            ->where("product_id={$this->id}")
            ->union($discount_category)->text;

    $percenr = Yii::app()->db->createCommand()
        ->select('MAX(percent) discount')->from('store_discount')
        ->where("id in ({$discount_id}) AND (begin_date<=:date OR begin_date='0000-00-00')" .
            " AND (end_date>=:date OR end_date='0000-00-00')"
            , array(':date' => date('Y-m-d')))
        ->queryRow();

    if (!is_null($percenr['discount'])) {
      $new_price = round($this->price * (1 - $percenr['discount'] / 100));
      return array('discount' => $percenr['discount'], 'price' => $new_price);
    }
    return NULL;
  }

  public function scopes() {
    return array_merge(parent::scopes(), array(
      'top' => array(
        'with' => array(
          'top10' => array(
            'joinType' => 'INNER JOIN'),
        ),
        'condition' => "show_me=1",
      ),
      'availableOnly' => array('condition' => "remainder>0",),
      'discountOrder' => array(
        'with' => array(
          'category' => array(
            'select' => FALSE,
            'with' => array(
              'discount' => array(
                'alias' => 'c',
                'select' => FALSE,
                'on' => "((c.begin_date<=:date OR c.begin_date='0000-00-00')" .
                " AND (c.end_date>=:date OR c.end_date='0000-00-00'))",
              )
            )
          ),
          'discount' => array(
            'select' => FALSE,
            'alias' => 'd',
            'on' => "((d.begin_date<=:date OR d.begin_date='0000-00-00')" .
            " AND (d.end_date>=:date OR d.end_date='0000-00-00'))",
          )
        ),
        'together' => TRUE,
        'select' => array(
          't.*',
          'MAX(IFNULL(d.percent, c.percent)) AS percent',
          '(1-MAX(IFNULL(d.percent, IFNULL(c.percent,0)))/100)*t.price AS dprice',
        ),
        'condition' => "show_me=1",
        'params' => array(':date' => date('Y-m-d')),
        'order' => 'percent DESC',
        'group' => 't.id'
      ),
    ));
  }

  public function recommended($limit = NULL) {
    if (!is_null($limit))
      $this->getDbCriteria()->mergeWith(array(
        'limit' => $limit,
        'condition' => "show_me=1",
      ));

    return $this;
  }

  public function searchCategory($id) {
    $this->subCategory($id)->discountOrder();
    return new CActiveDataProvider($this, array(
      'criteria' => $this->searchCriteria(),
//      'pagination' => array('pageSize' => 12),
    ));
  }

  public function subCategory($id) {
    $category = Category::model()->findByPk($id);
    $descendants = $category->descendants()->findAll(array('select' => 'id'));
    $cat = $id;
    foreach ($descendants as $value)
      $cat .= ',' . $value->id;

    $this->getDbCriteria()->mergeWith(
        array(
          'with' => array(
            'category' => array(
              'select' => FALSE,
            ),
          ),
          'together' => TRUE,
          'condition' => "category.id IN ({$cat})",
        )
    );
    return $this;
  }

  public function searchByName($text) {
    $text = strtr($text, array('%' => '\%', '_' => '\_'));
    $this->getDbCriteria()->mergeWith(
        array(
          'condition' => "t.name LIKE :text",
          'params' => array(':text' => '%' . $text . '%'),
        )
    );
    return $this;
  }

  public function gender($id) {
    $this->getDbCriteria()->mergeWith(
        array(
          'condition' => "t.gender_id=:id OR t.gender_id=0",
          'params' => array(':id' => $id),
        )
    );
    return $this;
  }

  public function age($min, $max) {
    $this->getDbCriteria()->mergeWith(
        array(
          'condition' => "t.age<=:age_max AND t.age_to>=:age_min",
          'params' => array(':age_min' => $min, ':age_max' => $max),
        )
    );
    return $this;
  }

  public function price($min, $max) {
    $this->discountOrder();
    $this->getDbCriteria()->mergeWith(
        array(
          'having' => "dprice BETWEEN :min AND :max",
          'params' => array(':min' => $min, ':max' => $max),
    ));
    return $this;
  }

  public function sort($sort) {
    if ($sort['gender'] != 0)
      $this->gender($sort['gender']);

    if (!empty($sort['category']))
      $this->subCategory($sort['category']);

    if (isset($sort['availableOnly']) && $sort['availableOnly'])
      $this->availableOnly();

    $this->age($sort['ageFrom'], $sort['ageTo']);

    $this->price($sort['priceFrom'], $sort['priceTo']);

//    $this->getDbCriteria()->mergeWith(
//        array(
//          'condition' => "t.name LIKE :text",
//          'params' => array(':text' => $text),
//        )
//    );
    return $this;
  }

}
