<div class="inline-blocks" style="margin: 20px 0">
  <div class="icon-recom"></div>
  <div class="cufon green bold" style="font-size: 20pt; position: relative; top: -18px; padding: 0 10px">Вам рекомендовано</div>
  <div style="float: right; font-size: 12pt; position: relative; top: 20px;">
    <span class="cufon green bold">Товар подобран для вашего ребенка</span>
  </div>
</div>
<div style="margin-bottom: 30px">
<?php
//$recommended = Product::model()->findAll();
Yii::import('application.modules.catalog.models.Product');
//
//$products = new CActiveDataProvider('Product', array(
//  'criteria' => array('condition' => 'show_me=1')
//    ));
//$this->widget('zii.widgets.CListView', array(
//  'dataProvider' => $products,
//  'itemView' => '_item',
//    )
//);
$products = Product::model()->recommended()->findAll();
foreach ($products as $value) {
  ?>
<?php $this->renderPartial('_item', array('data' => $value)); ?>
<?php } ?>
</div>