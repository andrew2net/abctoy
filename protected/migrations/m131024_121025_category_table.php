<?php

class m131024_121025_category_table extends CDbMigration {

  public function up() {
    $this->createTable('store_category', array(
      'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
      'name' => 'varchar(30) NOT NULL',
      'url' => 'string NOT NULL',
      'lft' => 'integer UNSIGNED NOT NULL DEFAULT 0',
      'rgt' => 'integer UNSIGNED NOT NULL DEFAULT 0',
      'level' => 'integer UNSIGNED NOT NULL DEFAULT 0',
        )
    );
    $this->createIndex('name_UNIQUE', 'store_category', 'name', TRUE);
    $this->createIndex('lft', 'store_category', 'lft');
    $this->createIndex('rgt', 'store_category', 'rgt');
    $this->createIndex('level', 'store_category', 'level');
    
    $this->insert('store_category', array(
      'id'=>1,
      'name'=>'root',
      'url'=>'',
      'lft'=>1,
      'rgt'=>2,
      'level'=>0
      ));
  }

  public function down() {
    echo "m131024_121025_categories_table does not support migration down.\n";
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