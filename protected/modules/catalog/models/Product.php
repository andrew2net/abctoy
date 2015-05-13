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

  public $w_end_date;

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
        ->select('d.id')
        ->from('store_discount_category dc')
        ->join('store_discount d', 'd.id = dc.discount_id')
        ->join('store_category c', 'c.id = dc.category_id')
        ->join('store_category s', 's.lft >= c.lft AND s.rgt <= c.rgt AND s.root=c.root')
        ->where("s.id in ({$categories})")->text;

    $discount_id = Yii::app()->db->createCommand()
        ->select('discount_id')->from('store_discount_product')
        ->where("product_id={$this->id}")
        ->union($discount_category)->text;

    $percenr = Yii::app()->db->createCommand()
      ->select('MAX(percent) discount')->from('store_discount')
      ->where("(id in ({$discount_id}) OR product_id=0) AND (begin_date<=:date OR begin_date='0000-00-00')" .
        " AND (end_date>=:date OR end_date='0000-00-00') AND actual=1"
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
      'availableOnly' => array(
        'with' => array('category'=>array('alias' => 'category')),
        'condition' => "remainder>0 AND remainder IS NOT NULL AND category.active=1",
        ),
    ));
  }

//  public function availableOnly() {
//    $active_categories = Category::model()->findAll(array(
//      'criteria' => array(
//        'with' => array(),
//        'condition' => 'active=1',
//        )));
//    $this->dbCriteria->mergeWith(array(
//      'condition' => "remainder>0 AND remainder IS NOT NULL",
//    ));
//    return $this;
//  }

  public function discount() {
    $discount_all = Discount::model()
      ->count("actual=1 AND type_id IN (0,1) AND product_id=0 AND (begin_date<=:date OR begin_date='0000-00-00') AND (end_date>=:date OR end_date='0000-00-00')"
      , array(':date' => date('Y-m-d')));

    $discount_product = Yii::app()->db->createCommand()
      ->select('p.product_id')
      ->from('store_discount_product p')
      ->join('store_discount d', 'p.discount_id=d.id')
      ->where("actual=1 AND type_id IN (0,1) AND (begin_date<=:date OR begin_date='0000-00-00') AND (end_date>=:date OR end_date='0000-00-00')");

    $discount_category = Yii::app()->db->createCommand()
      ->select('s.id')
      ->from('store_discount_category dc')
      ->join('store_discount d', 'd.id = dc.discount_id')
      ->join('store_category c', 'c.id = dc.category_id')
      ->join('store_category s', 's.lft >= c.lft AND s.rgt <= c.rgt AND s.root=c.root')
      ->where("actual=1 AND type_id IN (0,1) AND (begin_date<=:date OR begin_date='0000-00-00') AND (end_date>=:date OR end_date='0000-00-00')");

    $criteria = new CDbCriteria;
    $criteria->condition = "$discount_all>0 OR category.id IN ($discount_category->text) OR t.id IN ($discount_product->text)";
    $criteria->params = array(':date' => date('Y-m-d'));
    $criteria->with = array('category');
    $criteria->together = TRUE;

    $this->getDbCriteria()->mergeWith($criteria);
    return $this;
  }

  public function week() {

    $discount_category = Yii::app()->db->createCommand()
      ->select('d.percent, d.begin_date, d.end_date, d.type_id, d.actual, s.id')
      ->from('store_discount_category dc')
      ->join('store_discount d', 'd.id = dc.discount_id')
      ->join('store_category c', 'c.id = dc.category_id')
      ->join('store_category s', 's.lft >= c.lft AND s.rgt <= c.rgt AND s.root=c.root')
      ->where("actual=1 AND type_id IN (0,1) AND (begin_date<=:date OR begin_date='0000-00-00') AND (end_date>=:date OR end_date='0000-00-00')");

    $date = date('Y-m-d');
    $this->getDbCriteria()->mergeWith(array(
      'with' => array(
        'discount' => array(
          'select' => FALSE,
          'alias' => 'prod',
          'on' => "prod.actual=1 AND (prod.begin_date<=:date OR prod.begin_date='0000-00-00')" .
          " AND (prod.end_date>=:date OR prod.end_date='0000-00-00') AND prod.type_id=0",
        ),
        'category' => array(
          'select' => FALSE,
          'join' => "LEFT JOIN ($discount_category->text) cat ON category.id=cat.id",
        ),
      ),
      'together' => TRUE,
      'select' => array(
        't.*',
        'IFNULL(prod.begin_date, cat.begin_date) AS w_begin_date',
        'IFNULL(prod.end_date, cat.end_date) AS w_end_date',
        'IFNULL(prod.type_id, cat.type_id) AS w_type',
        'IFNULL(prod.actual, cat.actual) AS w_actual',
        'MAX(IFNULL(prod.percent, cat.percent)) AS percent',
      ),
      'condition' => "t.show_me=1",
      'having' => "w_type=0 AND w_actual=1 AND (w_begin_date<='" . $date .
      "' OR w_begin_date='0000-00-00') AND (w_end_date>='" . $date .
      "' OR w_end_date='0000-00-00')",
      'order' => 'percent DESC',
      'group' => 'prod.id, t.id',
      'params' => array(':date' => $date),
    ));
    return $this;
  }

  public function discountOrder() {
    $discount_all = Yii::app()->db->createCommand()
        ->select("a.percent")
        ->from('store_discount a')
        ->where("actual=1 AND type_id IN (0,1) AND product_id=0 AND (begin_date<=:date OR begin_date='0000-00-00') AND (end_date>=:date OR end_date='0000-00-00')")->text;
    $discount_category = Yii::app()->db->createCommand()
        ->select('d.percent, s.id')
        ->from('store_discount_category dc')
        ->join('store_discount d', 'd.id = dc.discount_id')
        ->join('store_category c', 'c.id = dc.category_id')
        ->join('store_category s', 's.lft >= c.lft AND s.rgt <= c.rgt AND s.root=c.root')
        ->where("actual=1 AND type_id IN (0,1) AND (begin_date<=:date OR begin_date='0000-00-00') AND (end_date>=:date OR end_date='0000-00-00')")->text;
    $this->getDbCriteria()->mergeWith(array(
      'with' => array(
        'category' => array(
          'select' => FALSE,
          'join' => "LEFT JOIN ($discount_category) c ON category.id=c.id OR c.id='a'"
        ),
        'discount' => array(
          'select' => FALSE,
          'alias' => 'd',
          'on' => "actual=1 AND (d.begin_date<=:date OR d.begin_date='0000-00-00')" .
          " AND (d.end_date>=:date OR d.end_date='0000-00-00')",
        )
      ),
      'join' => "LEFT JOIN ($discount_all) a ON a.percent>0",
      'together' => TRUE,
      'select' => array(
        't.*',
        'MAX(IFNULL(d.percent, IFNULL(c.percent, IFNULL(a.percent, 0)))) AS percent',
        '(1-MAX(IFNULL(d.percent, IFNULL(c.percent, IFNULL(a.percent, 0))))/100)*t.price AS dprice',
      ),
      'condition' => "show_me=1",
      'params' => array(':date' => date('Y-m-d')),
      'order' => 'percent DESC',
      'group' => 't.id'
    ));
    return $this;
  }

  public function brandFilter($id) {
    $this->getDbCriteria()->mergeWith(array(
      'condition' => 'brand_id=:id',
      'params' => array(':id' => $id),
    ));
    return $this;
  }

  public function recommended() {
    $params = Child::model()->getSelectParams();
    $this->getDbCriteria()->mergeWith(array(
      'select' => array(
        't.*',
        'CASE WHEN :gender=0 THEN 1 WHEN t.gender_id=:gender THEN 1 ELSE 0 END AS g',
        'CASE WHEN t.age<=:ageTo AND t.age_to>=:ageFrom THEN 1 ELSE 0 END AS a'
      ),
      'order' => 'a DESC, g DESC',
      'params' => array(
        ':gender' => $params['gender'],
        ':ageFrom' => isset($params['ageFrom']) ? $params['ageFrom'] : 0,
        ':ageTo' => isset($params['ageTo']) ? $params['ageTo'] : 10,
      ),
    ));
//    if (!is_null($limit))
//      $this->getDbCriteria()->mergeWith(array(
//        'limit' => $limit,
//        'condition' => "show_me=1",
//      ));

    return $this;
  }

  public function searchCategory($id) {
    $this->availableOnly()->subCategory($id)->discountOrder();
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
        'condition' => "t.name LIKE :text OR t.article=:art",
        'params' => array(
          ':text' => '%' . $text . '%',
          ':art' => $text,
        ),
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
        'having' => "dprice BETWEEN :min AND :max OR dprice>=:min AND :max=5000",
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
