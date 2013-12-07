<?php
/* @var $product Product */
?>
<div class="inline-blocks" style="margin: 20px 0">
  <div <?php echo (isset($group) ? 'style="width: 100%"' : ''); ?>>
    <div class="inline-blocks <?php echo (isset($group) ? 'right' : ''); ?>">
      <div class="icon-recom"></div>
      <div class="cufon green bold" style="font-size: 20pt; position: relative; padding: 0 10px">Вам рекомендовано</div>
    </div>
  </div>
  <?php
  if (!isset($group)) {
    ?>
    <div style="float: right; font-size: 12pt; position: relative; top: 20px;">
      <span class="cufon green bold">Товар подобран для вашего ребенка</span>
    </div>
    <?php
  }
  ?>
</div>
<div style="margin-bottom: 30px">
  <?php
  if (isset($group)) {
    $product->subCategory($group->id)->discountOrder();
    $products = $product->findAll(array('limit' => 12));
  }
  else
    $products = $product->discountOrder()->findAll(array('limit' => 15));
  foreach ($products as $value) {
    ?>
    <div style="float: left">
    <?php $this->renderPartial('_item', array('data' => $value)); ?>
    </div>
<?php } ?>
</div>