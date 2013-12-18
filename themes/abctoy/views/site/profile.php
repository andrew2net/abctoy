<?php
/* @var $profile CustomerProfile */
/* @var $order Order */
/* @var $new_passw NewPassword */
?>
<?php $this->pageTitle = Yii::app()->name . ' - Личный кабинет'; ?>
<div class="container" id="page" style="margin-top: 0">
  <?php $this->renderPartial('_profileTopBlock'); ?>
  <div style="text-align: right; margin: 40px 0 10px"><a href="/logout">Выйти</a></div>
  <div class="inline-blocks">
    <div style="vertical-align: top">
      <?php $form = $this->beginWidget('CActiveForm', array('id' => 'profile')) ?>
      <div class="cufon bold" style="font-size: 14pt; width: 400px">Контактная информация</div>
      <div style="height: 20px; margin: 10px 0">
        <?php if (Yii::app()->user->hasFlash('newPassw')) { ?>
          <span class="cufon red bold" style="font-size: 12pt; margin-bottom: 10px"><?php echo Yii::app()->user->getFlash('newPassw'); ?></span>
        <?php } ?>
      </div>
      <div><?php
        echo CHtml::label('Ваше имя и фамилия<span class="red">*</span>'
            , 'CustomerProfile_fio', array(
          'class' => 'cufon gray bold',
          'style' => 'font-size: 12pt'
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo $form->textField($profile, 'fio'
            , array('class' => 'input-text'));
        ?>
        <?php echo CHtml::error($profile, 'fio', array('style' => 'font-size:10pt', 'class' => 'red')); ?>
      </div>
      <div><?php
        echo CHtml::label('E-mail<span class="red">*</span>', 'CustomerProfile_email'
            , array(
          'class' => 'cufon gray bold',
          'style' => 'font-size: 12pt'
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo CHtml::activeEmailField($profile, 'email'
            , array('class' => 'input-text'));
        ?>
        <?php echo CHtml::error($profile, 'email', array('style' => 'font-size:10pt', 'class' => 'red')); ?>
      </div>
      <div><?php
        echo CHtml::activeLabel($new_passw
            , 'passw1', array(
          'class' => 'cufon gray bold',
          'style' => 'font-size: 12pt'
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo CHtml::activePasswordField($new_passw, 'passw1'
            , array('class' => 'input-text'));
        ?>
        <?php echo CHtml::error($new_passw, 'passw1', array('style' => 'font-size:10pt', 'class' => 'red')); ?>
      </div>
      <div><?php
        echo CHtml::activeLabel($new_passw
            , 'passw2', array(
          'class' => 'cufon gray bold',
          'style' => 'font-size: 12pt'
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo CHtml::activePasswordField($new_passw, 'passw2'
            , array('class' => 'input-text'));
        ?>
        <?php echo CHtml::error($new_passw, 'passw2', array('style' => 'font-size:10pt', 'class' => 'red')); ?>
      </div>
      <div><?php
        echo CHtml::label('Телефон<span class="red">*</span>', 'CustomerProfile_phone'
            , array(
          'class' => 'cufon gray bold',
          'style' => 'font-size: 12pt'
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo CHtml::activeTelField($profile, 'phone'
            , array('class' => 'input-text'));
        ?>
        <?php echo CHtml::error($profile, 'phone', array('style' => 'font-size:10pt', 'class' => 'red')); ?>
      </div>
      <div><?php
        echo CHtml::label('Город<span class="red">*</span>', 'CustomerProfile_city'
            , array(
          'class' => 'cufon gray bold',
          'style' => 'font-size: 12pt'
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
          'id' => 'cart-city',
          'model' => $profile,
          'attribute' => 'city',
          'sourceUrl' => '/site/suggestcity',
          'htmlOptions' => array('class' => 'input-text')
        ));
        ?>
        <?php echo CHtml::error($profile, 'city', array('style' => 'font-size:10pt', 'class' => 'red')); ?>
      </div>
      <div><?php
        echo CHtml::activeLabel($profile, 'address'
            , array(
          'class' => 'cufon gray bold',
          'style' => 'font-size: 12pt'
        ));
        ?>
      </div>
      <div style="margin-bottom: 1em"><?php
        echo CHtml::activeTextField($profile, 'address'
            , array('class' => 'input-text'));
        ?></div>
      <div style="margin: 20px 45px">
        <a class="submit" href="#">
          <div class="greenbutton inline-blocks">
            <div class="left"></div>
            <div class="center">ИЗМЕНИТЬ</div>
            <div class="right"></div>
          </div>
        </a>
      </div>
      <?php $this->endWidget(); ?>
    </div>
    <div style="vertical-align: top">
      <div class="cufon green bold" style="font-size: 22pt; position: relative;
           background: white; width: 90px; text-align: center; left: 50px; 
           z-index: 10">Дети</div>
      <div style="border: #99cc33 solid 4px; border-radius: 4px; position: relative; 
           width: 538px; height: 300px; top: -15px">

      </div>
      <div class="cufon bold" style="font-size: 16pt; margin: 20px 0 0px">Мои заказы</div>
      <?php
      $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'profile-grid-order',
        'dataProvider' => $order,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
          array(
            'name' => '№',
            'value' => '$data->id',
          ),
          array(
            'name' => 'time',
            'value' => 'Yii::app()->dateFormatter->format("dd.MM.yyyy", $data->time)'
          ),
          array(
            'name' => 'Сумма',
            'value' => 'number_format($data->summ - $data->couponDiscount + $data->delivery_summ, 0, ".", " ") . " руб"'
          ),
          array(
            'name' => 'status_id',
            'value' => '$data->status',
          ),
        )
      ));
      ?>
    </div>
  </div>
</div>