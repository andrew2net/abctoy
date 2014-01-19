<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile('/themes/abctoy/css/landpage.css');
$cs->registerScriptFile('/js/countdown.clock.js', CClientScript::POS_END);
$cs->registerScriptFile('/js/moment.min.js', CClientScript::POS_HEAD);
$cs->registerScriptFile($cs->getCoreScriptUrl() . '/jui/js/jquery-ui-i18n.min.js', CClientScript::POS_HEAD);
?>
<div class="container" style="margin-top: 5px">
  <div class="table" style="padding-bottom: 10px">
    <div class="table-cell valign-middle" style="width: 20%">
      <a href="/"><img width="173" height="57" alt="ABC toy" src="/themes/abctoy/css/logo_shadow.png"></a>
    </div>

    <div class="table-cell valign-middle" style="width: 44%">
      <div class="gray bold" style="position: relative; bottom: 3px; font-size: 14pt">
        <div class="cufon">Интернет-магазин</div>
        <div class="cufon" style="margin: 5px 0">детских товаров и игрушек</div>
        <div class="cufon"><span class="green">Бесплатная доставка</span> по всей России.</div>
      </div>
    </div>
    <div class="table-cell" style="width: 23%; text-align: right">
      <div class="cufon lager" style="padding-bottom: 0.4em">Есть вопросы? Звоните!</div>
      <div class="cufon bold" style="padding-bottom: 0.2em; font-size: 23pt">
        <span class="red">(383)</span><span class="blue"> 375</span><span>-</span><span class="green">03</span><span>-</span><span class="yellow">22</span>
      </div>
      <div>
        <div class="cufon gray" style="font-size: 10pt; padding-bottom: 0.5em"> Мы на связи с 9:00 до 18:00 (GTM +4)</div>
      </div>
      <div class="gray lager">Новосибирск</div>
    </div>
  </div>
</div>
<div id="greenblock">
  <span> <span class="cufon bold">Интернет-магазин <span class="red">игрушек</span> для РАЗУМНЫХ родителей!</span> </span>
</div>
<div class="woodblock">
  <div class="container">
    <div class="inline-blocks">
      <div style="width: 365px; text-align: center; margin: 0 10px">
        <div class="red cufon bold" style="font-size: 32pt;text-align: center; margin: 20px 0">АКЦИЯ!!!</div>
        <div class="cufon bold" style="font-size: 18pt">Укажите возраст вашего</div>
        <div class="cufon bold" style="font-size: 18pt; margin-top: 10px">ребенка и получите скидку</div>
        <div class="cufon red bold" style="font-size: 140pt; height: 144px; text-shadow: white 2px 2px 2px">400</div>
        <div class="cufon red bold" style="font-size: 72pt">рублей</div>
        <div class="cufon bold" style="font-size: 18pt; margin: 10px 0">на первую покупку</div>
        <div class="cufon red" style="margin-bottom: 20px">Так же мы будем рекомендовать только те игрушки которые будут интересны вашему ребенку.</div>
      </div>
      <div style="vertical-align: top; font-size: 9pt; position: relative; margin-top: 10px">
        <div>
          <span class="cufon red" style="font-size: 24pt;margin: 10px 0">осталось </span>
          <span class="clock red cufon bold" style="font-size: 32pt" date="<?php echo date('d.m.Y', strtotime("+1 days")); ?>"></span></div>
        <div class="cufon bold" style="font-size: 12pt; margin: 10px 0">получите купон на скидку сейчас, а воспользуйтесь им потом</div>
        <div style="background: white; padding: 10px; border-radius: 5px">
          <div class="inline-blocks">
            <div style="vertical-align: bottom; margin-left: 27px; width: 120px">
              <?php
              echo CHtml::activeLabel($children[0], 'name');
              ?>
            </div>
            <div style="vertical-align: bottom; margin: 0 10px">
              <?php
              echo CHtml::activeLabel($children[0], 'birthday');
              ?>
            </div>
          </div>
          <div id="popup-form">
            <?php
            $this->renderPartial('//site/_popupForm', array(
              'children' => $children,
              'popup_form' => $popup_form,
            ));
            ?>
          </div>
          <span>Мы обещаем не слать спам, а только сообщать об интересных Вам акциях :)</span>
        </div>
        <div style="position: relativ; margin: 20px">
          <div class="land-page-redbutton bold">ПОЛУЧИТЬ 400 РУБЛЕЙ</div>
          <img id="popup-process" style="display: none" src="/images/process.gif">
        </div>
      </div>
    </div>
  </div>
