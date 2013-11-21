<?php
/* @var $search Search */
/* @var $giftSelection GiftSelection */
/* @var $groups array */
?>
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/jquery.jcarousel.js', CClientScript::POS_HEAD);
$cs->registerScriptFile('/js/jcarousel.skeleton.js', CClientScript::POS_END);
$cs->registerScriptFile('/js/countdown.clock.js', CClientScript::POS_END);
$cs->registerScriptFile('/js/moment.min.js', CClientScript::POS_HEAD);
$cs->registerScriptFile('/js/slider.tooltip.js', CClientScript::POS_HEAD);

$this->renderPartial('_topmenu');
?>
<div class="container" id="page">
  <?php $this->renderPartial('_topblock'); ?>
  <?php $this->renderPartial('_mainmenu', array(
    'search' => $search,
    'groups' => $groups,
    )); ?>
  <?php $this->renderPartial('_slider'); ?>
  <?php $this->renderPartial('_advantage'); ?>
  <?php
  $this->renderPartial('_giftSelection', array(
    'giftSelection' => $giftSelection,
    'groups' => $groups,
  ));
  ?>
  <?php $this->renderPartial('_recommended'); ?>

</div><!-- page -->
<?php $this->renderPartial('_footer', array('groups' => $groups)); ?>
