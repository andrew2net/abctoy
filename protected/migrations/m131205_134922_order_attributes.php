<?php

class m131205_134922_order_attributes extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_order', 'fio', 'string');
    $this->addColumn('store_order', 'email', 'string');
    $this->addColumn('store_order', 'phone', 'varchar(11)');
    $this->addColumn('store_order', 'city', 'varchar(100)');
    $this->addColumn('store_order', 'address', 'string');
	}

	public function down()
	{
		echo "m131205_134922_order_attributes does not support migration down.\n";
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