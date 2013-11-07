<?php
/* @var $this PageController */
/* @var $model Page */
?>
<?php $this->renderPartial('_topmenu'); ?>
<div class="container" id="page">
<?php $this->renderPartial('_topblock'); ?>
<?php $this->renderPartial('_mainmenu'); ?>

<?php
$this->breadcrumbs = array(
  $model->title,
);
$this->widget('zii.widgets.CBreadcrumbs', array(
  'links' => $this->breadcrumbs,
));
?>

<?php echo $model->id; ?>

<?php
echo $model->content;
?>
</div>
<?php $this->renderPartial('_footer'); ?>
