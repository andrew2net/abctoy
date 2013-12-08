<?php
/* @var $cart Cart[] */
/* @var $profile CustomerProfile */
/* @var $order Order */
/* @var $delivery array */
/* @var $payment Payment */
$this->pageTitle = Yii::app()->name . ' - Корзина';
?>
<div class="container" id="page" style="margin-top: 0">
  <?php $this->renderPartial('_shoppingCartTopBlock'); ?>
  <div class="cufon gray bold" style="font-size: 28pt; margin: 20px 0">Ваша корзина</div>
  <?php
  $form = $this->beginWidget('CActiveForm', array('id'=>'item-submit'));
  ?>
  <div id="cart-items">
    <?php $this->renderPartial('_cartItems', array('cart' => $cart)); ?>
  </div>
  <div class="bold" style="font-size: 14pt; margin-top: 30px">
    <span class="cufon">Сумма скидки </span><span id="cart-discount" class="cufon"></span>
  </div>
  <div class="bold" style="font-size: 26pt">
    <span class="cufon gray">Общая сумма заказа: </span>
    <span id="cart-summ" class="cufon red"></span>
  </div>
  <div class="bold" style="font-size: 14pt">
    <span class="cufon red">*</span>
    <span class="cufon"> Минимальная сумма заказа </span>
    <span class="cufon red">1500р.</span>
  </div>
  <div class="cufon gray bold" style="font-size: 26pt; text-align: center; margin: 40px 0">Контактная информация</div>
  <div class="inline-blocks" style="font-size: 12pt">
    <div style="vertical-align: top; width: 290px">
      <div><?php
        echo CHtml::label('Ваше имя и фамилия<span class="red">*</span>'
            , 'CustomerProfile_fio', array(
          'class' => 'cufon gray bold',
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo $form->textField($profile, 'fio'
            , array('class' => 'input-text'));
        ?>
        <?php echo CHtml::error($profile, 'fio', array('style' => 'font-size:10pt', 'class' => 'red')); ?>
      </div>
      <div><?php
        echo CHtml::label('E-mail<span class="red">*</span>', 'CustomerProfile_email'
            , array(
          'class' => 'cufon gray bold',
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo CHtml::activeEmailField($profile, 'email'
            , array('class' => 'input-text'));
        ?>
        <?php echo CHtml::error($profile, 'email', array('style' => 'font-size:10pt', 'class' => 'red')); ?>
      </div>
      <div><?php
        echo CHtml::label('Телефон<span class="red">*</span>', 'CustomerProfile_phone'
            , array(
          'class' => 'cufon gray bold',
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo CHtml::activeTelField($profile, 'phone'
            , array('class' => 'input-text'));
        ?>
        <?php echo CHtml::error($profile, 'phone', array('style' => 'font-size:10pt', 'class' => 'red')); ?>
      </div>
      <div><?php
        echo CHtml::label('Удобное время звонка<span class="red">**</span>', 'CustomerProfile_call_time_id'
            , array(
          'class' => 'cufon gray bold',
        ));
        ?>
      </div>
      <div class="styled-select" style="margin-top: 1em"><?php
        echo CHtml::activeDropDownList($profile, 'call_time_id'
            , $profile->callTimes, array('style' => 'font-size: 12pt'));
        ?></div>
    </div>
    <div style="vertical-align: top; width: 290px; margin: 0 35px">
      <div><?php
        echo CHtml::label('Город доставки<span class="red">*</span>', 'CustomerProfile_city'
            , array(
          'class' => 'cufon gray bold',
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
          'id' => 'cart-city',
          'model' => $profile,
          'attribute' => 'city',
          'sourceUrl' => '/site/suggestcity',
          'htmlOptions' => array('class' => 'input-text')
        ));
        ?>
        <?php echo CHtml::error($profile, 'city', array('style' => 'font-size:10pt', 'class' => 'red')); ?>
      </div>
      <div><?php
        echo CHtml::label('Адрес доставки', 'CustomerProfile_address'
            , array(
          'class' => 'cufon gray bold',
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo CHtml::activeTextField($profile, 'address'
            , array('class' => 'input-text'));
        ?></div>
      <div><?php
        echo CHtml::label('Комментарий', 'CustomerProfile_description'
            , array(
          'class' => 'cufon gray bold',
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo CHtml::activeTextArea($profile, 'description'
            , array(
          'class' => 'input-text',
          'cols' => 25,
          'rows' => 4,
        ));
        ?>
      </div>
      <div style="font-size: 10pt">
        <div class="cufon bold gray"><span class="red">*</span> Поля обязательные для заполнения</div>
        <div class="cufon bold gray"><span class="red">**</span> Удобное время для того, чтобы <br>мы Вам перезвонили для уточнения <br>данные о доставке</div>
      </div>
    </div>
    <div style="vertical-align: top; width: 290px">
      <div class="cufon bold gray">Информация о доставке</div>
      <div style="font-size: 10pt; width: 195px; margin-top: 10px; border: 1px dashed #DDD">
        <div style="padding: 10px">Введите Ваш город, для что бы узнать стоимость доставки.</div>
        <div style="padding: 0 10px 10px">Если вашего города нет в базе, стоимость доставки сообщит менеджер во время звонка.
          Минимальную сумму доставки и подробности о БЕСПЛАТНОЙ ДОСТАВКЕ, можно узнать в разделе <a href="/deliver">ДОСТАВКА</a></div>
      </div>
    </div>
  </div>
  <div class="inline-blocks" style="margin-top: 20px">
    <div style="width: 450px; vertical-align: top; margin-right: 50px">
      <div class="cufon bold gray" style="font-size: 12pt; margin: 20px 0">Способ доставки</div>
      <div id="cart-delivery">
        <?php
        $this->renderPartial('_delivery', array(
          'order' => $order,
          'delivery' => $delivery
        ));
        ?>
      </div>
    </div>
    <div style="vertical-align: top">
      <?php
      $this->renderPartial('_payment', array(
        'order' => $order,
        'payment' => $payment
      ));
      ?>
    </div>
  </div>
  <div class="bold" style="font-size: 26pt; text-align: center ;margin-top: 40px">
    <span class="cufon">Общая сумма заказа: </span><span id="cart-total" class="red"></span>
  </div>
  <div style="margin: 40px 0; text-align: center">
    <?php echo CHtml::submitButton('', array('id' => 'cart-submit')); ?>
  </div>
  <?php $this->endWidget(); ?>
</div>
