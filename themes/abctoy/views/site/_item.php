<div class="item">
  <div>
    <div style="height: 150px; position: relative"><img src="<?php echo $data->small_img; ?>"></div>
    <div class="item-name"><?php echo CHtml::link($data->name); ?></div>
    <div class="item-rest">В наличии</div>
    <div class="item-disc"></div>
    <div class="cufon item-price"><?php echo number_format($data->price, 0, '.', ''); ?>.-</div>
  </div>
</div>