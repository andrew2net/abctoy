<?php

class m131113_162745_product_small_image extends CDbMigration
{
	public function up()
	{
    $this->addColumn('store_product', 'small_img', 'string');
	}

	public function down()
	{
		echo "m131113_162745_product_small_image does not support migration down.\n";
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