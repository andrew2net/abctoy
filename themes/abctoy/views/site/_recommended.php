<?php

Yii::import('application.modules.catalog.models.Product');

$products = new CActiveDataProvider('Product', array(
  'criteria' => array('condition' => 'show_me=1')
    ));
$this->widget('zii.widgets.CListView', array(
  'dataProvider' => $products,
  'itemView' => '_item',
    )
);
?>