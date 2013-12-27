<?php
/* @var $this DefaultController */
/* @var $payment CActiveDataProvider */

$this->breadcrumbs=array(
	'Виды оплаты',
);
?>
<h3>Виды оплаты</h3>

<?php
$this->widget('ext.bootstrap.widgets.TbGridView', array(
  'dataProvider' => $payment,
  'columns' => array(
    'name',
    'description',
    array(
      'class' => 'bootstrap.widgets.TbButtonColumn',
      'template' => '{update}',
    ),
  ),
));
?>
