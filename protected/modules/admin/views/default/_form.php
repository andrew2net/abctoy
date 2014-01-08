<?php
/* @var $this DefaultController */
/* @var $model Order */
/* @var $order_product OrderProduct[] */
/* @var $product Product[] */
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
          echo TbHtml::label('ФИО', 'fio');
          echo TbHtml::tag('div', array(
            'id' => 'fio',
            'class' => 'display-field', 'style' => 'width:16em'));
          echo $model->fio;
          echo TbHtml::closeTag('div');
          ?>
        </div>
        <?php echo TbHtml::activeTextFieldControlGroup($model, 'email'); ?>
        <?php echo TbHtml::activeTextFieldControlGroup($model, 'phone'); ?>
        <?php echo TbHtml::activeDropDownListControlGroup($model, 'call_time_id', $model->callTimes); ?>
      </div>
      <div class="inline-blocks">
        <div>
          <?php
          echo TbHtml::activeLabelEx($model, 'city');
          ?>
          <?php
          $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'model' => $model,
            'attribute' => 'city',
            'sourceUrl' => '/site/suggestcity',
            'htmlOptions' => array('style' => 'width: 16em')
          ));
          ?>
          <?php echo TbHtml::error($model, 'city'); ?>
        </div>
        <?php
        echo TbHtml::activeTextFieldControlGroup($model, 'address'
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
          $couponOptions = array(
            'id' => 'coupon_code',
            'class' => 'display-field',
            'style' => 'width:5em',
          );
          if (!is_null($model->coupon)) {
            $couponOptions['type_id'] = $model->coupon->type_id;
            $couponOptions['disc'] = $model->coupon->value;
          }
          echo TbHtml::label('Купон', 'coupon_code');
          echo TbHtml::tag('div', $couponOptions);
          echo is_null($model->coupon) ? '&nbsp' : $model->coupon->code;
          echo TbHtml::closeTag('div');
          ?>
        </div>

      </div>
    </div>
    <div style="vertical-align: top">
      <?php
      echo TbHtml::activeTextAreaControlGroup($model, 'description'
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
      <th></th>
    </tr>
    <?php
    $total = 0;
    $n = 0;
    foreach ($order_product as $key => $item) {
      $n++;
      $total += $item->quantity * $item->price;
      ?>
      <tr id="product-<?php echo $n; ?>" class="row-product">
        <td>
          <?php
          echo TbHtml::activeTextField($product[$key], "[$n]article", array(
            'readonly' => TRUE,
            'class' => 'row-article',
          ));
          ?>
        </td>
        <td style="width: 100%">
          <?php
          echo TbHtml::activeTextField($product[$key], "[$n]name", array(
            'class' => 'row-name',
            'block' => TRUE,
          ));
          ?>
        </td>
        <td>
          <?php
          echo TbHtml::activeNumberField($item, "[$n]quantity"
              , array('class' => 'row-quantity'));
          ?>
        </td>
        <td>
          <?php
          echo TbHtml::activeNumberField($item, "[$n]price"
              , array('class' => 'row-price', 'disc' => $item->discount));
          ?>
        </td>
        <td><?php
          echo TbHtml::icon(TbHtml::ICON_TRASH, array(
            'class' => 'row-del',
            'style' => 'cursor:pointer' . (count($order_product) == 1 ? ';display:none' : ''),
            'rel' => 'tooltip',
            'title' => 'Удалить',
          ));
          ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="3"><div style="text-align: right">Стоимость доставки: </div></td>
      <td>
        <?php
        echo TbHtml::activeNumberField($model, 'delivery_summ', array(
          'id' => 'order-delivery-summ',
        ));
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="3"><div style="text-align: right">Скидка по купону: </div></td>
      <td>
        <?php
        echo TbHtml::tag('div', array(
          'name' => 'order_coupon_discount',
          'class' => 'display-field',
//          'style' => 'width:11.5em',
          'id' => 'order-coupon-discount'));
        echo $model->delivery_summ;
        echo TbHtml::closeTag('div');
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php
        echo TbHtml::linkButton('Добавить', array(
          'id' => 'add-product',
          'color' => TbHtml::BUTTON_COLOR_PRIMARY,
        ));
        ?>
      </td><td colspan="2"><div style="text-align: right">Итого: </div></td>
      <td>
        <?php
        $total += $model->delivery_summ;
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
    var noDiscSum = 0;
    $('.row-price').each(function() {
      var price = parseFloat(this.value);
      if (isNaN(price))
        price = 0;
      var priceid = this.id;
      var quantityid = priceid.replace('price', 'quantity');
      var quantity = parseInt($('#' + quantityid).val());
      if (isNaN(quantity))
        quantity = 0;
      var disc = $(this).attr('disc');
      var s = price * quantity;
      if (disc == 0)
        noDiscSum += s;
      sum += s;
    });
    var couponType = $('#coupon_code').attr('type_id');
    var couponDisc = parseFloat($('#coupon_code').attr('disc'));
    var couponSum = 0;
    switch (couponType) {
      case '0':
        couponSum = noDiscSum > couponDisc ? couponDisc : noDiscSum;
        break;
      case '1':
        couponSum = noDiscSum * couponDisc / 100;
        break;
    }
    var delivery = parseFloat($('#order-delivery-summ').val());
    if (isNaN(delivery))
      delivery = 0;
    sum += delivery;
    sum -= couponSum;
    $('#order-total').html(sum);
    $('#order-coupon-discount').html(couponSum);
  }

  function setStatus() {
    var stat = $('#Order_status_id').val();
    var read = true;
    if (stat === '0' || stat === '1')
      read = false;
    $('.row-quantity, .row-price').each(function() {
      $(this).prop('readonly', read);
    });
    $('#order-delivery-summ').prop('readonly', read);
  }

  calcSumm();
  setStatus();

  $('table').on('keyup change', '.row-price, .row-quantity, #order-delivery-summ', function() {
    calcSumm();
  });

  $('#Order_status_id').change(function() {
    setStatus();
  });

  var response = function(event, ui) {
    for (var i = 0; i < ui.content.length; i++) {
      ui.content[i].label = ui.content[i].article + ', ' + ui.content[i].value;
    }
  }

  var selectItem = function(event, ui) {
    var row = $(this).parent().parent();
    row.find('.row-article').val(ui.item.article);
    var price = row.find('.row-price');
    $(price).val(ui.item.price);
    $(price).attr('disc', ui.item.disc);
    calcSumm();
  }

  var incAttr = function(match) {
    return parseInt(match) + 1;
  }

  $('#add-product').click(function(event) {
    event.preventDefault();
    var row = $('.row-product').last();
    var newrow = row.clone();
    newrow[0].id = newrow[0].id.replace(/\d+/, incAttr);
    var art = $(newrow).find('.row-article');
    art[0].id = art[0].id.replace(/\d+/, incAttr);
    art[0].name = art[0].name.replace(/\d+/, incAttr);
    art[0].value = '';
    var name = $(newrow).find('.row-name');
    name[0].id = name[0].id.replace(/\d+/, incAttr);
    name[0].name = name[0].name.replace(/\d+/, incAttr);
    name[0].value = '';
    $(name).autocomplete({
      source: '/admin/default/orderproduct',
      response: response,
      select: selectItem
    });
    var quantity = $(newrow).find('.row-quantity');
    quantity[0].id = quantity[0].id.replace(/\d+/, incAttr);
    quantity[0].name = quantity[0].name.replace(/\d+/, incAttr);
    quantity[0].value = '1';
    var price = $(newrow).find('.row-price')
    price[0].id = price[0].id.replace(/\d+/, incAttr);
    price[0].name = price[0].name.replace(/\d+/, incAttr);
    price[0].value = '0.00';
    $(newrow).insertAfter(row);
    $('.row-del').css('display', 'block');
  });

  $('table').on('click', '.row-del', function() {
    $(this).parent().parent().remove();
    if ($('.row-product').length ===1)
      $('.row-del').css('display', 'none');
    calcSumm();
  });

  $(function() {
    ($('.row-name').autocomplete({
      source: '/admin/default/orderproduct',
      response: response,
      select: selectItem
    }))
  });

</script>