</div>
<div id="grayblock">
  <div class="container">
    <div class="inline-blocks">
      <div class="icon-delivery-medium"></div>
      <div style="width: 190px">
        <div class="bold">Бесплатная доставка</div>
        <div>на следующий день</div>
      </div>
      <div class="icon-sclad-medium"></div>
      <div style="width: 190px">
        <div><span class="bold">50 000</span> товаров</div>
        <div>на складе</div>
      </div>
      <div class="icon-guarantee-medium"></div>
      <div style="width: 190px">
        <div>Гарантия на товар</div>
        <div>в течении года</div>
      </div>
    </div>
    <div class="inline-blocks">
      <div class="grayblock-line"></div>
      <div class="grayblock-line"></div>
      <div class="grayblock-line"></div>
    </div>
    <div class="inline-blocks">
      <div class="icon-payment-medium"></div>
      <div style="width: 190px">
        <div>Удобнные способы</div>
        <div>оплаты</div>
      </div>
      <div class="icon-brands-medium"></div>
      <div style="width: 190px">
        <div>Более 25</div>
        <div>производителей</div>
        <div>сотрудничают с нами</div>
      </div>
      <div class="icon-5yeasr-medium"></div>
      <div style="width: 190px">
        <div class="bold">Более 5 лет</div>
        <div>на рынке</div>
        <div>детских игрушек</div>
      </div>
    </div>
  </div>
</div>
<div id="tovar">
  <div class="cufon bold" style="font-size: 26pt; padding: 20px 0 10px">ТОЛЬКО <span class="red">САМЫЕ НИЗКИЕ</span> ЦЕНЫ</div>
  <div style="font-size: 11pt">Мы подобрали специально для вас самые выгодные предложения</div>
  <div>
    <?php
    Yii::import('application.modules.catalog.models.Product');
    Yii::import('application.modules.discount.models.Discount');
    $product = Product::model()->findAll(array(
//      'with' => array(
//        'discount'
//      ),
//    'limit' => 5,
      'condition' => 't.price > 410',
      'order' => 't.price'
        )
    );
    for ($index = 0; $index < 250; $index++) {
      $this->renderPartial('_product', array('product' => $product[$index]));
      for ($i = 0; $i < 50; $i++) {
        $index++;
      }
    }
    ?>
  </div>
  <div class="cufon bold" style="font-size: 22pt">У нас есть еще <span class="red" style="font-size: 32pt">49 995</span> игрушек по таким же детским ценам!</div>
  <div style="padding: 20px 0 30px">
    <a href="/"><div class="land-page-redbutton bold">Смотреть все игрушки</div></a>
  </div>
