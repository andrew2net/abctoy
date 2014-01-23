<?php
/* @var $search Search */
/* @var $giftSelection GiftSelection */
/* @var $product Product */
/* @var $groups array */
?>
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/jquery.jcarousel.js', CClientScript::POS_HEAD);
$cs->registerScriptFile('/js/jcarousel.skeleton.js', CClientScript::POS_END);
$cs->registerScriptFile('/js/countdown.clock.js', CClientScript::POS_END);
$cs->registerScriptFile('/js/moment.min.js', CClientScript::POS_HEAD);
$cs->registerScriptFile('/js/slider.tooltip.js', CClientScript::POS_HEAD);
$cs->registerScriptFile($cs->getCoreScriptUrl() . '/jui/js/jquery-ui-i18n.min.js', CClientScript::POS_HEAD);
$this->pageTitle = Yii::app()->name . ' Детские товары и игрушки купить по низкой цене в интернет-магазине игрушек';

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
  echo CHtml::beginForm('', 'post', array('id' => 'item-submit'));
  echo CHtml::hiddenField('url', Yii::app()->request->url);
  ?>
  <?php $this->renderPartial('_weekDiscount'); ?>
  <?php $this->renderPartial('_top10'); ?>
  <?php
  $this->renderPartial('_recommended', array('product' => $product));
  echo CHtml::endForm();
  ?>
  <?php $this->renderPartial('_brands'); ?>
  <div style="margin: 30px 10px">
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0 10px">Рады вас приветствовать в интернет-магазине детских товаров и игрушек!</div>
    <div>ABC-toy – это интернет-магазин игрушек, который выбирают продвинутые родители. К вашему вниманию предложен широкий ассортимент детских товаров для досуга, отдыха или учебы подрастающего ребенка. У нас вы сможете приобрести подарок ребенку любого возраста и вкусовых предпочтений.</div>
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0 10px">Лучшие игрушки</div>
    <div>В нашем магазине вы найдете продукцию самых популярных мировых брендов. Каждый товар прошел контроль качества, поэтому можно быть уверенным в том, что он полностью безопасен для здоровья ребенка. Мы хотим, чтобы Ваши дети играли только с самими лучшими игрушками!
    </div>
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0 10px">Удобная система поиска</div>
    <div>У нас легко и просто покупать товары, благодаря простой и удобный интерфейс сайта ABC-toy. Наличие системы поиска позволяет оперативно находить необходимую продукцию, экономя свое время. Для удобства все товары разбиты на разделы и имеют массу присвоенных параметров. Это облегчает поиск детской игрушки, которая будет подходить вашему ребенку.</div>
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0 10px">Доступные цены</div>
    <div>Интернет-магазин ABC-toy – это еще и низкие цены на продукцию. Здесь вы сможете неплохо сэкономить, радуя своих детей новыми игрушками. Ваш семейный бюджет будет сохранен благодаря тому, что мы часто предлагаем большие скидки на товар, интересные акции и бонусы.</div>
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0 10px">Бесплатная доставка</div>
    <div>Бесплатная доставка – это еще одно преимущество нашего интернет-магазина. Вы сможете заказать предлагаемую нами продукцию в любые города России такие как: Барнаул, Бийск, Горно-Алтайск,  Кемерово, Красноярск, Междуреченск, Новокузнецк, Новосибирск, Омск, Прокопьевск, Северск, Томск, Москва, Санкт-Петербург, Александров, Белгород, Брянск, Великий Новгород, Владимир, Вологда, Воронеж, Гатчина, Иваново, Казань, Калуга, Кострома, Курск, Липецк, Нижний Новгород, Орел, Псков, Рыбинск, Рязань, Сосновый Бор, Смоленск, Старый Оскол, Тамбов, Тверь, Тула, Чебоксары, Череповец, Ярославль, Астрахань, Балаково, Волгоград, Волгодонск, Димитровград, Златоуст, Ижевск, Йошкар-Ола, Киров, Краснодар, Кисловодск, Миасс, Минеральные Воды, Мурманск, Нальчик, Новороссийск, Новочеркасск, Оренбург, Орск, Пенза, Петрозаводск, Пятигорск, Ростов-на-Дону, Самара, Саратов, Саранск, Сочи, Ставрополь, Стерлитамак, Сыктывкар, Таганрог, Тольятти, Ульяновск, Черкесск, Березники, Екатеринбург, Курган, Набережные Челны, Нефтекамск, Нижнекамск, Пермь, Салават, Тюмень, Уфа, Челябинск, Артём, Белогорск, Благовещенск, Владивосток, Комсомольск-на-Амуре, Находка, Уссурийск, Хабаровск, Абакан, Ангарск, Архангельск, Иркутск, Калининград, Надым, Нижневартовск, Новый Уренгой, Сургут, Улан-Удэ, Ханты-Мансийск, Чита, Южно-Сахалинск, Якутск. <p>Вы можете быть уверены, что ваш заказ будет доставлен в целости и сохранности с соблюдением сроков. Подробнее о доставке обязательно почитайте в соответствующем разделе.</p></div>
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0 10px">Удобные способы оплаты</div>
    <div>В интернет-магазине ABC-toy можно не только легко выбрать, но и купить детские игрушки. Оплата заказа может быть произведена как по карте Visa или Mastercard, так и наличными через курьера, которым будет доставлен товар.</div>
    <div class="blue bold" style="font-size: 14pt; margin: 15px 0 10px">Собственный склад</div>
    <div>Главной особенностью интернет-магазина ABC-toy является собственный большой склад в Новосибирске. Благодаря ему все предлагаемые на сайте игрушки всегда есть в наличии. Мы работает напрямую с поставщиками, которые гарантируют высокое качество продукции. ABC-toy сотрудничает с такими поставщиками как: 
      <p>ТМ ВЕСЕЛЫЙ ПОВАР, Биплант, Бомик, БрикНик, Бондибон, Крона, Лесная сказка, МДИ, ОКСВА, Принцесса, Пелси, Пома, Развивашки, Росмэн, РУ-ТОЙЗ, Томик, ADEX, Castorland, COGO, DOLU, Edushape, ERPA, Halilit, Modular, RNToys, Scotchi, Yookidoo.</p></div>
  </div>
  <?php $this->renderPartial('_addProductModal'); ?>
