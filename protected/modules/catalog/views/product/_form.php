<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form TbActiveForm */
?>

<div class="form">

  <?php
  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'product-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
  ));
  ?>
  <?php
  echo TbHtml::tabbableTabs(array(
    array(
      'label' => 'Товар',
      'active' => true,
      'content' => $this->renderInternal(
          Yii::getPathOfAlias('application.modules.catalog.views.product')
          . DIRECTORY_SEPARATOR . '_product.php', array(
        'model' => $model,
        'form' => $form,
          ), true)
    ),
    array(
      'label' => 'Категории',
      'content' => $this->renderInternal(
          Yii::getPathOfAlias('application.modules.catalog.views.product')
          . DIRECTORY_SEPARATOR . '_category.php', array(
        'model' => $model,
        'form' => $form,
          ), true),
    ))
  );
  ?>
  <div class="form-actions">
    <?php
    echo TbHtml::linkButton('Закрыть', array(
      'url' => '/admin/catalog/product/index'));
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

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ocupload-1.1.2.js"></script>
<script type="text/javascript">
  $('#upload1').upload({
    name: 'file',
    container: '#upload-container',
    method: 'post',
    enctype: 'multipart/form-data',
    action: '/admin/catalog/product/upload',
    onSubmit: function() {
      $('#img1').hide();
      $('#upload1').removeClass('noimg').addClass('loading');
    },
    onComplete: function(data) {
      $('#upload1').removeClass('loading');
      $('#img1').prop('src', data).show();
      $('#Product_img').prop('value', data);
    }
  });
  $('#upload2').upload({
    name: 'fileMini',
    container: '#upload-container2',
    method: 'post',
    enctype: 'multipart/form-data',
    action: '/admin/catalog/product/upload',
    onSubmit: function() {
      $('#img2').hide();
      $('#upload2').removeClass('noimg').addClass('loading');
    },
    onComplete: function(data) {
      $('#upload2').removeClass('loading');
      $('#img2').prop('src', data).show();
      $('#Product_small_img').prop('value', data);
    }
  });
  $('#delImg').on('click', function() {
    $('#upload1').addClass('noimg');
    $('#img1').prop('src', '');
    $('#Product_img').prop('value', '');
  });
  $('#delImg2').on('click', function() {
    $('#upload2').addClass('noimg');
    $('#img2').prop('src', '');
    $('#Product_small_img').prop('value', '');
  });
</script>
