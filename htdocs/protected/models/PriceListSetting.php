<?php

/**
 * This is the model class for table "{{price_list_setting}}".
 *
 * The followings are the available columns in table '{{price_list_setting}}':
 * @property integer $id
 * @property integer $userId
 * @property string $format
 * @property string $daysOfWeek
 * @property string $time
 */
class PriceListSetting extends CActiveRecord
{
	public $_formats = array('csv'=>'csv', 'xls'=>'xls', 'xlsx'=>'xlsx');
	public function tableName()
	{
		return '{{price_list_setting}}';
	} 
	public function rules()
	{
		return array(
			array('userId, format, daysOfWeek, time, email', 'required'),
			array('userId', 'numerical', 'integerOnly'=>true),
			array('format', 'length', 'max'=>4),
			array('daysOfWeek', 'length', 'max'=>255),
			array('email', 'email'),
			array('id, userId, format, daysOfWeek, time, email', 'safe', 'on'=>'search'),
		);
	}
	public function relations()
	{
		return array(
		);
	}
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('general','ID'),
			'userId' => Yii::t('general','User'),
			'format' => Yii::t('general','File Format'),
			'daysOfWeek' => Yii::t('general','Days Of Week'),
			'time' => Yii::t('general','Time'),
			'isActive' => Yii::t('general','is Active'),
		);
	}
 
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('format',$this->format,true);
		$criteria->compare('daysOfWeek',$this->daysOfWeek,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('isActive',$this->time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}