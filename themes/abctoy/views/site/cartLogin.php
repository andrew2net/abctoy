<?php
/* @var $order Order */
/* @var $profile CustomerProfile */
?>
<?php $this->pageTitle = Yii::app()->name . ' - Ввод пароля'; ?>
<div class="container" id="page">
  <?php
  $this->renderPartial('_topblock');
  if (isset($profile)) {
    ?>
    <div class="cufon gray bold" style="font-size: 20pt; margin-top: 30px">Пользователь с адресом электройнной <?php echo $profile->email; ?> почты уже зарегистрирован на этом сайте.</div>
    <div class="cufon gray bold" style="font-size: 20pt; margin-top: 30px">Чтобы войти в личный кабинет, небходимо ввести пароль.</div>
    <?php echo CHtml::beginForm('cartlogin'); ?>
    <?php echo CHtml::hiddenField('profile_id', $profile->id); ?>
    <?php echo CHtml::hiddenField('order_id', $orders->id); ?>
    <?php echo CHtml::label('Пароль', 'password'); ?>
    <?php echo CHtml::passwordField('password'); ?>
    <?php echo CHtml::submitButton('Вход'); ?>
    <?php echo CHtml::endForm(); ?>
  <?php } ?>
</div>
