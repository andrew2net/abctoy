<?php
/* @var $search Search */
?>
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::getPathOfAlias('webroot.js') .
    DIRECTORY_SEPARATOR . 'jquery.jcarousel.js', CClientScript::POS_END);

$this->renderPartial('_topmenu');
?>
<div class="container" id="page">
  <?php $this->renderPartial('_topblock'); ?>
  <?php $this->renderPartial('_mainmenu', array('search' => $search)); ?>
  <?php $this->renderPartial('_recommended'); ?>

</div><!-- page -->
<?php $this->renderPartial('_footer'); ?>
