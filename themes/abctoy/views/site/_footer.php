<?php
/* @var $groups array */
?>
<div id="footer">
  <div class="container">
    <div class="table">
      <div class="table-cell">
        <a href="/"><img width="159" height="52" alt="ABC toy" src="/themes/abctoy/css/logo.png"></a>
        <div class="gray">
          2013. Все права защищены.<br>ABC toy - продажа игрушек.<br>Все торговые марки являются<br>собственностью их<br>правообладателей.
        </div>
      </div>

      <div class="table-cell" style="vertical-align: middle">
        <div class="gray bold lager" style="margin-bottom: 1em">
          ABC toy - интернет-магазин детских товаров и игрушек.
        </div>
        <div>
          <div class="table">
            <div class="table-cell footer-menu">
              <div class="bold">ABC toy</div>
              <div><a href="/about">О компании</a></div>
              <div><a href="/delivery_payment">Доставка и оплата</a></div>
              <div><a href="/guarantee">Гарантии и обмен</a></div>
              <div><a href="/faq">FAQ</a></div>
              <div><a href="/contact">Контакты</a></div>
              <div><a href="#">Наши преимущества</a></div>
            </div>
            <div class="table-cell footer-menu">
              <div class="bold">Товар</div>
              <?php
              foreach ($groups as $group) {
                ?>
                <div><?php echo CHtml::link($group->name
                    , $this->createUrl('group', array('id'=>$group->id))); ?></div>
              <?php } ?>
            </div>
            <div class="table-cell footer-menu">
              <div class="bold">Акции</div>
              <div><a href="#">Скидка недели</a></div>
              <div><a href="#">ТОП 10 подарков</a></div>
              <div><a href="#">Вам рекомендовано</a></div>
              <div><a href="#">Бренды</a></div>
            </div>
            <div class="table-cell">
              <div class="bold" style="height: 2.5em">Звоните</div>
              <div class="cufon gray bold x-lage" style="height: 1.5em">8 800 913-12-12</div>
              <div class="cufon gray bold x-lage" style="height: 1.3em">(383) 375-03-22</div>
              <div class="cufon gray bold lager" style="height: 1.5em">г. Новосибирск</div>
              <!--<div class="cufon gray bold lager">Мы в социальных сетях:</div>-->
            </div>
          </div>
        </div>
      </div>
    </div>    
  </div>
</div>
