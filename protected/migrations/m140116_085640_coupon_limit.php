<?php

class m140116_085640_coupon_limit extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_coupon', 'date_limit', 'date');
	}

	public function down()
	{
		echo "m140116_085640_coupon_limit does not support migration down.\n";
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