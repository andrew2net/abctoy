<div class="item">
  <div>
    <div style="height: 150px"><img height="120" src="<?php echo $data->img; ?>"></div>
    <div class="item-name"><?php echo CHtml::link($data->name); ?></div>
    <div class="item-rest">В наличии</div>
    <div class="item-disc"></div>
    <div class="cufon item-price"><?php echo number_format($data->price, 0, '.', ''); ?>.-</div>
  </div>
</div>