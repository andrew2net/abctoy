<?php

class m140122_181531_big_img_jpg extends CDbMigration {

  public function up() {
    Yii::import('application.modules.catalog.models.Product');
    $product = Product::model()->findAll();
    $rootpath = Yii::app()->basePath . '/..';
    foreach ($product as $item) {
      if (strlen($item->img) && !preg_match('/\./', $item->img)) {
        rename($rootpath . $item->img, $rootpath . $item->img . '.jpg');
        $item->img .= '.jpg';
        $item->update(array('img'));
      }
    }
  }

  public function down() {
    echo "m140122_181531_big_img_jpg does not support migration down.\n";
    return false;
  }

  /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
   */
}