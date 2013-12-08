<?php
/* @var $product Cart */
?>
<?php
if (is_array($discount)) {
//  $percent = '-' . $discount['discount'] . '%';
  $old_price = number_format($product->product->price, 0, '.', ' ');
  $price = $discount['price'];
  $disc = $product->product->price - $discount['price'];
//  $remainder = $data->remainder > 0 ? 'Осталось ' . $data->remainder . ' шт' : '';
//  $remainder_class = 'gray';
//  $glass = 'red-glass';
//  $item = 'red-item';
//  $button = 'red-item-bt';
}
else {
//  $percent = '';
  $price = $product->product->price;
  $old_price = '';
  $disc = 0;
//  $remainder = $data->remainder > 0 ? 'В наличии' : '';
//  $remainder_class = 'green';
//  $glass = 'green-glass';
//  $item = 'green-item';
//  $button = 'green-item-bt';
}
?>
<div class="inline-blocks">
  <div class="img-container" style="width: 150px; height: 150px">
    <img style="max-width: 150px; max-height: 150px" src="<?php echo $product->product->small_img; ?>">
  </div>
  <div style="font-size: 12pt; margin: 0 40px; width: 200px">
    <div>
      <a class="item-link" href="<?php echo $this->createUrl('product', array('id' => $product->product_id)); ?>">
        <?php echo $product->product->name; ?>
      </a>
    </div>
    <div>Артикул: <?php echo $product->product->article; ?></div>
    <div>Производитель: <?php echo $product->product->brand->name; ?></div>
  </div>
  <div style="margin: 0 40px"><?php
    echo CHtml::activeNumberField($product, "[$product->product_id]quantity", array(
      'style' => 'width: 1.5em; font-size: 16pt; border:1px dashed #BBB;border-radius:3px',
      'class' => 'cart-quantity input-number',
      'price' => $price,
      'disc' => $disc,
      'product' => $product->product_id,
      'max'=>9,
      'maxlength'=>1,
      ));
    ?>
    <span style="position: relative; top: 5px; font-size: 12pt"> шт.</span>
  </div>
  <div style="margin: 0 40px">
    <div class="cufon gray strike bold" style="font-size: 16pt; display: inherit"><?php echo $old_price; ?></div>
    <div class="cufon red bold" style="font-size: 26pt"><?php echo number_format($price, 0, '.', ''); ?>.-</div>
  </div>
  <div><span class="cart-item-del" product="<?php echo $product->product_id ?>" style="font-size: 12pt">Удалить</span></div>
</div>