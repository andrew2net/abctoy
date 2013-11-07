<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
  'aliases' => array(
    'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
  ),
  'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
  'name' => 'ABC toy',
  'defaultController' => 'site',
  // preloading 'log' component
  'preload' => array('log'),
  // autoloading model and component classes
  'import' => array(
    'application.models.*',
    'application.components.*',
    'application.modules.user.models.*',
    'application.modules.user.components.*',
    'bootstrap.helpers.TbHtml',
  ),
  'theme' => 'abctoy', // requires you to copy the theme under your themes directory
  'modules' => array(
    'admin',
    'auth' => array(
      'userNameColumn' => 'username',
      'defaultLayout' => 'application.modules.admin.views.layouts.main',
    ),
    'user' => array(
# encrypting method (php hash function)
      'hash' => 'md5',
      # send activation email
      'sendActivationMail' => true,
      # allow access for non-activated users
      'loginNotActiv' => false,
      # activate user on registration (only sendActivationMail = false)
      'activeAfterRegister' => true,
      # automatically login from registration
      'autoLogin' => true,
      # registration path
      'registrationUrl' => array('/user/registration'),
      # recovery password path
      'recoveryUrl' => array('/user/recovery'),
      # login form path
      'loginUrl' => array('/login'),
      # page after login
      'returnUrl' => array('/profile'),
      # page after logout
      'returnLogoutUrl' => array('/user/login'),
      'layoutPath' => 'protected/modules/admin/views/layouts',
      'layout' => 'main',
    ),
    'catalog'=>array(
      'layoutPath' => 'protected/modules/admin/views/layouts',
      'layout' => 'main',
    ),
    'discount'=>array(
      'layoutPath' => 'protected/modules/admin/views/layouts',
      'layout' => 'main',
    ),
//    'gii' => array(
//      'generatorPaths' => array('bootstrap.gii',),
//      'class' => 'system.gii.GiiModule',
//      'password' => 'proba',
// If removed, Gii defaults to localhost only. Edit carefully to taste.
//      'ipFilters' => array('127.0.0.1', '::1'),
//    ),
  ),
  // application components
  'components' => array(
    'bootstrap' => array(
      'class' => 'bootstrap.components.TbApi',
    ),
    'user' => array(
// enable cookie-based authentication
      'allowAutoLogin' => true,
//      'class' => 'RWebUser',
//      'class' => 'WebUser',
      'loginUrl' => array('/login'),
      'class' => 'auth.components.AuthWebUser',
      'admins' => array('admin'), // users with full access
    ),
    'authManager' => array(
      'class' => 'CDbAuthManager',
      'connectionID' => 'db',
      'behaviors' => array(
        'auth' => array(
          'class' => 'auth.components.AuthBehavior',
        ),
      ),
    ),
    // uncomment the following to enable URLs in path-format
    'urlManager' => array(
      'urlFormat' => 'path',
      'showScriptName' => FALSE,
      'rules' => array(
        'admin/<_m:(catalog|discount)>'=>'<_m>',
        'admin/<_m:(catalog|discount)>/<_c:\w+>'=>'<_m>/<_c>',
        'admin/<_m:(catalog|discount)>/<_c:\w+>/<_a:\w+>'=>'<_m>/<_c>/<_a>',
        'admin/user' => 'user/user',
        'admin/user/<_a:(update|create|delete)>' => 'user/admin/<_a>',
        'admin/user/<_a:\w+>' => 'user/user/<_a>',
        'admin/auth' => 'auth',
        'admin/auth/<_c:\w+>' => 'auth/<_c>',
        'admin/auth/<_c:\w+>/<_a:\w+>' => 'auth/<_c>/<_a>',
        '<_c:(login|logout)>' => 'site/<_c>',
        '<controller:\w+>/<id:\d+>' => '<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '<_p:(about|delivery_payment|guarantee|faq|contact)>' => 'site/page/url/<_p>',
      ),
    ),
    /*
      'db'=>array(
      'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
      ),
     */
// uncomment the following to use a MySQL database
    /*
     */
    'db' => array(
      'connectionString' => 'mysql:host=localhost;dbname=toys',
      'emulatePrepare' => true,
      'username' => 'root',
      'password' => 'passdb',
      'charset' => 'utf8',
      'tablePrefix' => 'tbl_',
    ),
    'errorHandler' => array(
// use 'site/error' action to display errors
//      'errorAction' => 'site/error',
    ),
    'log' => array(
      'class' => 'CLogRouter',
      'routes' => array(
        array(
          'class' => 'CFileLogRoute',
          'levels' => 'error, warning',
        ),
      // uncomment the following to show log messages on web pages
      /*
        array(
        'class'=>'CWebLogRoute',
        ),
       */
      ),
    ),
  ),
  // application-level parameters that can be accessed
// using Yii::app()->params['paramName']
  'params' => array(
// this is used in contact page
    'adminEmail' => 'andriano@ngs.ru',
  ),
  'sourceLanguage' => 'en',
  'language' => 'ru'
);
