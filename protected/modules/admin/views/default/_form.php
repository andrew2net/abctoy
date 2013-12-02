<?php
/* @var $this DefaultController */
/* @var $model Order */
/* @var $product OrderProduct[] */
/* @var $profile CustomerProfile */
/* @var $form CActiveForm */
?>

<div class="form">

  <?php
  $form = $this->beginWidget('ext.bootstrap.widgets.TbActiveForm', array(
    'id' => 'order-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
  ));
  ?>

  <p class="note"><span class="required">*</span> обязательные поля.</p>

  <?php echo $form->errorSummary($model); ?>

  <div class="inline-blocks">
    <div>
      <div class="inline-blocks">
        <div class="control-group">
          <?php
          echo TbHtml::label('ФИО', 'profile_fio');
          echo TbHtml::tag('div', array(
            'id' => 'profile_fio',
            'class' => 'display-field', 'style' => 'width:16em'));
          echo is_null($model->profile) ? '&nbsp' : $model->profile->fio;
          echo TbHtml::closeTag('div');
          ?>
        </div>
        <?php echo TbHtml::activeTextFieldControlGroup($profile, 'email'); ?>
        <?php echo TbHtml::activeTextFieldControlGroup($profile, 'phone'); ?>
        <?php echo TbHtml::activeDropDownListControlGroup($profile, 'call_time_id', $profile->callTimes); ?>
      </div>
      <div class="inline-blocks">
        <div>
          <?php
          echo TbHtml::activeLabelEx($profile, 'city');
          ?>
          <?php
          $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'model' => $profile,
            'attribute' => 'city',
            'sourceUrl' => '/site/suggestcity',
            'htmlOptions' => array('style' => 'width: 16em')
          ));
          ?>
          <?php echo TbHtml::error($profile, 'city'); ?>
        </div>
        <?php
        echo TbHtml::activeTextFieldControlGroup($profile, 'address'
            , array('span' => 7));
        ?>

      </div>
      <div class="inline-blocks">

        <?php
        echo $form->textFieldControlGroup($model, 'time', array(
          'style' => 'width:10em',
          'readonly' => TRUE));
        ?>

        <?php
        echo $form->dropDownListControlGroup($model, 'delivery_id'
            , $model->deliveryOptions);
        ?>

        <?php
        echo $form->dropDownListControlGroup($model, 'payment_id'
            , $model->paymentOptions);
        ?>

        <?php
        echo $form->dropDownListControlGroup($model, 'status_id'
            , $model->statuses);
        ?>

        <div class="control-group">
          <?php
          echo TbHtml::label('Купон', 'coupon_code');
          echo TbHtml::tag('div', array(
            'id' => 'coupon_code',
            'class' => 'display-field',
            'style' => 'width:5em'
          ));
          echo is_null($model->coupon) ? '&nbsp' : $model->coupon->code;
          echo TbHtml::closeTag('div');
          ?>
        </div>

      </div>
    </div>
    <div style="vertical-align: top">
      <?php
      echo TbHtml::activeTextAreaControlGroup($profile, 'description'
          , array('span' => 3, 'rows' => 8));
      ?>
    </div>
  </div>
  <table>
    <tr>
      <th>
        <?php echo TbHtml::label('Артикул', 'product_articles'); ?>
      </th>
      <th>
        <?php echo TbHtml::label('Наименование', 'product_name'); ?>
      </th>
      <th style="width: 4em">
        <?php echo TbHtml::label('Количество', 'product_quantity'); ?>
      </th>
      <th style="width: 4em">
        <?php echo TbHtml::label('Цена', 'product_price'); ?>
      </th>
    </tr>
    <?php
    $total = 0;
    foreach ($product as $item) {
      $total += $item->quantity * $item->price;
      ?>
      <tr>
        <td>
          <?php
          echo TbHtml::tag('div', array('name' => 'product_articles', 'class' => 'display-field'));
          echo $item->product->article;
          echo TbHtml::closeTag('div');
          ?>
        </td>
        <td>
          <?php
          echo TbHtml::tag('div', array('name' => 'product_name', 'class' => 'display-field'));
          echo $item->product->name;
          echo TbHtml::closeTag('div');
          ?>
        </td>
        <td>
          <?php
          echo TbHtml::activeNumberField($item, "[$item->product_id]quantity"
              , array('class' => 'row-quantity'));
          ?>
        </td>
        <td>
          <?php
          echo TbHtml::activeNumberField($item, "[$item->product_id]price"
              , array('class' => 'row-price'));
          ?>
        </td>
      </tr>
    <?php } ?>
    <tr>
      <td></td><td></td><td><div style="text-align: right">Итого: </div></td>
      <td>
        <?php
        echo TbHtml::tag('div', array(
          'name' => 'order_total',
          'class' => 'display-field',
//          'style' => 'width:11.5em',
          'id' => 'order-total'));
        echo $total;
        echo TbHtml::closeTag('div');
        ?>
      </td>
    </tr>
  </table>
  <div class="form-actions">
    <?php
    echo TbHtml::linkButton('Закрыть', array(
      'url' => '/admin'));
    ?>
    <?php
    echo TbHtml::submitButton('Сохранить', array(
      'color' => TbHtml::BUTTON_COLOR_PRIMARY,
      'size' => TbHtml::BUTTON_SIZE_SMALL,
    ));
    ?>
  </div>
  <?php $this->endWidget(); ?>
</div><!-- form -->
<script type="text/javascript">

  function calcSumm() {
    var sum = 0;
    $('.row-price').each(function() {
      var price = parseInt(this.value);
      var priceid = this.id;
      var quantityid = priceid.replace('price', 'quantity');
      var quantity = parseInt($('#' + quantityid).val());
      sum += price * quantity;
    });
    $('#order-total').html(sum);
  }

  $('.row-price').change(function() {
    calcSumm();
  });

  $('.row-quantity').change(function() {
    calcSumm();
  });
</script>