<?php
/* @var $email string */
?>
<div id="close-dialog" class="blue" style="text-align: right; cursor: pointer;font-size: 8pt; margin-bottom: 8px">Закрыть окно</div>
<div>Пользователь с адресом электронной почты <?php echo $email; ?> уже зарегистрирован</div>
<script type="text/javascript">
  $('#close-dialog').click(function() {
    $('#popup-window').dialog('close');
  });
</script>  