<?php

class m131205_092059_order_delivery_summ extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_order', 'delivery_summ', 'decimal(10,2)');
	}

	public function down()
	{
		echo "m131205_092059_order_delivery_summ does not support migration down.\n";
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