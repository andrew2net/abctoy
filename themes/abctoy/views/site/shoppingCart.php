<?php
/* @var $cart Cart[] */
/* @var $profile CustomerProfile */
/* @var $order Order */
/* @var $delivery array */
/* @var $payment Payment */
?>
<div class="container" id="page" style="margin-top: 0">
  <div class="table" style="padding-bottom: 10px">
    <div class="table-cell valign-middle" style="width: 200px;">
      <a href="/"><img width="173" height="57" alt="ABC toy" src="/themes/abctoy/css/logo_shadow.png"></a>
      <div><a class="gray" href="#">Отзывы о нас</a></div>
    </div>

    <div class="table-cell valign-middle" style="width: 200px">
      <div class="cufon gray bold">Интернет магазин<br>детских товаров и игрушек</div>
    </div>
    <div class="table-cell bold" style="width: 180px">
      <div class="cufon lager" style="padding-bottom: 0.4em">Телефон для справок</div>
      <div class="cufon x-lage" style="padding-bottom: 0.2em">
        <span class="red">(383)</span><span class="blue"> 224</span><span>-</span><span class="green">23</span><span>-</span><span class="yellow">32</span>
      </div>
      <div style="text-align: right">
        <div class="cufon gray" style="font-size: medium; padding-bottom: 0.5em">(10:00 - 18:00 пн.-пт.)</div>
      </div>
      <div class="gray lager">г. Новосибирск</div>
      <!--<div><a href="#" class="gray uderline-dashed">я в другом городе</a></div>-->
    </div>
    <div style="position: relative; top: 35px">
      <div class="cufon green bold" style="font-size: 24pt; text-align: right">Оформление заказа</div>
      <div style="text-align: right"><a href="/">Продолжить покупки</a></div>
    </div>
  </div>
  <div class="cufon gray bold" style="font-size: 28pt; margin-top: 20px">Ваша корзина</div>
  <?php
  $form = $this->beginWidget('CActiveForm');
  ?>
  <div>
    <?php
    $sum = 0;
    $fl = FALSE;
    foreach ($cart as $product) {
      if ($fl) {
        ?>
        <div style="border-bottom: 1px solid #DDD; width: 750px"></div>
        <?php
      }
      $fl = TRUE;
      $discount = $product->product->getActualDiscount();
      $sum += (is_array($discount) ? $discount['price'] :
              $product->product->price) * $product->quantity;
      echo $this->renderPartial('_cartItem', array(
        'product' => $product,
        'discount' => $discount));
    }
    ?>
  </div>
  <div class="bold" style="font-size: 14pt">
    <span class="cufon">Сумма скидки </span><span id="cart-discount" class="cufon"></span>
  </div>
  <div class="bold" style="font-size: 26pt">
    <span class="cufon gray">Общая сумма заказа: </span>
    <span id="cart-summ" summ="<?php echo $sum; ?>" class="cufon red"><?php echo $sum; ?>.-</span>
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
        <div style="padding: 10px">Если заказ оформлен до 12:00, мы доставим его в этот же день до 20 часов без дополнительной наценки.</div>
        <div style="padding: 0 10px 10px">Если Вам удобнее приехать и забрать заказ самостоятельно, мы предлагаем воспользоваться нашим пунктом самовывоза.</div>
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
  <?php $this->endWidget() ?>
</div>
