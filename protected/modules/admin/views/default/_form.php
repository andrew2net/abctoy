<?php
/* @var $this DefaultController */
/* @var $model Order */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'profile_id'); ?>
		<?php echo $form->textField($model,'profile_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'profile_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_id'); ?>
		<?php echo $form->textField($model,'coupon_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'coupon_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delivery_id'); ?>
		<?php echo $form->textField($model,'delivery_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'delivery_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_id'); ?>
		<?php echo $form->textField($model,'payment_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'payment_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status_id'); ?>
		<?php echo $form->textField($model,'status_id'); ?>
		<?php echo $form->error($model,'status_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->