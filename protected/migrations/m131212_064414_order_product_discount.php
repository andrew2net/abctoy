<?php

class m131212_064414_order_product_discount extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_order_product', 'discount', 'tinyint(3)');
	}

	public function down()
	{
		echo "m131212_064414_order_product_discount does not support migration down.\n";
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