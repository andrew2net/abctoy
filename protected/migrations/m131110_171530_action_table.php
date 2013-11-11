<?php

class m131110_171530_action_table extends CDbMigration {

  public function up() {
    $this->createTable('store_action', array(
      'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
      'type_id'=>'tinyint UNSIGNED NOT NULL',
      'name' => 'varchar(30)',
      'text' => 'text',
      'date' => 'date',
      'img' => 'string',
      'product_id' => 'int(11) UNSIGNED',
    ));
    $this->addForeignKey('action_product', 'store_action', 'product_id'
        , 'store_product', 'id', 'RESTRICT');
  }

  public function down() {
    echo "m131110_171530_action_table does not support migration down.\n";
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