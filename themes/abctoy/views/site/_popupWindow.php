<?php
/* @var $child Child */
?>
<img id="popup-close" style="position: absolute; right: -16px; top: -16px; z-index: 1005; cursor: pointer" src="/images/close.png">
<div class="inline-blocks" style="text-align: center">
  <div style="margin: 20px">
    <img width="173" height="57" alt="ABC toy" src="/themes/abctoy/css/logo_shadow.png">
  </div>
  <div class="cufon gray bold" style="text-align: left">Интернет магазин<br>детских товаров и игрушек</div>
</div>
<div class="inline-blocks">
  <div style="width: 365px; text-align: center; margin: 0 10px">
    <div class="cufon bold" style="font-size: 18pt">Укажите возраст вашего</div>
    <div class="cufon bold" style="font-size: 18pt; margin-top: 10px">ребенка и получите сертификат</div>
    <div class="cufon red bold" style="font-size: 140pt; height: 144px">400</div>
    <div class="cufon red bold" style="font-size: 72pt">рублей</div>
    <div class="cufon bold" style="font-size: 18pt; margin: 10px 0">на первую покупку</div>
    <div class="cufon gray">Так же мы будем рекомендовать только те игрушки которые будут интересны вашему ребенку.</div>
  </div>
  <div style="vertical-align: top">
    <div class="inline-blocks" style="font-size: 9pt">
      <div style="vertical-align: bottom; margin-left: 20px">
        <?php
        echo CHtml::activeLabel($child, 'name');
        ?><br>
        <?php
        echo CHtml::activeTextField($child, '[1]name', array(
          'class' => 'input-text',
          'style' => 'width:120px',
        ));
        ?>
      </div>
      <div style="vertical-align: bottom; margin: 0 10px">
        <?php
        echo CHtml::activeLabel($child, 'birthday');
        ?><br>
        <?php
        echo CHtml::activeTextField($child, 'birthday', array(
          'class' => 'input-text date',
          'style' => 'width:100px',
        ));
        ?>
      </div>
      <div style="vertical-align: bottom; position: relative; bottom: 10px">
        <?php
        echo CHtml::activeRadioButtonList($child, 'gender_id', $child->genders, array(
          'separator' => '',
        ));
        ?>
      </div>
    </div>
    <div style="margin: 10px 0">
      <span class="icon-add-child-small add-child"></span>
      <span class="blue add-child" style="text-decoration: underline; text-decoration-style: dashed; -moz-text-decoration-style: dashed; cursor: pointer">У меня есть еще ребенок</span>
    </div>
  </div>
</div>