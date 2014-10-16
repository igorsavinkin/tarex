<?php

/**
 * This is the model class for table "{{bizprocess}}".
 *
 * The followings are the available columns in table '{{bizprocess}}':
 * @property integer $id
 * @property string $name
 * @property integer $condition1
 * @property integer $condition2
 * @property integer $condition3
 * @property integer $deleteSelf
 * @property integer $sendLetter
 * @property integer $createContractor
 * @property integer $changeStatus
 * @property integer $moveToBizProcess
 * @property integer $generateReport
 */
class Bizprocess extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bizprocess}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('condition1, condition2, condition3, deleteSelf, sendLetter, createContractor, changeStatus, moveToBizProcess, generateReport', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, condition1, condition2, condition3, deleteSelf, sendLetter, createContractor, changeStatus, moveToBizProcess, generateReport', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('general','идентификатор'),
			'name' => Yii::t('general','имя бизнес процесса'),
			'condition1' => Yii::t('general','условие 1'),
			'condition2' => Yii::t('general','условие 2'),
			'condition3' => Yii::t('general','условие 3'),
			'deleteSelf' => Yii::t('general','удалить самого себя'),
			'sendLetter' => Yii::t('general','послать письмо'),
			'createContractor' => Yii::t('general','создать контрагнета'),
			'changeStatus' => Yii::t('general','изменить статус'),
			'moveToBizProcess' => Yii::t('general','перейти к бизнес процессу'),
			'generateReport' => Yii::t('general','создать отчёт'),
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
		$criteria->compare('condition1',$this->condition1);
		$criteria->compare('condition2',$this->condition2);
		$criteria->compare('condition3',$this->condition3);
		$criteria->compare('deleteSelf',$this->deleteSelf);
		$criteria->compare('sendLetter',$this->sendLetter);
		$criteria->compare('createContractor',$this->createContractor);
		$criteria->compare('changeStatus',$this->changeStatus);
		$criteria->compare('moveToBizProcess',$this->moveToBizProcess);
		$criteria->compare('generateReport',$this->generateReport);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bizprocess the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
