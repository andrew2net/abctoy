<?php

class m131116_122036_action_product extends CDbMigration {

  public function up() {
    $this->dropForeignKey('action_product', 'store_action');
    $this->dropColumn('store_action', 'text');
    $this->dropColumn('store_action', 'date');
    $this->dropColumn('store_action', 'product_id');
    $this->addColumn('store_action', 'show', 'boolean');
    
    $this->createTable('store_product_action', array(
      'product_id' => 'int(11) UNSIGNED NOT NULL PRIMARY KEY',
      'action_id' => 'int(11) UNSIGNED',
      'text' => 'text',
      'date' => 'date',
    ));
    
    $this->addForeignKey('action_product', 'store_product_action', 'action_id'
        , 'store_action', 'id', 'CASCADE');
    $this->addForeignKey('product_action', 'store_product_action', 'product_id'
        , 'store_product', 'id', 'CASCADE');
  }

  public function down() {
    echo "m131116_122036_action_product does not support migration down.\n";
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