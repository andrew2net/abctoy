<?php
/* @var $this CouponController */
/* @var $model Coupon */
/* @var $form TbActiveForm */
?>

<div class="form">

  <?php
  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'coupon-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
  ));
  ?>

  <p class="help-block"><span class="required">*</span> Обязательные поля.</p>

  <?php echo $form->errorSummary($model); ?>

  <div class="inline-blocks">
    <div>
      <?php echo $form->textFieldControlGroup($model, 'code', array('span' => 2, 'maxlength' => 8)); ?>
    </div>
    <div>
      <?php
      echo $form->dropDownListControlGroup($model, 'used_id'
          , $model->usedValues, array('span' => 2));
      ?>
    </div>
  </div>

  <div class="inline-blocks">
    <div>
      <?php echo $form->textFieldControlGroup($model, 'value', array('span' => 2, 'maxlength' => 5)); ?>
    </div>
    <div>
      <?php
      echo $form->dropDownListControlGroup($model, 'type_id'
          , $model->types, array('span' => 2));
      ?>
    </div>
  </div>
  <div class="form-actions">
    <?php
    echo TbHtml::linkButton('Закрыть', array(
      'url' => '/admin/discount/coupon/index'));
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