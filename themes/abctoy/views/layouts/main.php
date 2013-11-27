<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/abctoy/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/abctoy/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
  </head>

  <body>
    <?php echo $content; ?>
    <script type="text/javascript"> Cufon.now();</script>
  </body>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/abctoy/js/cufon-yui.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/abctoy/js/RotondaC_400-RotondaC_700.font.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/abctoy/js/submenu.js"></script>
  <script type="text/javascript">
    Cufon.replace(".cufon");
  </script>
</html>
