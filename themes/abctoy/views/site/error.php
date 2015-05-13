<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Ошибка';
//$this->breadcrumbs = array(
//  'Error',
//);
?>
<?php $this->renderPartial('_topmenu'); ?>

<div class="container" id="page">
  <?php $this->renderPartial('_topblock'); ?>
  <?php
  $this->renderPartial('_mainmenu', array(
    'search' => $search,
    'groups' => $groups,
  ));
  ?>
  <h1 style="margin-top: 2em" class="bold red">Ошибка <?php echo $error['code']; ?></h1>

  <div style="margin-bottom: 100px;" class="error blue bold"><?php echo CHtml::encode($error['message']); ?></div>
</div>
<?php $this->renderPartial('_footer', array('groups' => $groups)); ?>
<?php $this->renderPartial('_addProductModal'); ?>
