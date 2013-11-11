<?php
/* @var $this ActionController */
/* @var $model Action */
?>

<?php
$this->breadcrumbs=array(
	'Акции'=>array('index'),
	'Новая',
);
?>

<h3>Новая акция</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>