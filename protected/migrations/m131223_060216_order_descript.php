<?php

class m131223_060216_order_descript extends CDbMigration {

  public function up() {
    $this->addColumn('store_order', 'call_time_id', 'tinyint');
    $this->addColumn('store_order', 'description', 'text');

    Yii::import('application.models.Order');
    Yii::import('application.models.CustomerProfile');
    $order = Order::model()->findAll();
    foreach ($order as $value) {
      $value->call_time_id = $value->profile->call_time_id;
      $value->description = $value->profile->description;
      $value->save();
    }
    
    $this->dropColumn('store_customer_profile', 'call_time_id');
    $this->dropColumn('store_customer_profile', 'description');
  }

  public function down() {
    echo "m131223_060216_order_descript does not support migration down.\n";
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