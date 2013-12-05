<?php

class m131205_191639_cart_no_accept extends CDbMigration
{
	public function up()
	{
    $this->update('store_payment', array('description'=>'<span class="red">В данный момент прием оплаты по банковским картам не осуществляется, приносим свои извинения.</span>'), 'id=2');
	}

	public function down()
	{
		echo "m131205_191639_cart_no_accept does not support migration down.\n";
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