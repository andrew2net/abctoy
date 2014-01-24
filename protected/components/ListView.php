<?php

Yii::import('zii.widgets.CListView');

class ListView extends CListView {

  public function renderSizer() {
    $links = array();
    foreach ($this->viewData['sizes'] as $count) {
      $params = array_replace($_GET, array('size' => $count));
      if (isset($params['page']))
        unset($params['page']);

      $links[] = CHtml::link($count, Yii::app()->controller->createUrl('', $params));
    }
    $params['size'] = $this->dataProvider->getTotalItemCount();
    $links[] = CHtml::link('весь товар', Yii::app()->controller->createUrl('', $params));
    echo '<div class="sizer">Показывать: ' . implode(', ', $links) . '</div>';
  }

}