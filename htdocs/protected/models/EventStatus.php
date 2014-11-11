<?php

/**
 * This is the model class for table "{{eventStatus}}".
 *
 * The followings are the available columns in table '{{eventStatus}}':
 * @property integer $id
 * @property string $name
 * @property integer $Order1
 */
class EventStatus extends CActiveRecord
{
 
	public function tableName()
	{
		return '{{eventStatus}}';
	}
 
	public function rules()
	{ 
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>200),
			array('Order1', 'numerical', 'integerOnly'=>true),
		
			array('id, name, Order1', 'safe', 'on'=>'search'),
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
			'name' => Yii::t('general','Name'),
			'Order1' => Yii::t('general',"Status' order"),
		);
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('Order1',$this->Order1 );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}