<?php

/* @var $this Controller */

$this->widget('ext.bootstrap.widgets.TbNav', array(
  'type' => TbHtml::NAV_TYPE_TABS,
  'items' => array(
    array('label' => 'Товары',
      'url' => '/admin/catalog/product',
      'active' => $this instanceof ProductController,
      'visible' => Yii::app()->user->checkAccess('catalog.product.*')
    ),
    array('label' => 'ТОП 10',
      'url' => '/admin/catalog/top10',
      'active' => $this instanceof Top10Controller,
      'visible' => Yii::app()->user->checkAccess('catalog.top10.*')
    ),
    array('label' => 'Категории',
      'url' => '/admin/catalog/category',
      'active' => $this instanceof CategoryController,
      'visible' => Yii::app()->user->checkAccess('catalog.category.*')
    ),
    array('label' => 'Бренды',
      'url' => '/admin/catalog/brand',
      'active' => $this instanceof BrandController,
      'visible' => Yii::app()->user->checkAccess('catalog.brand.*')
    ),
  )
));
?>
<?php echo $content; ?>
