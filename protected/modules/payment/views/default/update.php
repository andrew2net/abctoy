<?php

/* @var $this PaymentController */
/* @var $payment Payment */

$this->breadcrumbs = array(
  'Виды оплаты' => array('index'),
  'Изменение',
);
?>
<h3>Изменение вида оплаты <i><?php echo $payment->name; ?></i></h3>


<div class="form">
  <?php
  $form = $this->beginWidget('ext.bootstrap.widgets.TbActiveForm');
  ?>
  <p class="help-block"><span class="required">*</span> Обязательные поля.</p>

  <?php echo $form->errorSummary($payment); ?>

  <?php echo TbHtml::activeTextFieldControlGroup($payment, 'name'); ?>
  <?php echo TbHtml::activeTextAreaControlGroup($payment, 'description', array(
    'class'=>'span6'
  )); ?>
  <?php echo TbHtml::activeTextFieldControlGroup($payment, 'type', array(
    'readOnly' => true
  )); ?>
  
  <?php 
  if ($payment->type_id==1){
    echo TbHtml::activeTextFieldControlGroup($payment, 'mnt_id');
    echo TbHtml::activeTextFieldControlGroup($payment, 'mnt_signature', array(
    'class'=>'span5'
  ));
  }
  ?>

  <div class="form-actions">
    <?php
    echo TbHtml::linkButton('Закрыть', array(
      'url' => '/admin/payment'));
    ?>
    <?php
    echo TbHtml::submitButton('Сохранить', array(
      'color' => TbHtml::BUTTON_COLOR_PRIMARY,
      'size' => TbHtml::BUTTON_SIZE_SMALL,
    ));
    ?>
  </div>
  
  <?php $this->endWidget() ?>
</div>
