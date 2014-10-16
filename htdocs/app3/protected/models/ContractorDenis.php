<?php

/**
 * This is the model class for table "{{contractor}}".
 *
 * The followings are the available columns in table '{{contractor}}':
 * @property string $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property integer $organizationId
 * @property integer $userId
 * @property string $note
 * @property string $inn
 * @property string $kpp
 */
class ContractorDenis extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contractor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address, phone, organizationId, userId, note, inn, kpp', 'required'),
			array('organizationId, userId', 'numerical', 'integerOnly'=>true),
			array('name, address', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>15),
			array('email', 'length', 'max'=>50),
			array('inn, kpp', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, address, phone, email, organizationId, userId, note, inn, kpp', 'safe', 'on'=>'search'),
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
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('general','Primary key'),
			'name' => Yii::t('general','имя контрагента'),
			'address' => Yii::t('general','адрес контрагента'),
			'phone' => Yii::t('general','телефон контрагента'),
			'email' => Yii::t('general','Email'),
			'organizationId' => Yii::t('general','organizationId'),
			'userId' => Yii::t('general','userId'),
			'note' => Yii::t('general','note'),
			'inn' => Yii::t('general','inn'),
			'kpp' => Yii::t('general','kpp'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('organizationId',$this->organizationId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('inn',$this->inn,true);
		$criteria->compare('kpp',$this->kpp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContractorDenis the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
