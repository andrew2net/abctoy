<?php

class m131205_205758_product_name_increase extends CDbMigration
{
	public function up()
	{
    $this->alterColumn('store_product', 'name', 'string');
	}

	public function down()
	{
		echo "m131205_205758_product_name_increase does not support migration down.\n";
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