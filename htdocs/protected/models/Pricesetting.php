<?php

/**
 * This is the model class for table "{{pricesetting}}".
 *
 * The followings are the available columns in table '{{pricesetting}}':
 * @property integer $id
 * @property string $dateTime
 * @property double $RURrate
 * @property double $EURrate
 * @property double $LBPrate
 * @property double $USDrate
 * @property integer $organizationId
 * @property integer $personResponsible
 */
class Pricesetting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pricesetting}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dateTime, RURrate, EURrate, LBPrate,  organizationId, personResponsible', 'required'), //USDrate,
			array('organizationId, personResponsible', 'numerical', 'integerOnly'=>true),
			array('RURrate, EURrate, LBPrate, USDrate', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dateTime, RURrate, EURrate, LBPrate, USDrate, organizationId, personResponsible', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('general','Identificator'),
			'dateTime' => Yii::t('general','Date'),
			'RURrate' => Yii::t('general','RUR to USD rate'), //'курс рубля к доллару США
			'EURrate' => Yii::t('general','EUR to USD rate'),//'курс евро валюте управленческого учета (доллары)'),
			'LBPrate' => Yii::t('general','LBP to USD rate'),//'курс ливанского лира к валюте управленческого учета (доллары)'),
			'USDrate' => Yii::t('general','USD to USD rate'),//'курс доллара США к валюте управленческого учета (доллары)'),
			'organizationId' => Yii::t('general','Organization'), // 'идентификатор организации'),
			'personResponsible' => Yii::t('general','Responsible for this setting'), //'Ответственный за эту настройку'),
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
		$criteria->compare('dateTime',$this->dateTime,true);
		$criteria->compare('RURrate',$this->RURrate);
		$criteria->compare('EURrate',$this->EURrate);
		$criteria->compare('LBPrate',$this->LBPrate);
		$criteria->compare('USDrate',$this->USDrate);
		// проверка на организацию если не админ
		if(!Yii::app()->user->checkAccess('1')) 
			$criteria->compare('organizationId', Yii::app()->user->organization); 
		else 	
			$criteria->compare('organizationId', $this->organizationId); 
		 // мы сравниваем id текущего пользователя или 0 c userId модели если залогинен менеджер или ниже по статусу
		if(!Yii::app()->user->checkAccess('4')) $criteria->compare('personResponsible', array(Yii::app()->user->id, 0));
		else 
		 	$criteria->compare('personResponsible',$this->personResponsible);
		$criteria->order = 'dateTime DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pricesetting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
