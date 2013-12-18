<?php

class m131218_191012_phone_20_chars extends CDbMigration
{
	public function up()
	{
    $this->alterColumn('store_customer_profile', 'phone', 'varchar(20)');
	}

	public function down()
	{
		echo "m131218_191012_phone_20_chars does not support migration down.\n";
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