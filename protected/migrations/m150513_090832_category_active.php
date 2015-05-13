<?php

class m150513_090832_category_active extends CDbMigration
{
	public function up()
	{
      $this->addColumn('store_category', 'active', 'boolean');
      $this->update('store_category', array('active' => TRUE));
	}

	public function down()
	{
		echo "m150513_090832_category_active does not support migration down.\n";
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