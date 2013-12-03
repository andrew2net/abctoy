<?php
/* @var $order Order */
/* @var $delivery Delivery */
?>

<div style="width: 400px; vertical-align: top; margin-right: 50px">
  <div class="cufon bold gray" style="font-size: 12pt; margin: 20px 0">Способ доставки</div>
  <?php
  echo CHtml::activeRadioButtonList($order, 'delivery_id'
      , $delivery, array(
    'labelOptions' => array(
      'style' => 'display: block',
      'class' => 'cart-radio'
  )));
  ?>
</div>
