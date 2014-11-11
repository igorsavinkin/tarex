<?php
class Eventtype extends CActiveRecord
{
	public $basesArray = array();
 
	public function tableName()
	{
		return '{{eventtype}}';
	} 
	 
	public function rules()
	{	
		return array(
			array('name', 'required'),
			array('name, Reference', 'length', 'max'=>200),
			array('subType', 'length', 'max'=>63),
			array('id, name, subType, Reference, IsBasisFor, basesArray', 'safe', 'on'=>'search'),
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
			'subType' => Yii::t('general','Sub type'),
			'Reference' => Yii::t('general','Reference'),
			'IsBasisFor' => Yii::t('general','Is Basis For'),
		);
	}
	 
	public function search()
	{
	 	$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name, true);
		$criteria->compare('subType',$this->subType, true);
		$criteria->compare('Reference',$this->Reference, true);
		$criteria->compare('IsBasisFor', $this->IsBasisFor, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getBases()
	{ 
		foreach( explode(',' , $this->IsBasisFor)  as  $number)
			$result[] = Yii::t('general', self::model()->findByPk($number)->name) ;
		return implode(', ' , $result);
	}
	public function getEventtypesLocale()
	{
		// формируем переведённые типы событий 
		// (для выпадающего списка: id=>nameTranslated)
		foreach(Eventtype::model()->findAll() as $type)
			$types[$type->id] = Yii::t('general', $type->name);
		return  $types;  
	}
}