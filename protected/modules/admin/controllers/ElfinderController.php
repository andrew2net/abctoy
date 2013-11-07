<?php

class ElfinderController extends CController {

  public function filters() {
    return array(array('auth.filters.AuthFilter'));
}
  public function actions() {
    return array(
      'connector' => array(
        'class' => 'ext.elFinder.ElFinderConnectorAction',
        'settings' => array(
          'root' => Yii::getPathOfAlias('webroot') . '/uploads/',
          'URL' => Yii::app()->baseUrl . '/uploads/',
          'rootAlias' => 'Home',
          'mimeDetect' => 'none'
        )
      ),
    );
  }

}