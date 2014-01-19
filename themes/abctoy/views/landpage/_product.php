<?php
/* @var $product Product */
?>
<div class="inline-blocks product">
  <div class="deliver-labe">
  </div>
  <div class="deliver-txt">
    <span class="bold" style="font-size: 12pt">БЕСПЛАТНАЯ</span><br>
    <span class="bold" style="font-size: 16pt">ДОСТАВКА</span><br>
    <span>В ТЕЧЕНИИ 1-3</span><br>
    <span>ДНЕЙ БЕЗ</span><br>
    <span>ПРЕДОПЛАТЫ</span>
  </div>
  <div class="product-img"><img src="<?php echo $product->small_img; ?>"></div>
  <div style="vertical-align: top; width: 380px">
    <div class="product-name cufon bold"><?php echo $product->name; ?></div>
    <div style=""><?php echo $product->description; ?></div>
    <div>
      <span class="product-price cufon bold"><?php echo number_format($product->price, 0, '.', ' '); ?></span>
      <span> (скидка <?php echo round(40000 / ($product->price>0?$product->price:1)); ?>%)</span>
    </div>
    <div class="inline-blocks" style="position: relative">
      <div class="cufon bold red" style="font-size: 54pt"><?php echo number_format($product->price - 400, 0, '.', ' '); ?>.-</div>
      <div class="redbutton addToCart" product="<?php echo $product->id; ?>">
        <div class="left"></div>
        <div class="center" style="font-size: 12pt">В КОРЗИНУ</div>
        <div class="right"></div>
      </div>
    </div>
  </div>
</div>