<?php
/* @var $this ActionController */
/* @var $model Action */
/* @var $form TbActiveForm */
?>

<div class="form">

  <?php
  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'action-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
  ));
  ?>

  <p class="help-block"><span class="required">*</span> Обязательные поля.</p>

  <?php echo $form->errorSummary($model); ?>

  <input id="Action_img" name="Action[img]" type="text" value="<?php echo $model->img ?>" style="display: none">

  <div id="upload-container" style="float: right">
    <div id="upload1" 
         style="width: 700px; height: 200px; line-height: 200px; border: 1px solid" class="noimg">
      <img id="img" alt="Изображение" height="200px" width="700px" class="img"
           style="text-align: center" src="<?php echo $model->img ?>">
    </div>
  </div>

  <div style="height: 200px">
    <?php
    echo $form->dropDownListControlGroup($model, 'type_id'
        , $model->types, array('span' => 2));
    ?>

    <?php echo $form->textFieldControlGroup($model, 'name', array('span' => 4, 'maxlength' => 30)); ?>
  </div>Новое
  <div id="action-data" style="display: none">
    <?php echo $form->textAreaControlGroup($model, 'text', array('rows' => 6, 'span' => 5)); ?>

    <?php echo TbHtml::label('Дата окончания', 'Action_date'); ?>
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
      'model' => $model,
      'attribute' => 'date',
      'language' => 'ru',
    ));
    ?>

    <?php echo $form->textFieldControlGroup($model, 'product_id', array('span' => 5, 'maxlength' => 11)); ?>
  </div>

  <div class="form-actions">
    <?php
    echo TbHtml::linkButton('Закрыть', array(
      'url' => '/admin/discount/action/index'));
    ?>
    <?php
    echo TbHtml::submitButton('Сохранить', array(
      'color' => TbHtml::BUTTON_COLOR_PRIMARY,
      'size' => TbHtml::BUTTON_SIZE_SMALL,
    ));
    ?>
    <?php
    echo TbHtml::button('Удалить изображение', array(
      'color' => TbHtml::BUTTON_COLOR_DEFAULT,
      'size' => TbHtml::BUTTON_SIZE_SMALL,
      'id' => 'delImg',
      'class' => 'pull-right',
    ));
    ?>
  </div>

  <?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ocupload-1.1.2.js"></script>
<script type="text/javascript">
  $('#upload1').upload({
    name: 'file',
    container: '#upload-container',
    method: 'post',
    enctype: 'multipart/form-data',
    action: '/admin/discount/action/upload',
    onSubmit: function() {
      $('#img').hide();
      $('#upload1').removeClass('noimg').addClass('loading');
    },
    onComplete: function(data) {
      $('#upload1').removeClass('loading');
      $('#img').prop('src', data).show();
      $('#Action_img').prop('value', data);
    }
  });
  $('#delImg').on('click', function() {
    $('#upload1').addClass('noimg');
    $('#img').prop('src', '');
    $('#Action_img').prop('value', '');
  });
  $('#Action_type_id').on('change', function() {
    switch ($(this).val()) {
      case "0":
        $('#action-data').css('display', 'none');
        break;
      case "1":
        $('#action-data').css('display', 'inherit');
        break;
    }
  });
</script>
