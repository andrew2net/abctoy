<?php
/* @var $search Search  */
/* @var $groups[] Category */
?>
<div class="mainmenuarea">
  <div id="mainmenu">
    <div class="inline-blocks" style="background: none repeat scroll 0% 0% rgb(51, 153, 204)">
      <div>
        <?php
        $items = array();
        foreach ($groups as $group) {
          $items[] = array(
            'label' => $group->name,
            'url' => $this->createUrl('group', array('id' => $group->id)),
            'linkOptions' => array(
              'submenu' => 'submenu-' . $group->id,
              'class' => 'mainmenulink'
            ),
          );
        }
        $this->widget('zii.widgets.CMenu', array(
          'items' => $items,
        ));
        ?>
      </div>
      <div style="float: right; margin: 5px 20px;">
        <?php echo CHtml::beginForm('#', 'post'); ?>
        <?php
        echo CHtml::activeTextField($search, 'text', array(
          'style' => 'border-radius: 4px 0 0 4px; border: none; width: 10em; height: 23px; padding-left: 10px',
          'placeholder' => 'Поиск'
        ));
        ?>
        <?php
        echo CHtml::submitButton('', array(
          'style' => 'margin: 0 0 0 -4px; border: none; border-radius: 0 4px 4px 0',
          'class' => 'icon-search'
        ));
        ;
        ?>
        <?php echo CHtml::endForm(); ?>
      </div>
    </div>
  </div>
  <div style="position: relative">
    <?php
    foreach ($groups as $group) {
      $this->renderPartial('_submenu', array('group' => $group));
    }
    ?>
  </div>
</div>