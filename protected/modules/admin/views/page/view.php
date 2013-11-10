<?php
/* @var $this PageController */
/* @var $model Page */
?>

<?php
$this->breadcrumbs = array(
  'Страницы' => array('/admin/page'),
  $model->title,
);
?>

<!--<h1>View Page #<?php echo $model->id; ?></h1>-->

<?php
echo $model->content;
?>
