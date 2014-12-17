<?php 
class PriceListSetting extends CActiveRecord
{  
	public function tableName()
	{
		return '{{price_list_setting}}';
	} 
	public function rules()
	{
		return array(
			array('userId, format, email', 'required'),
			array('userId', 'numerical', 'integerOnly'=>true),
			array('format', 'length', 'max'=>4),
			array('daysOfWeek, columns, name', 'length', 'max'=>255),
			array('carmakes', 'length', 'max'=>1000),
			array('email', 'email'),
			//array('lastSentDate',  'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat'=>'Y-m-d'),
		 	array('time, time2, time3',  'match', 'pattern' => '/^(\d{1,2}:)?\d{2}:\d{2}$/', 'message' => '{attribute}: '.  Yii::t('general','does not match time format!') ),
			array('id, userId, format, daysOfWeek, time, email, carmakes, lastSentDate, lastSentDate2, lastSentDate3, columns, name, time2, time3', 'safe', 'on'=>'search'),
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
			'name' => Yii::t('general','Name'),
			'format' => Yii::t('general','File Format'),
			'daysOfWeek' => Yii::t('general','Days Of Week'),
			'time' => Yii::t('general','Time'),
			'time2' => Yii::t('general','Time') . ' 2',
			'time3' => Yii::t('general','Time') . ' 3',
			'carmakes' => Yii::t('general','Car makes'), //'Car makes'=>'Марки машин',
			'lastSentDate' => Yii::t('general','Last Sent Date'),
			'lastSentDate2' => Yii::t('general','Last Sent Date') . ' 2',
			'lastSentDate3' => Yii::t('general','Last Sent Date') . ' 3',
			'columns' => Yii::t('general','Price columns'),
		);
	}
 
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name, true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('format',$this->format,true);
		$criteria->compare('daysOfWeek',$this->daysOfWeek, true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('time2',$this->time2,true);
		$criteria->compare('time3',$this->time3,true);
		$criteria->compare('carmakes',$this->carmakes, true);
		$criteria->compare('lastSentDate',$this->lastSentDate);
		$criteria->compare('lastSentDate2',$this->lastSentDate2);
		$criteria->compare('lastSentDate3',$this->lastSentDate3);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}