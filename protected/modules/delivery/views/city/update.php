<?php
/* @var $this CityController */
/* @var $model City */
?>

<?php
$this->breadcrumbs = array(
  'Города' => array('index'),
  'Изменение',
);
?>

<h3>Изменение города <?php echo $model->name; ?></h3>

<?php $this->renderPartial('_form', array('model' => $model)); ?>