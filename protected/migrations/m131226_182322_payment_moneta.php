<?php

class m131226_182322_payment_moneta extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_payment', 'mnt_id', 'varchar(8)');
    $this->addColumn('store_payment', 'mnt_signature', 'string');
    $this->addColumn('store_payment', 'type_id', 'tinyint');
    $this->update('store_payment', array('type_id'=>0), "name='Наличными'");
    $this->update('store_payment', array('type_id'=>1), "name='Безналичный расчет'");
	}

	public function down()
	{
		echo "m131226_182322_payment_moneta does not support migration down.\n";
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