</div>
<?php
$this->renderPartial('_regform', array(
  'children' => $children,
  'popup_form' => $popup_form,
  'suff' => '1',
));
?>
<div style="text-align: center; margin: 50px 0 5px">
  <div class="cufon bold" style="font-size: 22pt; margin-bottom: 5px">ОТЗЫВЫ О НАШЕЙ РАБОТЕ</div>
  <div style="margin-bottom: 20px">Только реальные отзывы от реальных клиентов</div>
  <div class="container inline-blocks">
    <div style="margin: 0 15px">
      <div class="review-img"></div>
      <div>Лидия Аврам</div>
      <div>дочка, 3 года</div>
      <div class="gray" style="font-size: 9pt">lidaavram@mail.ru</div>
      <div class="note-img"></div>
      <div class="note-txt" style="text-align: left">
        <p>Делала неоднократно заказ в этом магазине, и всегда оставалась очень довольна скоростью обслуживания, начиная от операторов заканчивая доставкой.</p>
        <p>Весь персонал очень вежливый, вещи хорошего качества по достойной цене.</p>
      </div>
    </div>
    <div style="margin: 0 15px">
      <div class="review-img"></div>
      <div>Лидия Аврам</div>
      <div>дочка, 3 года</div>
      <div class="gray" style="font-size: 9pt">lidaavram@mail.ru</div>
      <div class="note-img"></div>
      <div class="note-txt" style="text-align: left">
        <p>Делала неоднократно заказ в этом магазине, и всегда оставалась очень довольна скоростью обслуживания, начиная от операторов заканчивая доставкой.</p>
        <p>Весь персонал очень вежливый, вещи хорошего качества по достойной цене.</p>
      </div>
    </div>
    <div style="margin: 0 15px">
      <div class="review-img"></div>
      <div>Лидия Аврам</div>
      <div>дочка, 3 года</div>
      <div class="gray" style="font-size: 9pt">lidaavram@mail.ru</div>
      <div class="note-img"></div>
      <div class="note-txt" style="text-align: left">
        <p>Делала неоднократно заказ в этом магазине, и всегда оставалась очень довольна скоростью обслуживания, начиная от операторов заканчивая доставкой.</p>
        <p>Весь персонал очень вежливый, вещи хорошего качества по достойной цене.</p>
      </div>
    </div>
    <div style="margin: 0 15px">
      <div class="review-img"></div>
      <div>Лидия Аврам</div>
      <div>дочка, 3 года</div>
      <div class="gray" style="font-size: 9pt">lidaavram@mail.ru</div>
      <div class="note-img"></div>
      <div class="note-txt" style="text-align: left">
        <p>Делала неоднократно заказ в этом магазине, и всегда оставалась очень довольна скоростью обслуживания, начиная от операторов заканчивая доставкой.</p>
        <p>Весь персонал очень вежливый, вещи хорошего качества по достойной цене.</p>
      </div>
    </div>
  </div>
  <a href="/"><div class="land-page-redbutton bold" style="margin: 50px auto">ПОСМОТРЕТЬ КАТАЛОГ</div></a>
