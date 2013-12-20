<?php

class m131219_201122_children_table extends CDbMigration {

  public function up() {
    $this->createTable('store_child', array(
      'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
      'profile_id' => 'int(11) UNSIGNED NOT NULL',
      'name' => 'varchar(30)',
      'gender_id' => 'tinyint(1)',
      'birthday' => 'date',
    ));
    $this->addForeignKey('child_profile', 'store_child', 'profile_id',
        'store_customer_profile', 'id', 'RESTRICT');
  }

  public function down() {
    echo "m131219_181122_children_table does not support migration down.\n";
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