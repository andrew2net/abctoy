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
    <div class="styled-select">
      <?php
      $items = array();
      foreach ($groups as $value) {
        $items[$value->id] = $value->name;
      }
      echo CHtml::activeDropDownList($giftSelection, 'category', $items
          , array('prompt' => 'Все категории'));
      ?>
    </div>
  </div>
  <div style="top: -10px; position: relative; height: 150px">
    <?php
    echo $form->label($giftSelection, 'ageFrom', array(
      'class' => 'bold',
      'style' => 'font-size: 12pt; line-height: 2.5'
    ));
    ?><br>
    <div style="
         /*background: whitesmoke; border-radius: 15px; box-shadow: 0px 0px 3px 0px #999999 inset;*/ 
         padding: 10px 10px;">
         <?php
         echo CHtml::activeHiddenField($giftSelection, 'ageFrom');
         echo CHtml::activeHiddenField($giftSelection, 'ageTo');
         ?>
         <?php
         $this->widget('zii.widgets.jui.CJuiSlider', array(
           'id' => 'age_slider',
           'options' => array(
             'animate' => 'slow',
             'range' => TRUE,
             'min' => 0,
             'max' => 5,
             'values' => "js:[{$giftSelection->ageFrom}, {$giftSelection->ageTo}]",
             'create' => 'js:function(event, ui){sliderIniTooltip(this);}',
             'slide' => 'js:function(event, ui){sliderMoveTooltip(ui); $("#GiftSelection_ageFrom").val(ui.values[0]); $("#GiftSelection_ageTo").val(ui.values[1]);}',
           ),
         ));
         ?>
    </div>
    <?php echo CHtml::activeCheckBox($giftSelection, 'availableOnly'); ?>
    <?php
    echo CHtml::activeLabel($giftSelection, 'availableOnly', array(
      'style' => 'line-height: 9'
    ));
    ?>
  </div>
  <div style="margin: 20px 0 0 50px; position: absolute; height: 150px">
    <?php
    echo $form->label($giftSelection, 'priceFrom', array(
      'class' => 'bold',
      'style' => 'font-size: 12pt; line-height: 2.5; display: block'
    ));
    ?>
    <div style="
         /*background: whitesmoke; border-radius: 15px; box-shadow: 0px 0px 3px 0px #999999 inset;*/ 
         padding: 10px 10px;">
         <?php
         echo CHtml::activeHiddenField($giftSelection, 'priceFrom');
         echo CHtml::activeHiddenField($giftSelection, 'priceTo');
         ?>
         <?php
         $this->widget('zii.widgets.jui.CJuiSlider', array(
           'id' => 'price_slider',
           'options' => array(
             'animate' => 'slow',
             'range' => TRUE,
             'min' => 0,
             'max' => 5000,
             'step' => 50,
             'values' => "js:[{$giftSelection->priceFrom}, {$giftSelection->priceTo}]",
             'create' => 'js:function(event, ui){sliderIniTooltip(this);}',
             'slide' => 'js:function(event, ui){sliderMoveTooltip(ui); $("#GiftSelection_priceFrom").val(ui.values[0]); $("#GiftSelection_priceTo").val(ui.values[1]);}',
           ),
         ));
         ?>
    </div>
    <div style="position: relative; top: 42px; right: -130px">
      <a href="#">
        <div class="greenbutton inline-blocks">
          <div class="left"></div>
          <div class="center">ПОДОБРАТЬ</div>
          <div class="right"></div>
        </div>
      </a>
    </div>
  </div>
</div>
<?php $this->endWidget(); ?>