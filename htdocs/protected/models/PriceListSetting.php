<?php 
class PriceListSetting extends CActiveRecord
{
	public $_formats = array('csv'=>'csv', 'xls'=>'xls'  /*, 'xlsx'=>'xlsx'*/);
 	
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
			array('daysOfWeek', 'length', 'max'=>255),
			array('carmakes', 'length', 'max'=>1000),
			array('email', 'email'),
			//array('lastSentDate',  'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat'=>'Y-m-d'),
		 	array('time',  'match', 'pattern' => '/^(\d{1,2}:)?\d{2}:\d{2}$/', 'message' => '{attribute}: does not match time format!' ),
			array('id, userId, format, daysOfWeek, time, email, carmakes, lastSentDate', 'safe', 'on'=>'search'),
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
			'carmakes' => Yii::t('general','Car makes'),
			'lastSentDate' => Yii::t('general','Last Sent Date'),
		);
	}
 
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('format',$this->format,true);
		$criteria->compare('daysOfWeek',$this->daysOfWeek, true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('carmakes',$this->carmakes, true);
		$criteria->compare('lastSentDate',$this->lastSentDate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}