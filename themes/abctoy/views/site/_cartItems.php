<?php
/* @var $cart Cart[] */
?>
<?php
$fl = FALSE;
foreach ($cart as $product) {
  if ($fl) {
    ?>
    <div style="border-bottom: 1px solid #DDD; width: 750px"></div>
    <?php
  }
  $fl = TRUE;
  $discount = $product->product->getActualDiscount();
  echo $this->renderPartial('_cartItem', array(
    'product' => $product,
    'discount' => $discount));
}
?>
