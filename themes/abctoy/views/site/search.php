<?php
/* @var $product CActiveDataProvider */
/* @var $groups[] Category */
/* @var $search Search */
?>
<?php $this->pageTitle = Yii::app()->name . ' - Поиск: ' . $search->text; ?>
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
    <span class="cufon green bold" style="font-size: 18pt">Вы искали: </span>
    <span class="cufon" style="font-size: 18pt"><?php echo $search->text; ?></span>
  </div>
  <div class="inline-blocks">
    <div style="width: 180px; margin-right: 6px; float: left">
      <?php
      $this->renderPartial('_vGiftSelection', array(
        'giftSelection' => $giftSelection,
        'groups' => $groups,
      ));
      $this->renderPartial('_vAdvantage');
      ?>
    </div>
    <div style="width: 760px">
      <div style="margin-top: 20px">
        <?php
        if ($product->getItemCount() > 0) {
        echo CHtml::beginForm('', 'post', array('id' => 'item-submit'));
        echo CHtml::hiddenField('url', Yii::app()->request->url);
        $this->widget('zii.widgets.CListView', array(
          'dataProvider' => $product,
          'itemView' => '_item',
          'template' => '{pager}{items}{pager}',
            )
        );
        echo CHtml::endForm();
        }else {
          ?>
          <div class="cufon blue bold" style="font-size: 26pt; text-align: center;margin-top: 40px">По вашему запросу товар не найден</div>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php $this->renderPartial('_footer', array('groups' => $groups)); ?>
<?php $this->renderPartial('_addProductModal'); ?>
