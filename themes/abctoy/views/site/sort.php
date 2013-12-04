<?php
/* @var $product[] Product */
/* @var $productForm ProductForm */
/* @var $groups[] Category */
/* @var $search Search */
?>
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/slider.tooltip.js', CClientScript::POS_HEAD);

$this->pageTitle = Yii::app()->name . ' - Подбор подарка';
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
  <div style="margin: 20px 0">
    <?php
    $this->renderPartial('_giftSelection', array(
      'giftSelection' => $giftSelection,
      'groups' => $groups,
    ));
    ?>
  </div>
  <div class="inline-blocks">
    <div style="width: 180px; margin-right: 6px; float: left">
      <?php $this->renderPartial('_vAdvantage'); ?>
    </div>
    <div style="width: 760px">
      <div style="margin-top: 20px">
        <?php
        $this->widget('zii.widgets.CListView', array(
          'dataProvider' => $product,
          'itemView' => '_item',
          'template' => '{items}{pager}',
            )
        );
        ?>
      </div>
    </div>
  </div>
</div>
<?php $this->renderPartial('_footer', array('groups' => $groups)); ?>
