<?php
/* @var $this PageController */
/* @var $model Page */
?>

<?php
$this->breadcrumbs = array(
  'Страницы' => array('/admin/page'),
  $model->title,
);

$this->menu = array(
  array('label' => 'List Page', 'url' => array('index')),
  array('label' => 'Create Page', 'url' => array('create')),
  array('label' => 'Update Page', 'url' => array('update', 'id' => $model->id)),
  array('label' => 'Delete Page', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
  array('label' => 'Manage Page', 'url' => array('admin')),
);
?>

<!--<h1>View Page #<?php echo $model->id; ?></h1>-->

<?php
//$this->widget('zii.widgets.CDetailView', array(
//  'htmlOptions' => array(
//    'class' => 'table table-striped table-condensed table-hover',
//  ),
//  'data' => $model,
//  'attributes' => array(
//    'id',
//    'url',
//    'title',
//    'content',
//  ),
//));
echo $model->content;
?>
