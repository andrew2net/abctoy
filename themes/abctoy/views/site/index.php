<?php
/* @var $search Search */
/* @var $giftSelection GiftSelection */
/* @var $groups array */
?>
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/jquery.jcarousel.js', CClientScript::POS_HEAD);
$cs->registerScriptFile('/js/jcarousel.skeleton.js', CClientScript::POS_END);
$cs->registerScriptFile('/js/countdown.clock.js', CClientScript::POS_END);
$cs->registerScriptFile('/js/moment.min.js', CClientScript::POS_HEAD);
$cs->registerScriptFile('/js/slider.tooltip.js', CClientScript::POS_HEAD);

$this->renderPartial('_topmenu');
?>
<div class="container" id="page">
  <?php $this->renderPartial('_topblock'); ?>
  <?php
  $this->renderPartial('_mainmenu', array(
    'search' => $search,
    'groups' => $groups,
  ));
  ?>
  <?php $this->renderPartial('_slider'); ?>
  <?php $this->renderPartial('_advantage'); ?>
  <?php
  $this->renderPartial('_giftSelection', array(
    'giftSelection' => $giftSelection,
    'groups' => $groups,
  ));
  ?>
  <?php $this->renderPartial('_weekDiscount'); ?>
  <?php $this->renderPartial('_top10'); ?>
<?php $this->renderPartial('_recommended',array('product' => $product)); ?>
<?php $this->renderPartial('_brands'); ?>
  <div style="margin: 30px 10px">
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0">Добро пожаловать в интернет магазин игрушек!</div>
    <div><a href="#">ABC-toy</a> - интернет магазин <a href="#">детских товаров</a> и игрушек, в котором вы можете приобрести все, что нужно для игр, досуга, учебы, отдвха ваших детей. Мы предлагаем широкий ассортимент <a href="#">игрушек</a>, товаров для творчества, книг, для девочек и мальчиков разных возрастов.</div>
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0">Лучшие игрушки достойных брендов</div>
    <div>В нашем магазине вы можете купить по доступной цене наиболее популярные игрушки известных мировых брендов.
      Вся продукция сертифицированна и абсолютно безопасна, изготовлена из качественных безвредных материалов.
      С нашей помощью <a href="#">ваш ребенок</a> будет играть самыми лечшими игрушками, хорошо подходящими его возрасту,
      аозволяющими не только с интересом проводить время, но и развиваться как умственно так и физически.
      <a href="#">Благодаря</a> нам вы можете создать для своих детей яркий волшебный мир.
    </div>
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0">Удобная система поиска</div>
    <div>На нашем сайте очень удобно <a href="#">искать товары</a>, потому что мы разработали систему поиска,
    позволяющую задавать различные параметры: для девочек или для мальчиков, возраст, желательная цена, бренд и т.д.
    Вам нужно лишь поставить несколько галочек и отметить граничные показатели, и система сама подберет товары, соответсвующие вашим пожеланиям.</div>
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0">Доступная цена</div>
    <div>Наш интернет-магазин детских товаров предлагает вполне <a href="#">доступные цены</a> на продукцию известных мировых брендов.
    Мы часто проводи различные акции, предлагаем скидки, что позволяет покупателям сэкономить.</div>
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0">Доставка</div>
    <div>Интернет-магазин ABC-toy предлагает доставку заказанных игрушек по всей <a href="#">территории России</a>.
    Подробнее об условиях доставки вы можете проситать в соответствующем разделе.</div>
  </div>
</div><!-- page -->
<?php $this->renderPartial('_footer', array('groups' => $groups)); ?>
