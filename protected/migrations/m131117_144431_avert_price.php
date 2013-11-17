<?php

class m131117_144431_avert_price extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_product_action', 'price', 'decimal(12,2) UNSIGNED');
	}

	public function down()
	{
		echo "m131117_144431_avert_price does not support migration down.\n";
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