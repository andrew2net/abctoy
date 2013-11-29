<?php
/* @var $product Product */
/* @var $productForm ProductForm */
/* @var $groups[] Category */
/* @var $search Search */
?>
<?php $this->pageTitle = Yii::app()->name . ' - ' . $product->name; ?>
<?php $this->renderPartial('_topmenu'); ?>

<div class="container" id="page">
  <?php $this->renderPartial('_topblock'); ?>
  <?php
  $this->renderPartial('_mainmenu', array(
    'search' => $search,
    'groups' => $groups,
  ));
  ?>
</div>