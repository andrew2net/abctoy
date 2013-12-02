<?php

class m131202_180709_order_product_pk extends CDbMigration {

  public function up() {
    $this->addPrimaryKey('pk', 'store_order_product', 'order_id, product_id');
  }

  public function down() {
    echo "m131202_180709_order_product_pk does not support migration down.\n";
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