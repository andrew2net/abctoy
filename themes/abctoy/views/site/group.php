<?php
/* @var $search Search */
/* @var $giftSelection GiftSelection */
/* @var $groups[] Category */
/* @var $group Category */
/* @var $categories[] Category */
?>
<?php $this->pageTitle = Yii::app()->name . ' - ' . $group->name; ?>
<?php $this->renderPartial('_topmenu'); ?>

<div class="container" id="page">
  <?php $this->renderPartial('_topblock'); ?>
  <?php
  $this->renderPartial('_mainmenu', array(
    'search' => $search,
    'groups' => $groups,
  ));
  ?>
  <?php
  $this->widget('zii.widgets.CBreadcrumbs', array(
    'links' => array($group->name),
    'homeLink' => FALSE,
    'htmlOptions' => array(
      'class' => 'cufon green bold',
      'style' => 'font-size: 16pt; margin: 20px 0'
    )
  ))
  ?>
  <div class="inline-blocks">
    <div style="width: 180px; margin-right: 6px; float: left">
      <?php
      $this->renderPartial('_menuCategory', array('group' => $group));
      $this->renderPartial('_vGiftSelection', array(
        'giftSelection' => $giftSelection,
        'groups' => $groups,
      ));
      $this->renderPartial('_vAdvantage');
      ?>
    </div>

    <div style="width: 760px">

      <?php
      Yii::import('application.modules.catalog.models.Product');
      Yii::import('application.modules.discount.models.Discount');
      $discount_products = Product::model()->subCategory($group->id)
          ->findAll(array('limit' => 4));
      if (count($discount_products) > 2) {
        ?>
        <div class="inline-blocks">
          <div class="icon-dicount"></div>
          <div class="cufon red bold" style="font-size: 20pt; position: relative; top: -18px; padding: 0 10px">Товары со скидкой</div>
        </div>
        <div style="margin-top: 20px">
          <?php
          foreach ($discount_products as $discount_product)
            $this->renderPartial('_item', array('data' => $discount_product));
          ?>
          <div style="text-align: right; line-height: 3"><a class="red" href="#">Все товары со скидкой</a></div>
        </div>
      <?php } ?>

      <?php
      if ($group->level > 1) {
        Yii::import('application.modules.catalog.models.Product');
        $products = new CActiveDataProvider('Product', array(
          'criteria' => array('condition' => 'show_me=1')
        ));
        $this->widget('zii.widgets.CListView', array(
          'dataProvider' => $products,
          'itemView' => '_item',
          'sortableAttributes' => array('price')
            )
        );
      }
      else
        $this->renderPartial('_recommended', array('group' => $group));
      ?>

    </div>

  </div>
</div>
<?php $this->renderPartial('_footer', array('groups' => $groups)); ?>
