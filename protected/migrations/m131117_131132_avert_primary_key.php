<?php

class m131117_131132_avert_primary_key extends CDbMigration {

  public function up() {
    $this->dropForeignKey('product_action', 'store_product_action');
    $this->dropPrimaryKey('PRIMARY', 'store_product_action');
    $this->addPrimaryKey('PRIMARY', 'store_product_action', 'action_id');
    $this->addForeignKey('product_action', 'store_product_action', 'product_id'
        , 'store_product', 'id', 'CASCADE');
  }

  public function down() {
    echo "m131117_131132_avert_primary_key does not support migration down.\n";
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