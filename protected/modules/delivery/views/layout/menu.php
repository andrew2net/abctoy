<?php

/* @var $this Controller */

$this->widget('ext.bootstrap.widgets.TbNav', array(
  'type' => TbHtml::NAV_TYPE_TABS,
  'items' => array(
    array('label' => 'Виды доставки',
      'url' => '/admin/delivery/delivery',
      'active' => $this instanceof DeliveryController,
      'visible' => Yii::app()->user->checkAccess('delivery.delivery.*')
    ),
    array('label' => 'Города',
      'url' => '/admin/delivery/city',
      'active' => $this instanceof CityController,
      'visible' => Yii::app()->user->checkAccess('delivery.city.*')
    ),
  )
));
?>
<?php echo $content; ?>
