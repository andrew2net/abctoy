<?php

class m131201_155431_pament_table extends CDbMigration {

  public function up() {
    $this->createTable('store_payment', array(
      'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
      'name' => 'string',
      'description' => 'text',
    ));
    
    $this->addForeignKey('order_payment', 'store_order', 'payment_id'
        , 'store_payment', 'id');
    Yii::app()->db->createCommand()->insert('store_payment', array(
      'name'=>'Наличными',
      'description' => 'Оплата наличными при получении заказа у курьера или в нашем офисе',
    ));
  }

  public function down() {
    echo "m131201_155431_pament_table does not support migration down.\n";
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