<?php
/* @var $search Search */
?>
<?php

$this->renderPartial('_topmenu');
?>
<div class="container" id="page">
  <?php $this->renderPartial('_topblock'); ?>
  <?php $this->renderPartial('_mainmenu', array('search' => $search)); ?>
  <?php $this->renderPartial('_recommended'); ?>

</div><!-- page -->
<?php $this->renderPartial('_footer'); ?>
