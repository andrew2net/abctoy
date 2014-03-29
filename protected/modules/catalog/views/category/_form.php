<!--
 /**
  * Form for JsTreeBehavior model.
  *
  * Date: 1/29/13
  * Time: 12:00 PM
  *
  * @author: Spiros Kabasakalis <kabasakalis@gmail.com>
  * @link http://iws.kabasakalis.gr/
  * @link http://www.reverbnation.com/spiroskabasakalis
  * @copyright Copyright &copy; Spiros Kabasakalis 2013
  * @license http://opensource.org/licenses/MIT  The MIT License (MIT)
  * @version 1.0.0
  */
-->

<?php if ($model->isNewRecord) : ?>
  <h3><?php echo Yii::t('global', 'Create') ?> <?php echo Yii::t('global', $modelClassName) ?></h3>
<?php elseif (!$model->isNewRecord): ?>
  <h3><?php echo Yii::t('global', 'Update') ?> <?php echo Yii::t('global', $modelClassName) ?></h3>
<?php endif; ?>

<!--<p> <h2><?php // echo $model->name;  ?></h2><p>-->

<?php
$val_error_msg = Yii::t('global', "Error. $modelClassName was not saved.");
$val_success_message = ($model->isNewRecord) ?
    Yii::t('global', "$modelClassName has been created successfully.") :
    Yii::t('global', "$modelClassName has been updated successfully.");
?>

<div id="success-note" class="alert alert-success"
     style="display:none;">
       <?php echo $val_success_message; ?>
</div>

<div id="error-note" class="alert alert-error"
     style="display:none;">
       <?php echo $val_error_msg; ?>
</div>

<div id="ajax-form" class='form'>
  <?php
  $formId = "$modelClassName-form";

  $actionUrl = ($model->isNewRecord) ?
      (!isset($_POST['create_root']) ? CController::createUrl($this->id . '/createnode') : CController::createUrl($this->id . '/createRoot')) :
      CController::createUrl($this->id . '/updatenode');

  $form = $this->beginWidget('CActiveForm', array(
    'id' => $formId,
    //  'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'action' => $actionUrl,
    // 'enableAjaxValidation'=>true,
//    'enableClientValidation' => true,
    'focus' => array($model, 'name'),
    'errorMessageCssClass' => 'alert alert-error',
    'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnType' => false,
      'inputContainer' => '.control-group',
      'errorCssClass' => 'error',
      'successCssClass' => 'success',
      'afterValidate' => 'js:function(form,data,hasError){$.js_afterValidate(form,data,hasError);  }',
    ),
  ));
  ?>

  <?php
  echo $form->errorSummary($model, '<div style="font-weight:bold">Пожалуйста исправьте следующие ошибки:</div>', NULL, array('class' => 'alert alert-error')
  );
  ?>
  <p class="note"><span class="required">*</span> Обязательные поля.</p>
  <fieldset>


    <!--
    Modify the input fields according to your model.
    -->
    <div class="control-group">
      <?php echo $form->labelEx($model, 'name', array('class' => 'control-label')); ?>
      <div class="controls">
        <?php // $name = (!$model->isNewRecord) ? $model->name : '' ?>
        <?php echo $form->textField($model, 'name', array('class' => 'span4', 'size' => 30, 'maxlength' => 30)); ?>
        <p class="help-block"><?php echo $form->error($model, 'name'); ?></p>
      </div>
    </div>

    <div class="control-group">
      <!--            <?php // echo $form->labelEx($model, 'url', array('class' => 'control-label'));     ?>
                  <div class="controls">
      <?php //  $url=(!$model->isNewRecord)?$model->url:''   ?>
      <?php // echo $form->textField($model, 'url', array('value' => $url, 'class' => 'span4', 'size' => 60, 'maxlength' => 255));  ?>
                      <p class="help-block"><?php // echo $form->error($model, 'url');    ?></p>
                  </div>-->
      <input id="Category_url" name="Category[url]" type="text" value="<?php echo $model->url ?>" style="display: none">

      <div id="upload-container">
        <div id="upload1" 
             style="width: 105px; height: 105px; line-height: 105px; border: 1px solid" class="noimg">
          <img id="image1" alt="Изображение" class="img"
               style="text-align: center; max-height: 105px; max-width: 105px" src="<?php echo $model->url ?>">
        </div>
      </div>
      <?php
      echo TbHtml::button('Удалить изображение', array(
        'color' => TbHtml::BUTTON_COLOR_DEFAULT,
        'size' => TbHtml::BUTTON_SIZE_SMALL,
        'id' => 'del_img'
      ));
      ?>
    </div>

    <input type="hidden" name="YII_CSRF_TOKEN"
           value="<?php echo Yii::app()->request->csrfToken; ?>"/>
    <input type="hidden" name= "parent_id" value="<?php echo isset($_POST['parent_id']) ? $_POST['parent_id'] : ''; ?>"  />

    <?php if (!$model->isNewRecord): ?>
      <input type="hidden" name="update_id"
             value="<?php echo $model->id; ?>"/>
           <?php endif; ?>
    <div class="control-group">
      <?php
      echo CHtml::button($model->isNewRecord ? Yii::t('global', 'Submit') : Yii::t('global', 'Save'), array(
        'class' => 'btn btn-primary pull-right',
        'id' => 'submit-category'
      ));
      ?>
    </div>
  </fieldset>
  <?php $this->endWidget(); ?>
</div>
<!-- form -->

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ocupload-1.1.2.js"></script>
<script type="text/javascript">
  $('#upload1').upload({
    name: 'file',
    container: '#upload-container',
    method: 'post',
    enctype: 'multipart/form-data',
    action: '/admin/catalog/category/upload',
    onSubmit: function() {
      $('#image1').hide();
      $('#upload1').removeClass('noimg').addClass('loading');
    },
    onComplete: function(data) {
      $('#upload1').removeClass('loading');
      $('#image1').prop('src', data).show();
      $('#Category_url').prop('value', data);
    }
  });
  $('#del_img').on('click', function() {
    $('#upload1').addClass('noimg');
    $('#image1').prop('src', '');
    $('#Category_url').prop('value', '');
  });
</script>
