<?php

class m131109_141056_delivery_table extends CDbMigration {

  public function up() {
    $this->createTable('store_delivery', array(
      'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
      'name' => 'varchar(30) NOT NULL',
      'description' => 'text',
    ));
    $this->createTable('store_city', array(
      'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
      'name' => 'varchar(100)',
    ));
    $this->createTable('store_city_delivery', array(
      'city_id' => 'int(11) UNSIGNED NOT NULL PRIMARY KEY',
      'delivery_id' => 'int(11) UNSIGNED NOT NULL PRIMARY KEY',
      'price' => 'decimal(10,2) UNSIGNED',
    ));
    $this->addForeignKey('city_delivery', 'store_city_delivery', 'city_id'
        , 'store_city', 'id', 'CASCADE');
    $this->addForeignKey('delivery_city', 'store_city_delivery', 'delivery_id'
        , 'store_delivery', 'id', 'CASCADE');
  }

  public function down() {
    echo "m131109_141056_delivery_table does not support migration down.\n";
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