</div><!-- page -->
<?php $this->renderPartial('_footer', array('groups' => $groups)); ?>
<div id="popup-window" style="display: none"></div>
<div id="bottom-bar">УКАЖИТЕ ВОЗРАСТ ВАШЕГО РЕБЕНКА И ПОЛУЧИТЕ СКИДКУ <span class="red">400 РУБЛЕЙ</span> НА ПЕРВУЮ ПОКУПКУ!<span id="get-discount" class="red" style="margin-left: 50px; text-decoration: underline; -moz-text-decoration-line: underline; cursor: pointer">ПОЛУЧИТЬ СКИДКУ</span></div>
<?php Yii::app()->clientScript->registerScriptFile('http://vk.com/js/api/share.js?90', CClientScript::POS_HEAD); ?>
<script type="text/javascript">
  $(function() {

    $('#popup-window').dialog({
      modal: true,
      resizable: false,
      width: 930,
      height: 500,
      autoOpen: false,
      dialogClass: 'popup-window',
      draggable: false,
      create: function(event, ui) {
        $(event.target).parent().css('position', 'fixed');
      }
    });
    $('#popup-window').on('click', '.popup-close', function() {
      $('#popup-window').dialog('close');
      if (getCookie('popup') !== '2') {
        setCookie('popup', '1', {expires: 2592000});
        $('#bottom-bar').css('display', 'inherit');
        $('#footer').css('margin-bottom', '44px');
      }
    });

    $('#get-discount').click(function() {
      $('#bottom-bar').css('display', 'none');
      $('#footer').css('margin-bottom', '0');
      $('#popup-window').dialog('open');
    });
    var popup = getCookie('popup');
    switch (popup) {
      case undefined:
        setCookie('popup', '0', {expires: 2592000});
      case '0':
        $('#popup-window').load('/popupWindow', function() {
          Cufon.replace('#popup-window .cufon');
        });
        $('#popup-window').dialog('open');
        break;
      case '1':
        $('#popup-window').load('/popupWindow', function() {
          Cufon.replace('#popup-window .cufon');
        });
        $('#bottom-bar').css('display', 'inherit');
        $('#footer').css('margin-bottom', '44px');
    }
  });

  $('#popup-window').on('click', '#popup-submit', function() {
    $(this).css('display', 'none');
    $('#popup-process').css('display', 'inherit');
    var children = [];
    $('.child').each(function() {
      var name = $(this).find('.name').val();
      var date = $(this).find('.date').val();
      var gender = $(this).find('input[type=radio]:checked').val();
      children.push({name: name, birthday: date, gender_id: gender});
    });
    var accept = $('#PopupForm_accept').prop('checked') ? 1 : 0;
    var email = $('#PopupForm_email').val();
    $.post('/popupWindow', {
      children: children,
      PopupForm: {accept: accept, email: email}
    }, function(data) {
      $('#popup-process').css('display', 'none');
      var result = JSON && JSON.parse(data) || $.parseJSON(data);
      switch (result.result) {
        case 'error':
          $('#popup-submit').css('display', 'inherit');
          $('#popup-form').html(result.html);
          $('input[type="radio"][class~="error"], input[type="checkbox"][class~="error"]')
                  .parent()
                  .css('border', '1px solid #cc3333')
                  .css('border-radius', '5px')
                  .css('padding', '4px');
          break;
        case 'exist':
          $('#popup-window').dialog('close');
          $('#popup-window').dialog('option', 'height', 120);
          $('#popup-window').dialog('option', 'width', 310);
          $('#popup-window').dialog('option', 'dialogClass', 'popup-email-exist');
          $('#popup-window').html(result.html);
          $('#popup-window').dialog('open');
          setTimeout(function() {
            $('#popup-window').dialog('close');
          }, 5000);
          break;
        case 'register':
          $('#popup-body').html(result.html);
          Cufon.replace('#popup-window .cufon');
          setCookie('popup', '2', {expires: 2592000});
          $('#login-menu').css('display', 'none');
          $('#profile-menu').css('display', 'inherit');
          yaCounter23309737.reachGoal('discount');
          break;
      }
    });
  });

// возвращает cookie с именем name, если есть, если нет, то undefined
  function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
  }

// устанавливает cookie c именем name и значением value
// options - объект с свойствами cookie (expires, path, domain, secure)
  function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
      var d = new Date();
      d.setTime(d.getTime() + expires * 1000);
      expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
      options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
      updatedCookie += "; " + propName;
      var propValue = options[propName];
      if (propValue !== true) {
        updatedCookie += "=" + propValue;
      }
    }

    document.cookie = updatedCookie;
  }

// удаляет cookie с именем name
  function deleteCookie(name) {
    setCookie(name, "", {expires: -1})
  }

</script>