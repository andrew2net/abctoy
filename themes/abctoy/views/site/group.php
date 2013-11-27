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
      $categories = $group->descendants(2)->findAll(array('order' => 'lft'));
//      if (count($categories)) {
      ?>
      <div style="border: 1px dashed #666666; border-radius: 3px; min-height: 50px">
        <div style="margin-top: 10px">
          <?php
          $level = $group->level - 1;
          foreach ($categories as $category) {
            if ($category->level == $level)
              echo CHtml::closeTag('li');
            else if ($category->level > $level)
              echo CHtml::openTag('ul');
            else {
              echo CHtml::closeTag('li');

              for ($i = $level - $category->level; $i; $i--) {
                echo CHtml::closeTag('ul');
                echo CHtml::closeTag('li');
              }
            }
            $class = 'category';
            if (($category->level - $group->level) == 1)
              $class .= ' nomarker';
            else
              $class .= ' subcategory';
            echo CHtml::openTag('li', array('class' => $class));
            echo CHtml::openTag('a', array('href' => '#'));
            echo CHtml::encode($category->getAttribute('name'));
            echo CHtml::closeTag('a');

            $level = $category->level;
          }
          for ($i = $level; $i; $i--) {
            echo CHtml::closeTag('li');
            echo CHtml::closeTag('ul');
          }
          ?>
        </div>
      </div>
      <?php // } ?>
      <?php
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
//      Yii::import('application.modules.catalog.models.Product');
//      $products = new CActiveDataProvider('Product', array(
//        'criteria' => array('condition' => 'show_me=1')
//      ));
//      $this->widget('zii.widgets.CListView', array(
//        'dataProvider' => $products,
//        'itemView' => '_item',
//        'sortableAttributes'=>array('price')
//          )
//      );
      $this->renderPartial('_recommended', array('group' => $group));
      ?>

    </div>

  </div>
</div>