<?php
/* @var $this ProductController */
/* @var $model Product */
?>

<?php
$this->breadcrumbs=array(
	'Товары'=>array('index'),
	'Новый',
);
?>

<h3>Новый товар</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>