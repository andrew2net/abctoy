<div id="topmenu">
  <div class="container">
    <?php
    $this->widget('zii.widgets.CMenu', array(
      'items' => array(
        array('label' => 'О компании', 'url' => array('/about')),
        array('label' => 'Доставка', 'url' => array('/deliver')),
        array('label' => 'Оплата', 'url' => array('/payment')),
        array('label' => 'Гарантии и обмен', 'url' => array('/guarantee')),
        array('label' => 'Где лучше покупать игрушки?', 'url' => array('/faq')),
        array(
          'label' => $this->cartLabel(),
          'url' => array('/cart'),
          'linkOptions' => array('id' => 'shoppingCart'),
          'itemOptions' => array('class' => 'align-right icon-cart'),
        ),
        array(
          'label' => 'Войти',
          'url' => array(''),
          'visible' => Yii::app()->user->isGuest,
          'itemOptions' => array('class' => 'align-right', 'style' => 'padding-right: 50px'),
        ),
        array(
          'label' => 'Личный кабинет',
          'url' => array('/profile'),
          'visible' => !Yii::app()->user->isGuest,
          'itemOptions' => array('class' => 'align-right'),
        ),
      ),
//      'htmlOptions'=>array('style'=>'line-height: 2em')
    ))
    ?>
  </div>
</div>
