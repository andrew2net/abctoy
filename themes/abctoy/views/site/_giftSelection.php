<?php
/* @var $giftSelection GiftSelection */
/* @var $form CActiveForm */
?>
<?php $form = $this->beginWidget('CActiveForm'); ?>
<div class="blue cufon bold" style="font-size: 20pt; position: relative;
     margin: 0 0 -15px 20px; background: white; width: 205px; z-index: 1;
     padding: 0 8px">Подбор подарка</div>
<div class="inline-blocks" style="border: #3399cc solid 4px; border-radius: 4px; position: relative">
  <div style="margin: 20px">
    <?php
    echo $form->label($giftSelection, 'gender', array(
      'class' => 'bold',
      'style' => 'font-size: 12pt; line-height: 2.5; display: block; margin-bottom: 7px'
    ));
    ?>
    <div class="radio">
      <?php
      echo $form->radioButtonList($giftSelection, 'gender'
          , Product::model()->genders, array(
        'separator' => '',
        'style' => 'color: #3399cc'
      ));
      ?>
    </div>
    <?php
    echo $form->label($giftSelection, 'category', array(
      'class' => 'bold',
      'style' => 'font-size: 12pt; line-height: 2.5; display: block; margin-top: 10px'
    ));
    ?>
    <div style="position: relative">
      <?php
      $items = array();
      foreach ($groups as $value) {
        $items[$value->id] = $value->name;
      }
      echo CHtml::activeDropDownList($giftSelection, 'category', $items);
      ?>
      <div class="icon-dropdown inline"></div>
    </div>
  </div>
  <div style="margin-top: 20px; position: absolute">
    <?php
    echo $form->label($giftSelection, 'ageFrom', array(
      'class' => 'bold',
      'style' => 'font-size: 12pt; line-height: 2.5'
    ));
    ?><br>
    <div style="background: whitesmoke; padding: 10px 20px; border-radius: 15px; box-shadow: 0px 0px 3px 0px #999999 inset">
    <?php $this->widget('zii.widgets.jui.CJuiSliderInput', array(
      'model' => $giftSelection,
      'attribute' => 'ageFrom',
      'maxAttribute' => 'ageTo',
      'options' => array(
        'range' => TRUE,
        'min' => 0,
        'max' => 5,
      ),
    )); ?>
    </div>
    <?php echo CHtml::activeCheckBox($giftSelection, 'availableOnly'); ?>
    <?php echo CHtml::activeLabel($giftSelection, 'availableOnly', array(
      'style'=>'line-height: 9'
    )); ?>
  </div>
</div>
<?php $this->endWidget(); ?>