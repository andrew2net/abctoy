<?php

class m131203_100223_add extends CDbMigration
{
	public function up()
	{
    Yii::app()->db->createCommand()->insert('store_payment', array(
      'name'=>'Безналичный расчет',
      'description' => 'Для оплаты покупки Вы будете перенаправлены на платежный шлюз для ввода реквизитов Вашей карты',
    ));
	}

	public function down()
	{
		echo "m131203_100223_add does not support migration down.\n";
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