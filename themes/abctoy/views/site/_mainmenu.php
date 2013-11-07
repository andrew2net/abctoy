<div id="mainmenu">
  <?php
  Yii::import('application.modules.catalog.models.Category');
  $groups = Category::model()->findAll('level=1');
  $items = array();
  foreach ($groups as $group) {
    $items[] = array(
      'label' => $group->name,
      'url' => '#',
    );
  }
  $this->widget('zii.widgets.CMenu', array(
    'items' => $items,
  ));
  ?>
</div>