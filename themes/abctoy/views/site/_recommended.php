<div class="inline-blocks" style="margin: 20px 0">
  <div class="icon-recom"></div>
  <div class="cufon green bold" style="font-size: 20pt; position: relative; top: -18px; padding: 0 10px">Вам рекомендовано</div>
  <?php
  Yii::import('application.modules.catalog.models.Product');
  $product = Product::model();
  if (!isset($group)) {
    $product->discountOrder()->recommended(15);
    ?>
    <div style="float: right; font-size: 12pt; position: relative; top: 20px;">
      <span class="cufon green bold">Товар подобран для вашего ребенка</span>
    </div>
    <?php
  }
  else
    $product->subCategory($group->id)->discountOrder()->recommended(12);
    
    ?>
</div>
<div style="margin-bottom: 30px">
  <?php
  $products = $product->findAll();
  foreach ($products as $value) {
    ?>
    <div style="float: left">
    <?php $this->renderPartial('_item', array('data' => $value)); ?>
    </div>
<?php } ?>
</div>