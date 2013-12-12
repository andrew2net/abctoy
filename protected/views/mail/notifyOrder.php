<?php
/* @var $profile CustomerProfile */
/* @var $order Order */
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
  </head>
  <body>
    <?php
    $params = array(
      'order' => $order,
      'profile' => $profile,
    );
    if (isset($coupon_discount))
      $params['coupon_discount'] = $coupon_discount;
    $this->renderPartial('//mail/_order', $params);
    echo CHtml::tag('div', array('style' => 'margin-top:1em'), 'Телефон в Новосибирске +7 (383) 375-03-22.');
    echo CHtml::tag('a', array('href' => 'http://www.abc-toy.ru'), 'www.abc-toy.ru');
    ?>
  </body>
</html>
