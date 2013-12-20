<?php
/* @var $profile CustomerProfile */
/* @var $login string */
/* @var $passw string */
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
    echo CHtml::tag('div', array(), "Вы можете ослеживать состояние Ваших заказов в своем ", FALSE);
    echo CHtml::tag('a', array('href' => Yii::app()->createAbsoluteUrl('profile')), 'личном кабинете');
    echo CHtml::closeTag('div');
    echo CHtml::tag('div', array('style' => 'margin-bottom:1em'), "Для входа в ваш личный кабинет ипользуйте следующие данные:");
    echo CHtml::tag('div', array(), "имя {$login}");
    echo CHtml::tag('div', array(), "пароль: {$passw}");
    echo CHtml::tag('div', array('style' => 'margin-top:1em'), 'Это письмо сформированно автоматически. Пожалуйста не отвечайте на него.');
    echo CHtml::tag('div', array('style' => 'margin-top:1em'), 'Телефон в Новосибирске +7 (383) 375-03-22.');
    echo CHtml::tag('a', array('href' => Yii::app()->createAbsoluteUrl('')), Yii::app()->createAbsoluteUrl(''));
    ?>
  </body>
</html>
