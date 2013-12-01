<?php

/**
 * This is the model class for table "store_order".
 *
 * The followings are the available columns in table 'store_order':
 * @property string $id
 * @property string $profile_id
 * @property string $coupon_id
 * @property string $delivery_id
 * @property string $payment_id
 * @property string $time
 *
 * The followings are the available model relations:
 * @property Coupon $coupon
 * @property Delivery $delivery
 * @property Payment $payment
 * @property CustomerProfile $profile
 * @property OrderProduct[] $orderProducts
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'store_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profile_id, delivery_id, payment_id', 'required'),
			array('profile_id, delivery_id, payment_id, coupon_id', 'length', 'max'=>11),
			array('time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, profile_id, delivery_id, payment_id, coupon_id, time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'coupon' => array(self::BELONGS_TO, 'Coupon', 'coupon_id'),
			'delivery' => array(self::BELONGS_TO, 'Delivery', 'delivery_id'),
			'payment' => array(self::BELONGS_TO, 'Payment', 'payment_id'),
			'profile' => array(self::BELONGS_TO, 'CustomerProfile', 'profile_id'),
			'orderProducts' => array(self::HAS_MANY, 'OrderProduct', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'profile_id' => 'Профиль',
			'coupon_id' => 'Купон',
			'delivery_id' => 'Способ доставки',
			'payment_id' => 'Способ оплаты',
			'time' => 'Дата',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('profile_id',$this->profile_id,true);
		$criteria->compare('coupon_id',$this->coupon_id,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
