<?php
/* @var $group Category */
?>

<div style="border: 1px dashed #666666; border-radius: 3px; min-height: 50px">
  <div style="margin-top: 10px">
    <?php
    $categories = $group->descendants(2)->findAll(array('order' => 'lft'));
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
      echo CHtml::openTag('a', array('href' => $this->createUrl('group', array(
          'id' => $category->id
      ))));
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
