<?php
/* @var $product Product */
/* @var $groups[] Category */
/* @var $search Search */
?>
<?php $this->renderPartial('_topmenu'); ?>

<div class="container" id="page">
  <?php $this->renderPartial('_topblock'); ?>
  <?php
  $this->renderPartial('_mainmenu', array(
    'search' => $search,
    'groups' => $groups,
  ));
  ?>
  <div class="inline-blocks">
    <div class="img-container" style="width: 450px; height: 450px">
      <img style="max-width: 450px; max-height: 450px" src="<?php echo $product->img; ?>">
    </div>
    <div class="helper"></div>
    <div style="height: 450px; vertical-align: top">
      <div class="cufon bold" style="font-size: 22pt; margin-top: 50px"><?php echo $product->name; ?></div>
      <div>Артикул: <?php echo $product->article; ?></div>
      <div>Производитель: <?php echo $product->brand->name; ?></div>
      <div>Возраст: <?php echo $product->age; ?></div>
      <div>Наличие: <?php echo $product->remainder ? 'товар в наличии на складе' : 'товар временно отсутствует'; ?></div>
      <div><?php echo CHtml::link('ДОСТАВКА', $this->createUrl('delivery_payment')); ?> по новосибирску возможна завтра</div>
      <div style="height: 20px"></div>
      <div class="cufon bold red" style="font-size: 32pt"><?php echo number_format($product->price, 0, '.', ''); ?>.-</div>
    </div>
  </div>
</div>
<?php $this->renderPartial('_footer', array('groups' => $groups)); ?>
