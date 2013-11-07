<?php

class m131107_162737_coupon_table extends CDbMigration {

  public function up() {
    $this->createTable('store_coupon', array(
      'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
      'code' => 'varchar(8)',
    ));
  }

  public function down() {
    echo "m131107_162737_coupon_table does not support migration down.\n";
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