<?php
/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property string $name
 * @property string $image
 */
class Category extends CActiveRecord
{ 
	public function tableName()
	{
		return '{{category}}';
	}
 
	public function rules()
	{ 
		return array(
			array('name', 'required'),
			array('name, image', 'length', 'max'=>255), 
			array('id, name, image', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('general','ID'),
			'name' => Yii::t('general','Name'),
			'image' => Yii::t('general','Image Url path'),
			'isActive' => Yii::t('general','is Active'),
		);
	}
 
	public function search()
	{
	    $criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('isActive',$this->isActive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getCategoryLocale()
	{
		// формируем переведённые типы событий 
		// (для выпадающего списка: id=>nameTranslated)
		foreach(Category::model()->findAll() as $category)
			$cat[$category->id] = Yii::t('general', $category->name);
		return  $cat;  
	}
}