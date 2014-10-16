<?php

/**
 * This is the model class for table "{{organization}}".
 *
 * The followings are the available columns in table '{{organization}}':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $email
 * @property string $INN
 * @property string $KPP
 * @property string $Bank
 * @property string $CurrentAccount
 * @property string $CorrespondentAccount
 * @property string $OKVED
 * @property string $OKPO
 * @property string $BIC
 */
class Organization extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{organization}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, address, INN, KPP', 'required'),
			array('name, address', 'length', 'max'=>255),
			array('email, CurrentAccount, CorrespondentAccount', 'length', 'max'=>100),
			array('CorrespondentAccount, CurrentAccount', 'length', 'max'=>20),  
			array('INN, KPP, CurrentAccount, CorrespondentAccount, OKVED, OKPO, BIC', 'numerical', 'integerOnly'=>true),
			array('INN', 'length', 'max'=>12),  
			array('BIC', 'length', 'max'=>9),  
			array('CorrespondentAccount, CurrentAccount', 'length', 'max'=>20),  
			array('INN', 'match', 'pattern'=>'/\d{10,12}/', 'message'=>Yii::t('general', 'INN') . ' ' . Yii::t('general', 'should contain between 10 and 12 digits')), 
			array('BIC', 'match', 'pattern'=>'/\d{9}/', 'message'=> Yii::t('general', 'BIC') . ' ' .Yii::t('general', 'should contain exact 9 digits')), 
			array('CorrespondentAccount', 'match', 'pattern'=>'/\d{20}/', 'message'=> Yii::t('general', 'Correspondent Account') . ' ' . Yii::t('general','should contain exact 20 digits')), 
			array('CurrentAccount', 'match', 'pattern'=>'/\d{20}/', 'message'=> Yii::t('general', 'Current Account') . ' ' . Yii::t('general','should contain exact 20 digits')), 
			 /*   р/с и к/с 20 чисел
				  бик 9
				  инн от 10 до 12 знаков 
				*/
			array('Bank', 'length', 'max'=>255),    
			array('id, name, address, email, phone, INN, KPP, Bank, CurrentAccount, CorrespondentAccount, OKVED, OKPO, BIC', 'safe', 'on'=>'search'),
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
			'address' => Yii::t('general','Address'),
			'email' => Yii::t('general','Email'),
			'phone' => Yii::t('general','Phone'),
			'INN' => Yii::t('general','INN'),
			'KPP' => Yii::t('general','KPP'),
			'Bank' => Yii::t('general','Bank'),
			'CurrentAccount' => Yii::t('general','Current Account'),
			'CorrespondentAccount' => Yii::t('general','Correspondent Account'),
			'OKVED' => Yii::t('general','OKVED'),
			'OKPO' => Yii::t('general','OKPO'),
			'BIC' => Yii::t('general','BIC'),
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
		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('INN',$this->INN,true);
		$criteria->compare('KPP',$this->KPP,true);
		$criteria->compare('Bank',$this->Bank,true);
		$criteria->compare('CurrentAccount',$this->CurrentAccount,true);
		$criteria->compare('CorrespondentAccount',$this->CorrespondentAccount,true);
		$criteria->compare('OKVED',$this->OKVED,true);
		$criteria->compare('OKPO',$this->OKPO,true);
		$criteria->compare('BIC',$this->BIC,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Organization the static model class
	 */
	public static function model($className=__CLASS__)
	{ 
		return parent::model($className);
	}
}
