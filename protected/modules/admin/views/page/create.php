<?php
/* @var $this PageController */
/* @var $model Page */
?>

<?php
$this->breadcrumbs=array(
	'Страницы'=>array('admin'),
	'Новая',
);

$this->menu=array(
	array('label'=>'List Page', 'url'=>array('index')),
	array('label'=>'Manage Page', 'url'=>array('admin')),
);
?>

<h3>Новая страница</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
