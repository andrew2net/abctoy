<?php
/* @var $this PageController */
/* @var $model Page */
?>

<?php
$this->breadcrumbs=array(
	'Страницы'=>array('admin'),
//	$model->title=>array('view','id'=>$model->id),
	'Изменение',
);

$this->menu=array(
	array('label'=>'List Page', 'url'=>array('index')),
	array('label'=>'Create Page', 'url'=>array('create')),
	array('label'=>'View Page', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Page', 'url'=>array('admin')),
);
?>

    <h3>Изменение страницы <?php echo $model->url; ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
