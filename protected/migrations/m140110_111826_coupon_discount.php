<?php

class m140110_111826_coupon_discount extends CDbMigration {

  public function up() {
    $this->alterColumn('store_order_product', 'discount', 'DECIMAL(12,2)');
    Yii::import('application.models.OrderProduct');
    Yii::import('application.modules.catalog.models.Product');
    $order_product = OrderProduct::model()->findAll();
    foreach ($order_product as $value) {
      $value->discount = $value->product->price - $value->price;
      $value->save();
    }
  }

  public function down() {
    echo "m140110_111826_coupon_discount does not support migration down.\n";
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