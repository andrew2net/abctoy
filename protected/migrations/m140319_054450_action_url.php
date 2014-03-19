<?php

class m140319_054450_action_url extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_action', 'url', 'string');
	}

	public function down()
	{
		echo "m140319_054450_action_url does not support migration down.\n";
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