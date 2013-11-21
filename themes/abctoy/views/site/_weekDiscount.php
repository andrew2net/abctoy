<?php
Yii::import('application.modules.discount.models.Discount');
Yii::import('application.modules.catalog.models.Category');
Yii::import('application.modules.catalog.models.Product');
$week = Discount::model()->week()->findAll();
?>
<div class="weekcarousel" style="margin-top: 15px;">
  <div class="inline-blocks">
    <?php
    foreach ($week as $value) {
      if ($value->product_id == 1) {
        foreach ($value->category as $category) {
          foreach ($category->product as $product) {
            ?>
            <div>
              <?php $this->renderPartial('_item', array('data' => $product)); ?>
            </div>>
            <?php
          }
        }
      }
      elseif ($value->product_id == 2) {
        foreach ($value->product as $product) {
          ?>
          <div>
          <?php $this->renderPartial('_item', array('data' => $product)); ?>
          </div>
          <?php }
        }
      }
      ?>
  </div>
</div>
