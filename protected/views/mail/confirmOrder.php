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
    echo CHtml::tag('div', array('style' => 'font-size:16pt;font-weight:bold;margin-bottom:1em'), 'Здравствуйте ' . $profile->fio . '!');
    echo CHtml::tag('div', array(), 'Это письмо сформированно автоматически. Пожалуйста не отвечайте на него.');
    echo CHtml::tag('div', array(), 'Ваш заказ принят. В ближайшее время наши менеджеры свяжутся Вами.');
    echo CHtml::tag('div', array('style' => 'font-weight:bold;margin-top:1em'), 'Информация о заказе:');
    echo CHtml::tag('div', array(), 'Заказ №' . $order->id . ' от ' . Yii::app()->dateFormatter->format('dd.MM.yyyy', $order->time));
    echo CHtml::tag('div', array(), 'Вид доставки: ' . $order->delivery->name);
    echo CHtml::tag('div', array('style' => 'margin-bottom:1em'), 'Вид оплаты: ' . $order->payment->name);
    echo CHtml::tag('table', array('cellpadding' => 4, 'style' => 'border:2px solid;border-collapse:collapse'));
    echo CHtml::tag('tr', array('style' => 'border:2px solid'));
    echo CHtml::tag('th', array('style' => 'border-right:1px solid'), 'Артикул');
    echo CHtml::tag('th', array('style' => 'border-right:1px solid'), 'Наименование товара');
    echo CHtml::tag('th', array('style' => 'border-right:1px solid'), 'Количество');
    echo CHtml::tag('th', array('style' => 'border-right:1px solid'), 'Цена');
    echo CHtml::tag('th', array(), 'Сумма');
    echo CHtml::closeTag('tr');
    $total = $order->delivery_summ;
    foreach ($order->orderProducts as $value) {
      echo CHtml::tag('tr', array());
      echo CHtml::tag('td', array('style' => 'border-right:1px solid'), $value->product->article);
      echo CHtml::tag('td', array('style' => 'border-right:1px solid'), $value->product->name);
      echo CHtml::tag('td', array('style' => 'text-align:right;border-right:1px solid'), $value->quantity);
      echo CHtml::tag('td', array('style' => 'text-align:right;border-right:1px solid'), $value->price);
      $summ = $value->quantity * $value->price;
      $total += $summ;
      echo CHtml::tag('td', array('style' => 'text-align:right'), money_format('%n', $summ));
      echo CHtml::closeTag('tr');
    }
    echo CHtml::tag('tr', array('style' => 'border:2px solid'));
    echo CHtml::tag('td', array('colspan' => 4, 'style' => 'text-align:right'), 'Стоимость доставки:');
    echo CHtml::tag('td', array('style' => 'text-align:right;border-left:1px solid'), money_format('%n', $order->delivery_summ));
    echo CHtml::closeTag('tr');
    echo CHtml::tag('tr', array('style' => 'border:2px solid'));
    echo CHtml::tag('td', array('colspan' => 4, 'style' => 'text-align:right'), 'Итого:');
    echo CHtml::tag('td', array('style' => 'text-align:right;border-left:1px solid'), money_format('%n', $total));
    echo CHtml::closeTag('tr');
    echo CHtml::closeTag('table');
    echo CHtml::tag('div', array('style' => 'margin-top:1em'), 'Телефон в Новосибирске +7 (383) 375-03-22.');
    echo CHtml::tag('a', array('href' => 'http://www.abc-toy.ru'), 'www.abc-toy.ru');
    ?>
  </body>
</html>