<?php
/* @var $profile CustomerProfile */
/* @var $coupon Coupon */
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
  </head>
  <body>
    <?php
    echo CHtml::tag('div', array('style' => 'font-size:16pt;font-weight:bold;margin-bottom:1em'), 'Здравствуйте ' . $profile->fio . '!');
    echo CHtml::tag('div', array(), "Спасибо что зарегистрировались на нашем сайте. Каждому новому покупателю мы дарим в подарок купон со скидкой $coupon->value рублей. Для получения скидки используйте код купона $coupon->code при оформлении заказа.", FALSE);
    echo CHtml::closeTag('div');
    $this->renderPartial('//mail/_footer');
    ?>
  </body>
</html>
