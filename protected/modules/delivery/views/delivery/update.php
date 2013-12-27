<?php
/* @var $this DeliveryController */
/* @var $model Delivery */
?>

<?php
$this->breadcrumbs = array(
  'Виды доставки' => array('index'),
  'Изменение',
);
?>

<h3>Изменение вида доставки <?php echo $model->name; ?></h3>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
