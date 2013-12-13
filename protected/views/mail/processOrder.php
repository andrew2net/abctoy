<?php
/* @var $profile CustomerProfile */
/* @var $order Order */
/* @var $text string */
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
  </head>
  <body>
    <?php
    $date = Yii::app()->dateFormatter->format('dd.MM.yyyy', $order->time);
    echo CHtml::tag('div', array('style' => 'font-size:16pt;font-weight:bold;margin-bottom:1em'), 'Здравствуйте ' . $profile->fio . '!');
    echo CHtml::tag('div', array(), "Ваш заказ №{$order->id} от {$date} {$text}.");
    echo CHtml::tag('div', array(), 'Это письмо сформированно автоматически. Пожалуйста не отвечайте на него.');
    echo CHtml::tag('div', array('style' => 'margin-top:1em'), 'Телефон в Новосибирске +7 (383) 375-03-22.');
    echo CHtml::tag('a', array('href' => 'http://www.abc-toy.ru'), 'www.abc-toy.ru');
    ?>
  </body>
</html>
