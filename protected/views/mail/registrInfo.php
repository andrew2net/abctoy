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
    echo CHtml::tag('div', array(), "Спасибо за регистрацию на нашем сайте. Теперь Вы можете ослеживать состояние Ваших заказов в своем ", FALSE);
    echo CHtml::tag('a', array('href' => Yii::app()->createAbsoluteUrl('profile')), 'личном кабинете');
    echo CHtml::closeTag('div');
    echo CHtml::tag('div', array('style' => 'margin-bottom:1em'), "Для входа в ваш личный кабинет ипользуйте следующие данные:");
    echo CHtml::tag('div', array(), "Имя: {$login}");
    echo CHtml::tag('div', array(), "Пароль: {$passw}");
    $this->renderPartial('//mail/_footer');
    ?>
  </body>
</html>
