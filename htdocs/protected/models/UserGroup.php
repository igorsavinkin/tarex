<?php
/**
 * This is the model class for table "{{userGroup}}".
 *
 * The followings are the available columns in table '{{userGroup}}':
 * @property integer $id
 * @property string $name
 * @property integer $organizationId
 */
class UserGroup extends CActiveRecord
{ 
	public function tableName()
	{
		return '{{userGroup}}';
	} 
	public function rules()
	{ 
		return array(
			array('name, organizationId', 'required'),
			array('organizationId', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255), 
			array('id, name, organizationId', 'safe', 'on'=>'search'),
		);
	}  
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('general','ID'),
			'name' => Yii::t('general','Name'),
			'organizationId' => Yii::t('general','Organization'),
		);
	} 
	public function search()
	{ 
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		if (Yii::app()->user->role != User::ROLE_ADMIN)        
			$criteria->compare('organizationId', Yii::app()->user->organization);
		else  
			$criteria->compare('organizationId',$this->organizationId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}   
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