</div>
<div class="triangle"></div>
<div class="container">
  <div class="cufon bold" style="font-size: 26pt; color: #666666; margin: 20px 0; text-align: center;"><span style="color: #f00;">САМЫЕ РАСПРОСТРАНЕННЫЕ ПРОБЛЕМЫ</span>,<br /> С КОТОРЫМИ СТАЛКИВАЮТСЯ РОДИТЕЛИ ПРИ ПОКУПКЕ ДЕТСКИХ ТОВАРОВ И ИГРУШЕК</div>
  <table style="width: 960px;" border="0">
    <tbody>
      <tr style="vertical-align: top;">
        <td style="vertical-align: top;" width="40" height="171"><img src="/uploads/sad.png" alt="" width="32" height="32" /></td>
        <td style="vertical-align: baseline; padding-top: 10px;" width="440">
          <div class="cufon " style="color: #000; font-size: 18px; font-weight: bold;"><span style="color: #993333; font-weight: bold;">Проблема 1.</span>&nbsp;Отсутствие доверия к интернет-магазинам.</div>
          <br />
          <p style="font-size: 14px; line-height: 1.5;">Можно ли доверять этому интернет-магазину? Откуда мне знать, получу ли я свой заказ?&nbsp;Этот и многие другие вопросы возникают у большинства покупателей.</p>
        </td>
        <td style="vertical-align: top;" width="40"><img src="/uploads/good.png" alt="" width="32" height="32" /></td>
        <td style="vertical-align: baseline; padding-top: 10px;" width="440">
          <div class="cufon " style="color: #000; font-size: 18px; font-weight: bold;"><span style="color: #669933; font-weight: bold;">Наше решение:</span>&nbsp;Крупная и надежная компания, которой можно доверять.</div>
          <br />
          <p style="font-size: 14px; line-height: 1.5;">За пять лет своего существования мы смогли доказать, что являемся надежным продавцом качественных товаров. А лучшее доказательство тому стало наше сотрудничество с более чем 700 компаниями, располагающимися в разных уголках России.&nbsp;</p>
        </td>
      </tr>
      <tr style="vertical-align: top;">
        <td style="vertical-align: top;" width="40" height="171"><img src="/uploads/sad.png" alt="" width="32" height="32" /></td>
        <td style="vertical-align: baseline; padding-top: 10px;" width="440">
          <div class="cufon " style="color: #000; font-size: 18px; font-weight: bold;"><span style="color: #993333; font-weight: bold;">Проблема 2.</span>&nbsp;<strong>Несвоевременная и дорогая доставка в интернет-магазинах.</strong></div>
          <br />
          <p style="font-size: 14px; line-height: 1.5;">Этот стереотип появился из за того, что многие интернет-магазины осуществляют доставку с помощью "Почты России", которая может доставлять Ваш заказ очень долго.</p>
        </td>
        <td style="vertical-align: top;" width="40"><img src="/uploads/good.png" alt="" width="32" height="32" /></td>
        <td style="vertical-align: baseline; padding-top: 10px;" width="440">
          <div class="cufon " style="color: #000; font-size: 18px; font-weight: bold;"><span style="color: #669933; font-weight: bold;">Наше решение:</span>&nbsp;Сотрудничество с профессионалами&nbsp;в сфере доставки</div>
          <br />
          <p style="font-size: 14px; line-height: 1.5;">Благодаря сотрудничеству с известной логистической компанией &laquo;CDEK&raquo; скорость и цена доставки заказа всегда радует наших клиентов. После осуществления покупки в нашем магазине пройдет всего 1-3 дня как заказ будет доставлен в любой город России.</p>
        </td>
      </tr>
      <tr style="vertical-align: top;">
        <td style="vertical-align: top;" width="40" height="171"><img src="/uploads/sad.png" alt="" width="32" height="32" /></td>
        <td style="vertical-align: baseline; padding-top: 10px;" width="440">
          <div class="cufon " style="color: #000; font-size: 18px; font-weight: bold;"><span style="color: #993333; font-weight: bold;">Проблема 3.</span>&nbsp;<strong>Отсутствие необходимого товара в интернет-магазине.&nbsp;</strong></div>
          <br />
          <p style="font-size: 14px; line-height: 1.5;">Так как многие интернет-магазины не имеют собственных складов с продукцией, время поставки товаров часто задерживается на очень длительный срок.&nbsp;</p>
        </td>
        <td style="vertical-align: top;" width="40"><img src="/uploads/good.png" alt="" width="32" height="32" /></td>
        <td style="vertical-align: baseline; padding-top: 10px;" width="440">
          <div class="cufon " style="color: #000; font-size: 18px; font-weight: bold;"><span style="color: #669933; font-weight: bold;">Наше решение:</span> Собственный большой склад</div>
          <br />
          <p style="font-size: 14px; line-height: 1.5;">Мы имеем в своем распоряжении большой склад, расположенный в Новосибирске. У нас всегда в наличии есть более 50 000 товаров, представленных на нашем сайте. Поэтому выбранный товар сразу же отправляется заказчику.</p>
        </td>
      </tr>
      <tr style="vertical-align: top;">
        <td style="vertical-align: top;" width="40" height="171"><img src="/uploads/sad.png" alt="" width="32" height="32" /></td>
        <td style="vertical-align: baseline; padding-top: 10px;" width="440">
          <div class="cufon " style="color: #000; font-size: 18px; font-weight: bold;"><span style="color: #993333; font-weight: bold;">Проблема 4.</span>&nbsp;<strong>Сложность в выборе идеальной игрушки для Вашего ребенка.</strong></div>
          <br />
          <p style="font-size: 14px; line-height: 1.5;">Часто при выборе игрушки для своего ребенка родители теряются среди разнообразия товаров.&nbsp;</p>
        </td>
        <td style="vertical-align: top;" width="40"><img src="/uploads/good.png" alt="" width="32" height="32" /></td>
        <td style="vertical-align: baseline; padding-top: 10px;" width="440">
          <div class="cufon " style="color: #000; font-size: 18px; font-weight: bold;"><span style="color: #669933; font-weight: bold;">Наше решение:</span>&nbsp;Интеллектуальная система поиска товара.</div>
          <br />
          <p style="font-size: 14px; line-height: 1.5;">Мы создали удобную систему фильтрации предлагаемых вам игрушек. Всего в несколько кликов мыши вы сможете легко выбрать подходящую категорию, возрастной промежуток и сумму, которую будете готовы потратить на свое чадо.</p>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<?php
