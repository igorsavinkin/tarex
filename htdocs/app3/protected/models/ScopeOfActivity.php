<?php
/**
 * This is the model class for table "{{scopeOfActivity}}".
 *
 * The followings are the available columns in table '{{scopeOfActivity}}':
 * @property integer $id
 * @property string $name
 */
class ScopeOfActivity extends CActiveRecord
{ 
	public function tableName()
	{
		return '{{scopeOfActivity}}';
	} 
	public function rules()
	{ 
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>63), 
			array('id, name', 'safe', 'on'=>'search'),
		);
	}
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('general','Id'),
			'name' => Yii::t('general','Name'),
		);
	}
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getTrName()
		{ return Yii::t('general', $this->name); /*$this->name;*/ } //Yii::t('general', $this->name); }
}