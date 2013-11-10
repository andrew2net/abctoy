<?php
/* @var $this CityController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs = array(
  'Города',
);
?>
<?php $this->beginContent('/layout/menu'); ?>

<h3>Города</h3>

<div class="btn-toolbar">
  <?php
  echo TbHtml::linkButton(
      'Добавить город', array(
    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
    'url' => array('/admin/delivery/city/create'),
      )
  );
  ?>
</div>

<?php
$this->widget('ext.bootstrap.widgets.TbGridView', array(
  'dataProvider' => $dataProvider,
  'columns' => array(
    'name',
    array(
      'class' => 'bootstrap.widgets.TbButtonColumn',
      'template' => '{update}{delete}',
    ),
  ),
));
?>
<?php $this->endContent(); ?>