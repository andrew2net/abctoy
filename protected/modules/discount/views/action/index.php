<?php
/* @var $this ActionController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs = array(
  'Акции',
);
?>
<?php $this->beginContent('/discount/menu'); ?>
<h3>Акции</h3>

<div class="btn-toolbar">
  <?php
  echo TbHtml::linkButton(
      'Добавить акцию', array(
    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
    'url' => array('/admin/discount/action/create'),
      )
  );
  ?>
</div>

<?php
$this->widget('ext.bootstrap.widgets.TbGridView', array(
  'dataProvider' => $dataProvider,
  'columns' => array(
    array(
      'name'=>'type_id',
      'value'=>'$data->type',
      ),
    'name',
    'date',
    'product_id',
    array(
      'class' => 'bootstrap.widgets.TbButtonColumn',
      'template' => '{update}{delete}',
    ),
  ),
));
?>
<?php $this->endContent(); ?>