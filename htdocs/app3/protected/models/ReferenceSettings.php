<?php

/**
 * This is the model class for table "{{reference_settings}}".
 *
 * The followings are the available columns in table '{{reference_settings}}':
 * @property integer $Id
 * @property string $Name
 * @property string $Reference
 * @property string $StoreFields
 * @property string $Items
 * @property string $Filters
 * @property string $Users
 * @property string $DefaultFor
 * @property string $SearchFieldSettings
 */
class ReferenceSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{referencesettings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, Reference, StoreFields, Items, Filters, Users, DefaultFor, SearchFieldSettings', 'required'),
			array('Name, Reference, Users, DefaultFor', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Name, Reference, StoreFields, Items, Filters, Users, DefaultFor, SearchFieldSettings', 'safe', 'on'=>'search'),
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
			'Id' => Yii::t('general','ID'),
			'Name' => Yii::t('general','Name'),
			'Reference' => Yii::t('general','Reference'),
			'StoreFields' => Yii::t('general','Store Fields'),
			'Items' => Yii::t('general','Items'),
			'Filters' => Yii::t('general','Filters'),
			'Users' => Yii::t('general','Users'),
			'DefaultFor' => Yii::t('general','Default For'),
			'SearchFieldSettings' => Yii::t('general','Search Field Settings'),
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Reference',$this->Reference,true);
		$criteria->compare('StoreFields',$this->StoreFields,true);
		$criteria->compare('Items',$this->Items,true);
		$criteria->compare('Filters',$this->Filters,true);
		$criteria->compare('Users',$this->Users,true);
		$criteria->compare('DefaultFor',$this->DefaultFor,true);
		$criteria->compare('SearchFieldSettings',$this->SearchFieldSettings,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReferenceSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
