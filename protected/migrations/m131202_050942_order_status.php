<?php

class m131202_050942_order_status extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_order', 'status_id', 'tinyint NOT NULL');
    $this->alterColumn('store_order', 'time', 'datetime');
	}

	public function down()
	{
		echo "m131202_050942_order_status does not support migration down.\n";
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