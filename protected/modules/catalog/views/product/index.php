<?php
/* @var $this ProductController */
/* @var $model Product */
?>

<?php
$this->breadcrumbs = array(
  'Товары',
);
?>

<?php $this->beginContent('/catalog/menu'); ?>
<h3>Товары</h3>

<div class="btn-toolbar">
  <?php
  echo TbHtml::linkButton(
      'Добавить товар', array(
    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
    'url' => array('/admin/catalog/product/create'),
      )
  );
  ?>
  <?php
  echo TbHtml::beginFormTb(TbHtml::FORM_LAYOUT_INLINE
      , '/admin/catalog/product/productUpload', 'post', array(
    'class' => 'pull-right',
    'enctype' => 'multipart/form-data',
  ));
  ?>
  <?php
  echo TbHtml::activeFileField($importData, 'productFile'
      , array(
    'id' => 'fileToUpload',
      )
  );
  ?>
  <?php
  echo TbHtml::checkBox('upload_image', FALSE, array('id' => 'uploadImage',
    'style' => 'vertical-align:baseline;margin-right:5px'
  ));
  echo TbHtml::label('Загружать изображения', 'upload_image');
  ?>
  <?php
  echo TbHtml::endForm();
  ?>
</div>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
  'id' => 'product-grid',
  'dataProvider' => $model->search(),
  'filter' => $model,
  'columns' => array(
    array(
      'name' => 'name',
      'value' => 'mb_substr($data->name,0,40,"utf-8")'
    ),
    'article',
    array(
      'name' => 'brand_id',
      'value' => '$data->brand->name',
      'filter' => $model->getBrandOptions(),
    ),
//    'age',
//    'age_to',
    array(
      'name' => 'gender_id',
      'value' => '$data->gender',
      'filter' => $model->genders,
    ),
    'remainder',
    'price',
    array(
      'name' => 'show_me',
      'value' => '$data->show_me ? "Да" : "Нет"',
      'filter' => array(0 => 'Нет', 1 => 'Да'),
    ),
    array(
      'class' => 'bootstrap.widgets.TbButtonColumn',
      'template' => '{update}{delete}',
    ),
  )
    )
);
?>
<?php $this->endContent(); ?>
<?php
$this->widget('bootstrap.widgets.TbModal', array(
  'id' => 'productUploadModel',
  'header' => 'Загрузка товаров',
  'content' => TbHtml::animatedProgressBar(0, array('id' => 'uploadProgress')),
  'footer' => array(
//    TbHtml::button('Save Changes', array('data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::button('Отмена', array('id' => 'cancelUpload')),
  ),
));
?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.iframe-transport.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.fileupload.js'); ?>
<script type="text/javascript">
  $(function() {
    var i;
    var lines;
    function uploadData() {
      var n = 0;
      var postData = [];
      while (n < 20 && i < lines.length) {
        postData.push(lines[i]);
        n++;
        i++;
      }
      var uploadImage = $('#uploadImage').prop('checked');
      $.post('/admin/catalog/product/productUpload',
              {
                data: postData,
                uploadImage: uploadImage
              }, function(data) {
        if (data === 'ok') {
          uploadCallBack();
        } else {
          closeModal(data);
        }
      });
    }

    var uploadCallBack = function() {
      var percent = Math.round(i / lines.length * 100);
      var width = percent + '%';
      $('#uploadProgress .bar').css('width', width);
      if (i < lines.length)
        uploadData();
      else
        closeModal();
    }

    $('#fileToUpload').change(function(event) {
      var input = event.target;

      var reader = new FileReader();
      reader.onload = function(event) {
        var reader = event.target;
        var dataURL = reader.result;
        lines = dataURL.split(/\r\n/g);
        i = 1;
        $('#productUploadModel').modal('show');
        uploadData()
      }
      reader.readAsText(input.files[0]);
    });

    function uploadProgress() {
      $.get('/admin/catalog/product/uploadProgress', function(data) {
        $('#uploadProgress .bar').css('width', data);
      });
    }

    function closeModal(data) {
      i = lines.length;
      $('#productUploadModel').modal('hide');
      $('#uploadProgress .bar').css('width', '0%');
      if (data)
        alert('Ошибка загрузки: ' + data);
      jQuery('#product-grid').yiiGridView('update', {
        type: 'POST',
        url: jQuery(this).attr('href')
      });
    }

    $('#cancelUpload, #productUploadModel .close').click(function() {
      closeModal();
    });
  });

</script>