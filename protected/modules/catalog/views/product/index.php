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
</div>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
  'id' => 'product-grid',
  'dataProvider' => $model->search(),
  'filter' => $model,
  'columns' => array(
    'name',
    'article',
    array(
      'name' => 'brand_id',
      'value' => '$data->brand->name',
      'filter' => $model->getBrandOptions(),
    ),
    'age',
    array(
      'name' => 'gender_id',
      'value' => '$data->gender',
      'filter' => $model->genders,
    ),
    'remainder',
    'price',
    array(
      'name'=>'show_me',
      'value'=>'$data->show_me ? "Да" : "Нет"',
      'filter'=>array(0=>'Нет', 1=>'Да'),
      ),
    array(
      'class' => 'bootstrap.widgets.TbButtonColumn',
      'template'=>'{update}{delete}',
    ),
  )
    )
);
?>
<?php $this->endContent(); ?>