$this->renderPartial('_regform', array(
  'children' => $children,
  'popup_form' => $popup_form,
  'suff' => '2',
));
?>
<div class="container" style="margin-top: 30px">
  <div class="table" style="padding-bottom: 10px">
    <div class="table-cell valign-middle" style="width: 20%">
      <a href="/"><img width="173" height="57" alt="ABC toy" src="/themes/abctoy/css/logo_shadow.png"></a>
      <div>2013. Все права защищены.</div>
      <div>ABC toy - продажа игрушек.</div>
    </div>
    <div class="table-cell" style="width: 23%; text-align: right">
      <div class="cufon lager" style="padding-bottom: 0.4em">Есть вопросы? Звоните!</div>
      <div class="cufon bold" style="padding-bottom: 0.2em; font-size: 23pt">
        <span class="red">(383)</span><span class="blue"> 375</span><span>-</span><span class="green">03</span><span>-</span><span class="yellow">22</span>
      </div>
      <div>
        <div class="cufon gray" style="font-size: 10pt; padding-bottom: 0.5em"> Мы на связи с 9:00 до 18:00 (GTM +4)</div>
      </div>
      <div class="gray lager">Новосибирск</div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('.woodblock').on('focus', '.date', function() {
    $('.woodblock .date').datepicker($.extend({
      changeMonth: true,
      changeYear: true,
      yearRange: "-30:+00",
    }, $.datepicker.regional['ru']));
  });

  var child_n = 0;
  var n = 1;
  var incAttr = function(match) {
    return parseInt(match) + 1;
  }

  $('.woodblock').on('click', '.add-child', function() {
    if (n > 3)
      return;
    child_n++;
    n++;
    $('.woodblock .date').datepicker('destroy');
    var child = $(this).parent().parent().find('.child:last-child').clone(true);
//    var child = $('#child-0').clone(true);
//    var id = child[0].id.replace('-0', '-' + child_n);
    child[0].id = child[0].id.replace(/\d+/, incAttr);
    child.find('.icon-remove-child-small').css('display', 'inherit');
    var chname = child.find('.name');
//    id = chname[0].id.replace('_0_', '_' + child_n + '_');
    chname[0].id = chname[0].id.replace(/\d+/, incAttr);
//    var name = chname[0].name.replace('[0]', '[' + child_n + ']');
    chname[0].name = chname[0].name.replace(/\d+/, incAttr);
    chname[0].value = '';
    var chbday = child.find('.birthday');
//    var idbd = chbday[0].id.replace('_0_', '_' + child_n + '_');
    chbday[0].id = chbday[0].id.replace(/\d+/, incAttr);
    chbday[0].name = chbday[0].name.replace(/\d+/, incAttr);
//    chbday[0].name = name;
    chbday[0].value = '';
    var gender = child.find('#ytChild_0_gender_id');
    id = gender[0].id.replace('_0_', '_' + child_n + '_');
    gender[0].id = id;
    name = gender[0].name.replace('[0]', '[' + child_n + ']');
    gender[0].name = name;
    var gender0 = child.find('#Child_0_gender_id_0');
    id = gender0[0].id.replace('_0_', '_' + child_n + '_');
    gender0[0].id = id;
    gender0[0].name = name;
    gender0.prop('checked', false);
    var gender0l = child.find('label[for=Child_0_gender_id_0]');
    var lfor = $(gender0l[0]).attr('for').replace('_0_', '_' + child_n + '_');
    $(gender0l[0]).attr('for', lfor);
    var gender1 = child.find('#Child_0_gender_id_1');
    id = gender1[0].id.replace('_0_', '_' + child_n + '_');
    gender1[0].id = id;
    gender1[0].name = name;
    gender1.prop('checked', false);
    var gender1l = child.find('label[for=Child_0_gender_id_1]');
    lfor = $(gender1l[0]).attr('for').replace('_0_', '_' + child_n + '_');
    $(gender1l[0]).attr('for', lfor);
    child.appendTo('#children');
  });

  $('.woodblock').on('click', '.icon-remove-child-small', function() {
    $(this).parent().parent().remove();
    n--;
  });
</script>