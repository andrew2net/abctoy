<?php
/* @var $search Search */
/* @var $giftSelection GiftSelection */
/* @var $groups[] Category */
/* @var $product Product */
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
  $breadcrumbs = array();
  switch ($group->level) {
    case 3:
      $g3 = $group->getParent()->getParent();
      $breadcrumbs[$g3->name] = array('group', 'id' => $g3->id);
    case 2:
      $g2 = $group->getParent();
      $breadcrumbs[$g2->name] = array('group', 'id' => $g2->id);
  }
  $breadcrumbs[] = $group->name;
  $this->widget('zii.widgets.CBreadcrumbs', array(
    'links' => $breadcrumbs,
    'homeLink' => FALSE,
    'separator' => ' / ',
    'htmlOptions' => array(
      'class' => 'cufon green bold breadcrumbs',
//      'style' => 'font-size: 16pt; margin: 20px 0; text-decoration: none'
    )
  ));
  echo CHtml::hiddenField('currentGroup', $group->id, array('id' => 'currentGroup'));
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
      Yii::import('application.modules.catalog.models.Brand');
      Yii::import('application.modules.catalog.models.Product');
      Yii::import('application.modules.discount.models.Discount');
      if ($group->level < 3) {
        $discount_products = Product::model()->subCategory($group->id)
                ->discountOrder()->findAll(array('limit' => 4, 'having'=>'percent>0'));
        if (count($discount_products) > 2) {
          ?>
          <div class="inline-blocks">
            <div style="width: 100%">
              <div class="inline-blocks right">
                <div class="icon-dicount"></div>
                <div class="cufon red bold" style="font-size: 20pt; position: relative; padding: 0 10px">Товары со скидкой</div>
              </div>
            </div>
          </div>
          <div style="margin-top: 20px">
            <?php
            foreach ($discount_products as $discount_product)
              $this->renderPartial('_item', array('data' => $discount_product));
            ?>
            <!--<div style="text-align: right; line-height: 3"><a class="red" href="#">Все товары со скидкой</a></div>-->
          </div>
        <?php
        }
      }
      ?>

      <?php
      if ($group->level > 1) {
        if ($group->level > 2)
          $pagination = array('pageSize' => 16);
        else
          $pagination = array('pageSize' => 12);
        $data = $product->searchCategory($group->id);
        $data->setPagination($pagination);
        $this->widget('ListView', array(
          'dataProvider' => $data,
          'itemView' => '_item',
          'template' => '{sorter}{pager}{items}{pager}',
          'sorterHeader' => 'Сортировать:',
          'sortableAttributes' => array('price'),
          'htmlOptions' => array('style' => 'margin-top:30px'),
            )
        );
      }
      else {
        $this->renderPartial('_recommended', array(
          'group' => $group,
          'product' => $product,));
      }
      ?>

    </div>

  </div>
</div>
<?php $this->renderPartial('_footer', array('groups' => $groups)); ?>
<?php $this->renderPartial('_addProductModal'); ?>
