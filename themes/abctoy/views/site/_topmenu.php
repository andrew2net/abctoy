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
          'url' => array('#'),
//          'visible' => Yii::app()->user->isGuest,
          'itemOptions' => array(
            'id' => 'login-menu',
            'class' => 'align-right',
            'style' => 'padding-right: 50px',
            'style' => 'display:' . (Yii::app()->user->isGuest ? 'inherit' : 'none')
          ),
        ),
        array(
          'label' => 'Личный кабинет',
          'url' => array('/profile'),
//          'visible' => !Yii::app()->user->isGuest,
          'itemOptions' => array(
            'id' => 'profile-menu',
            'class' => 'align-right',
            'style' => 'display:' . (Yii::app()->user->isGuest ? 'none' : 'inherit')
          ),
        ),
      ),
//      'htmlOptions'=>array('style'=>'line-height: 2em')
    ))
    ?>
  </div>
</div>
<div id="login-dialog">
  <div style="display: inline-block; vertical-align: top">
    <div><?php echo CHtml::label('Имя или Email', 'login'); ?></div>
    <div><?php echo CHtml::textField('login', '', array('style' => 'width: 150px')); ?></div>
  </div>
  <div style="display: inline-block; vertical-align: top; margin-left: 3px">
    <div><?php echo CHtml::label('Пароль', 'password'); ?></div>
    <div><?php echo CHtml::passwordField('password', '', array('style' => 'width: 150px')); ?></div>
  </div>
  <div style="height: 10px; text-align: center"><span style="font-size: 8pt; display: none" class="red passw-err">Неверное имя или пароль</span></div>
  <div style="margin-top: 5px" class="right">
    <div style="cursor: pointer;margin-bottom: 10px" id="submit-password" class="blue">Вход</div>
    <div id="close-login-dialog" class="blue" style="text-align: right; cursor: pointer;font-size: 8pt">Закрыть окно</div>
  </div>
  <div  style="margin-top: 5px">
    <div id="registr" class="blue" style="cursor: pointer">Зрегистрироваться</div>
    <div id="recover-password" class="blue passw-err" style="cursor: pointer; display: none;font-size: 9pt; margin-top: 5px">Восстановить доступ?</div>
    <img src="/images/process.gif" style="display: none; margin: 5px 35px" id="loading-dialog" />
    <div id="sent-mail-recovery" style="font-size: 9pt; display: none; cursor: pointer"></div>
  </div>
</div>
<script type="text/javascript">

  $(function() {
    $("#login-dialog").dialog({
      autoOpen: false,
      minHeight: 80,
      draggable: false,
      resizable: false,
      width: 350,
      position: {
//        my: 'left top+20',
        at: 'right-400 top+90',
        of: '#topmenu'
      },
      dialogClass: "login-dialog",
      create: function(event, ui) {
        $(event.target).parent().css('position', 'fixed');
      },
      close: function() {
        $('.passw-err').css('display', 'none');
        $('#recover-password').css('display', 'none');
        $('#loading-dialog').css('display', 'none');
        $('#sent-mail-recovery').css('display', 'none');
      },
      show: {
        effect: "blind",
        duration: 500
      },
      hide: {
        effect: "blind",
        duration: 500
      }
    });
  });

  $('#submit-password').click(function() {
    var login = $('#login').val();
    var passw = $('#password').val();
    $.post('/login', {
      login: login,
      passw: passw
    }, function(data) {
      $('#sent-mail-recovery').css('display', 'none');
      var result = JSON && JSON.parse(data) || $.parseJSON(data);
      if (result.result) {
        $("#login-dialog").dialog('close');
        $('#login-menu').css('display', 'none');
        $('#profile-menu').css('display', 'inherit');
        $('#shoppingCart').html(result.cart);
      } else {
//        $('#registr').css('display', 'none');
        $('.passw-err').css('display', 'inherit');
        $('#recover-password').css('display', 'inherit');
      }
    });
  });

  $('#recover-password').click(function() {
    var login = $('#login').val();
    $('.passw-err').css('display', 'none');
    $('#loading-dialog').css('display', 'inline');
    $.post('/user/recovery/passwrecover', {
      login: login
    }, function(data) {
      $('#loading-dialog').css('display', 'none');
      var result = JSON && JSON.parse(data) || $.parseJSON(data);
      if (result.result) {
        $('#sent-mail-recovery').html('Инструкции для восстановления пароля высланы на Email ' + result.email).css('color', '#99cc33').css('margin-top', '0');
        $('#sent-mail-recovery').css('display', 'inherit');
      } else {
        $('#sent-mail-recovery').html('Не найден пользователь или Email').css('color', '#cc3333').css('margin-top', '5px');
        $('#sent-mail-recovery').css('display', 'inherit');
      }
    });
  });

  $('#sent-mail-recovery').click(function() {
    $(this).css('display', 'none');
    $('#recover-password').css('display', 'inherit');
  });

  $('#login-menu a').click(function(event) {
    event.preventDefault();
    if ($('#login-dialog').dialog('isOpen'))
      $("#login-dialog").dialog('close');
    else
      $('#login-dialog').dialog('open');
  });

  $('#close-login-dialog').click(function() {
    $("#login-dialog").dialog('close');
  });

</script>
