<?php

class m140208_162653_delvery_discount extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_city_delivery', 'summ', 'decimal(12,2) UNSIGNED');
	}

	public function down()
	{
		echo "m140208_162653_delvery_discount does not support migration down.\n";
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