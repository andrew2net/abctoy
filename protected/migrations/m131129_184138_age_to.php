<?php

class m131129_184138_age_to extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_product', 'age_to', 'tinyint UNSIGNED');
	}

	public function down()
	{
		echo "m131129_184138_age_to does not support migration down.\n";
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