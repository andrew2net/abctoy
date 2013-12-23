<?php
/* @var $this DefaultController */
/* @var $model Order */
/* @var $product Product */
/* @var $form CActiveForm */

$this->breadcrumbs = array(
  'Заказы' => array('index'),
  'Обработка заказа',
);
?>

<h3>Заказ № <?php echo $model->id; ?></h3>

<?php
$this->renderPartial('_form', array(
  'model' => $model,
  'product' => $product,
));
?>