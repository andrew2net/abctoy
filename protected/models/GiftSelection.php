<?php

/**
 * Description of GiftSelection
 *
 * @author Greg Bakos <greg@londonfreelancers.co.uk>
 */
class GiftSelection extends CFormModel {

  public $gender;
  public $ageFrom;
  public $ageTo;
  public $priceFrom;
  public $priceTo;
  public $category;
  public $availableOnly;

  public function init() {
    parent::init();
    $this->gender = 0;
    $this->ageFrom = 1;
    $this->ageTo = 4;
    $this->availableOnly = 1;
  }

  public function attributeLabels() {
    return array(
      'gender' => 'Пол ребенка',
      'category' => 'Категория товара',
      'ageFrom' => 'Возраст ребенка',
      'availableOnly' => 'Только в наличии',
    );
  }

}

