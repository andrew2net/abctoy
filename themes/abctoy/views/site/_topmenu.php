<div id="topmenu">
  <div class="container">
    <?php
    $this->widget('zii.widgets.CMenu', array(
      'items' => array(
        array('label' => 'О компании', 'url' => array('/about')),
        array('label' => 'Доставка и оплата', 'url' => array('/delivery_payment')),
        array('label' => 'Гарантии и обмен', 'url' => array('/guarantee')),
        array('label' => 'FAQ', 'url' => array('/faq')),
        array('label' => 'Контакты', 'url' => array('/contact')),
        array(
          'label' => 'В корзине',
          'url' => array('#'),
          'itemOptions' => array('class' => 'align-right icon-cart'),
        ),
        array(
          'label' => 'Войти',
          'url' => array('#'),
          'visible' => FALSE, //Yii::app()->user->isGuest,
          'itemOptions' => array('class' => 'align-right', 'style'=>'padding-right: 50px'),
        ),
        array(
          'label' => 'Личный кабинет',
          'url' => array('#'),
          'visible' => FALSE, //!Yii::app()->user->isGuest,
          'itemOptions' => array('class' => 'align-right'),
        ),
      ),
//      'htmlOptions'=>array('style'=>'line-height: 2em')
    ))
    ?>
  </div>
</div>
