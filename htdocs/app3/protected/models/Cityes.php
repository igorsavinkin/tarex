<?php

/**
 * This is the model class for table "{{cityes}}".
 *
 * The followings are the available columns in table '{{cityes}}':
 * @property integer $Id
 * @property string $Name
 * @property string $Area
 * @property string $District
 * @property double $Latitude
 * @property double $Longitude
 */
class Cityes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cityes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, Area, District, Latitude, Longitude', 'required'),
			array('Latitude, Longitude', 'numerical'),
			array('Name, Area, District', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Name, Area, District, Latitude, Longitude', 'safe', 'on'=>'search'),
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
			'Area' => Yii::t('general','Область'),
			'District' => Yii::t('general','Округ'),
			'Latitude' => Yii::t('general','Широта'),
			'Longitude' => Yii::t('general','Долгота'),
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
		$criteria->compare('Area',$this->Area,true);
		$criteria->compare('District',$this->District,true);
		$criteria->compare('Latitude',$this->Latitude);
		$criteria->compare('Longitude',$this->Longitude);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cityes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
