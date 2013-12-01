<?php

class m131201_074105_customer_profile_table extends CDbMigration {

  public function up() {
    $this->createTable('store_customer_profile', array(
      'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
      'session_id' => 'varchar(32)',
      'user_id' => 'int(11)',
      'fio' => 'string',
      'email' => 'string',
      'phone' => 'varchar(11)',
      'call_time_id' => 'tinyint',
      'city' => 'varchar(100)',
      'address' => 'string',
      'description' => 'text',
    ));

    $this->createTable('store_order', array(
      'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
      'profile_id' => 'int(11) UNSIGNED NOT NULL',
      'coupon_id' => 'int(11) UNSIGNED',
      'payment_id' => 'int(11) UNSIGNED',
      'delivery_id' => 'int(11) UNSIGNED',
      'coupon_id' => 'int(11) UNSIGNED',
      'time' => 'time',
    ));
    $this->addForeignKey('order_profile', 'store_order', 'profile_id'
        , 'store_customer_profile', 'id');
    $this->addForeignKey('order_delivery', 'store_order', 'delivery_id'
        , 'store_delivery', 'id');
    $this->createTable('store_order_product', array(
      'order_id' => 'int(11) UNSIGNED NOT NULL',
      'product_id' => 'int(11) UNSIGNED NOT NULL',
      'quantity' => 'smallint UNSIGNED',
      'price' => 'decimal(12,2) UNSIGNED',
    ));
    $this->addForeignKey('order_product', 'store_order_product', 'order_id'
        , 'store_order', 'id');
    $this->addForeignKey('product_order', 'store_order_product', 'product_id'
        , 'store_product', 'id');
  }

  public function down() {
    echo "m131201_074105_customer_profile_table does not support migration down.\n";
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