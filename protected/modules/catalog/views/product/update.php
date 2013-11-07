<?php
/* @var $this ProductController */
/* @var $model Product */
?>

<?php
$this->breadcrumbs=array(
	'Товары'=>array('index'),
	$model->name,
);
?>

    <h3>Изменение товара: <?php echo $model->name; ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>