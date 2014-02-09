<?php
/* @var $this CityController */
/* @var $model City */
/* @var $form TbActiveForm */
?>

<div class="form">

  <?php
  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'city-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
  ));
  ?>

  <p class="help-block"><span class="required">*</span> Обязательные поля.</p>

  <?php echo $form->errorSummary($model); ?>

  <div class="control-group">
    <?php echo TbHtml::label('Наименование', 'city_name', array('required' => TRUE)); ?>
    <?php
    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
      'id' => 'city_name',
      'name' => 'name',
      'model' => $model,
      'attribute' => 'name',
      'sourceUrl' => '/admin/delivery/city/suggestcity',
    ));
    ?>
  </div>
  <div class="control-group">
    <table>
      <th colspan="2">
        <?php echo TbHtml::label('Способы доставки', 'delivery'); ?>
      </th>
      <th></th>
      <th>
        <?php echo TbHtml::label('Стоимость', 'price'); ?>
      </th>
      <th>
        <?php echo TbHtml::label('Сумма заказа', 'summ'); ?>
      </th>
      <?php
      $delivery = Delivery::model()
          ->with(array(
            'cityDeliveries' => array(
              'on' => 'cityDeliveries.city_id=:city_id',
              'params' => array(':city_id' => $model->id),
        )))
          ->findAll();
      foreach ($delivery as $value) {
        if (isset($value->cityDeliveries[0])) {
          $checked = TRUE;
          $priceValue = $value->cityDeliveries[0]->price;
          $summValue = $value->cityDeliveries[0]->summ;
        }
        else {
          $checked = FALSE;
          $priceValue = '';
          $summValue = '';
        }
        ?>
        <tr>
          <td style="width: 1em">
            <?php echo TbHtml::checkBox('delivery[' . $value->id . ']', $checked); ?>
          </td>
          <td><?php echo $value->name; ?></td>
          <td><?php echo $value->description; ?></td>
          <td>
            <?php echo TbHtml::textField('price[' . $value->id . ']', $priceValue); ?>
          </td>
          <td>
            <?php echo TbHtml::textField('summ[' . $value->id . ']', $summValue); ?>
          </td>
        </tr>
        <?php
      }
      ?>
    </table>
  </div>
  <div class="form-actions">
    <?php
    echo TbHtml::linkButton('Закрыть', array(
      'url' => '/admin/delivery/city/index'));
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