<?php
/* @var $this CityController */
/* @var $model City */
?>

<?php
$this->breadcrumbs=array(
	'Города'=>array('index'),
	'Новый',
);
?>

<h3>Новый город</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>