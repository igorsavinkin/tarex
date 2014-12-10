<?php 
class DiscountGroup extends CActiveRecord
{ 
	public function tableName()
	{
		return '{{discountGroup}}';
	} 
	public function rules()
	{ 
		return array(
		//	array('name', 'required'),
			array('isActive', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical'),
			array('name', 'length', 'max'=>32), 
			array('prefix', 'length', 'max'=>4), 
			array('id, name, prefix, articles, value, isActive', 'safe', 'on'=>'search'),
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
			'prefix' => Yii::t('general','Prefix'),
			'articles' => Yii::t('general','Articles'),
			'value' => Yii::t('general','Discount value, %'),
			'isActive' => Yii::t('general','is Active'),
		);
	}
  
	public function search()
	{ 

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('prefix',$this->prefix);
		$criteria->compare('articles',$this->articles,true);
		$criteria->compare('value',$this->value);
		$criteria->compare('isActive',$this->isActive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function getDiscountGroupName($article=null)
	{
		if (!$article) return 'no article';
		$criteria=new CDbCriteria;
		$criteria->compare('articles', $article, true); // нестрогое сравнение в поле Артикулы
		$discountGroup = DiscountGroup::model()->find($criteria);  
		return isset($discountGroup) ? $discountGroup->name : '';
	}	
	public function getDiscountGroupPrefix($article=null)
	{
		if (!$article) return 'no article';
		$criteria=new CDbCriteria;
		$criteria->compare('articles', $article, true); // нестрогое сравнение в поле Артикулы
		$discountGroup = DiscountGroup::model()->find($criteria);  
		return isset($discountGroup) ? $discountGroup->prefix : '';
	}	
	public static function getDiscountGroup($article=null)
	{
		if (!$article) return 0;
		$criteria=new CDbCriteria;
		$criteria->compare('articles', $article, true); // нестрогое сравнение в поле Артикулы
		$discountGroup = DiscountGroup::model()->find($criteria);   
		return isset($discountGroup) ? $discountGroup->id : 0;
	}	
}