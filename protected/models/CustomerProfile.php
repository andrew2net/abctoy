<?php

/**
 * This is the model class for table "store_customer_profile".
 *
 * The followings are the available columns in table 'store_customer_profile':
 * @property string $id
 * @property string $session_id
 * @property integer $user_id
 * @property string $fio
 * @property string $email
 * @property string $phone
 * @property integer $call_time_id
 * @property string $city
 * @property string $address
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property array $callTimes 
 * @property string $callTime
 */
class CustomerProfile extends CActiveRecord
{
    private $call_times = array(
      '0' => 'Любое время',
      '1' => 'с 9 до 12',
      '2' => 'с 12 до 14',
      '3' => 'с 14 до 18',
      '4' => 'с 18 до 20',
      );

  public function getCallTimes() {
    return $this->call_times;
  }

  public function getCallTime() {
    return $this->call_times[$this->call_time_id];
  }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'store_customer_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, call_time_id', 'numerical', 'integerOnly'=>true),
			array('session_id', 'length', 'max'=>32),
			array('fio, email, address', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>11),
			array('city', 'length', 'max'=>100),
      array('fio, email, phone, city', 'required'),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, session_id, user_id, fio, email, phone, call_time_id, city, address, description', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'profile_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'session_id' => 'Session',
			'user_id' => 'User',
			'fio' => 'Имя фамилия',
			'email' => 'E-mail',
			'phone' => 'Телефон',
			'call_time_id' => 'Время звонка',
			'city' => 'Город',
			'address' => 'Адрес',
			'description' => 'Коменнтарий',
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
		$criteria->compare('session_id',$this->session_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('fio',$this->fio,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('call_time_id',$this->call_time_id);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomerProfile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
