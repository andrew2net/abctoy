<?php
/* @var $this ActionController */
/* @var $model Action */
?>

<?php
$this->breadcrumbs = array(
  'Акции' => array('index'),
  'Изменение',
);
?>

<h3>Изменение <?php echo $model->type . ' ' . $model->name; ?></h3>

<?php $this->renderPartial('_form', array('model' => $model)); ?>