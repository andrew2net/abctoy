<?php
echo CHtml::tag('div', array('style' => 'margin-top:1em'), 'Это письмо сформированно автоматически. Пожалуйста не отвечайте на него.');
echo CHtml::tag('div', array('style' => 'margin-top:1em'), 'Телефон в Новосибирске +7 (383) 375-03-22.');
echo CHtml::tag('a', array('href' => Yii::app()->createAbsoluteUrl('')), Yii::app()->createAbsoluteUrl(''));
?>