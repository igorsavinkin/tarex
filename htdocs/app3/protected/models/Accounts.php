<?php

/**
 * This is the model class for table "{{accounts}}".
 *
 * The followings are the available columns in table '{{accounts}}':
 * @property integer $id
 * @property string $name
 * @property string $CustomerName
 * @property integer $AccountNumber
 * @property integer $AccountCurrency
 * @property double $AccountLimit
 * @property integer $ParentCustomer
 */
class Accounts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{accounts}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, CustomerName, AccountNumber, AccountCurrency, AccountLimit, ParentCustomer', 'required'),
			array('AccountNumber, AccountCurrency, ParentCustomer', 'numerical', 'integerOnly'=>true),
			array('AccountLimit', 'numerical'),
			array('name, CustomerName', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, CustomerName, AccountNumber, AccountCurrency, AccountLimit, ParentCustomer', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('general','ID'),
			'name' => Yii::t('general','Name'),
			'CustomerName' => Yii::t('general','Customer Name'),
			'AccountNumber' => Yii::t('general','Account Number'),
			'AccountCurrency' => Yii::t('general','Account Currency'),
			'AccountLimit' => Yii::t('general','Account Limit'),
			'ParentCustomer' => Yii::t('general','Parent Customer'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('CustomerName',$this->CustomerName,true);
		$criteria->compare('AccountNumber',$this->AccountNumber);
		$criteria->compare('AccountCurrency',$this->AccountCurrency);
		$criteria->compare('AccountLimit',$this->AccountLimit);
		$criteria->compare('ParentCustomer',$this->ParentCustomer);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Accounts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
