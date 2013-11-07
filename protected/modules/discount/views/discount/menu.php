<?php

/* @var $this Controller */

$this->widget('ext.bootstrap.widgets.TbNav', array(
  'type' => TbHtml::NAV_TYPE_TABS,
  'items' => array(
    array('label' => 'Скидки',
      'url' => '/admin/discount/discount',
      'active' => $this instanceof DiscountController,
      'visible' => Yii::app()->user->checkAccess('discount.discount.*')
    ),
    array('label' => 'Купоны',
      'url' => '/admin/discount/coupon',
      'active' => $this instanceof CouponController,
      'visible' => Yii::app()->user->checkAccess('discount.coupon.*')
    ),
  )
));
?>
<?php echo $content; ?>
