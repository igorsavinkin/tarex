<?php 
class DiscountGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{discountGroup}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('isActive', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical'),
			array('name', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, articles, value, isActive', 'safe', 'on'=>'search'),
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
			'articles' => Yii::t('general','Articles'),
			'value' => Yii::t('general', 'Discount value, %'),
			'isActive' => Yii::t('general','Is Active'),
		);
	}
  
	public function search()
	{ 

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
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
}