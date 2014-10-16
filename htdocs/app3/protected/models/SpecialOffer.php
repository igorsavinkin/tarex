<?php
/**
 * This is the model class for table "{{specialOffer}}".
 *
 * The followings are the available columns in table '{{specialOffer}}':
 * @property integer $id
 * @property integer $assortmentId
 * @property double $price
 * @property string $description
 * @property string $make
 * @property string $photo
 */
class SpecialOffer extends CActiveRecord
{
	public function tableName()
	{
		return '{{specialOffer}}';
	}
	public function rules()
	{		
		return array(
			array('assortmentId, price, description', 'required'),
			array('assortmentId', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('description', 'length', 'max'=>255, 'on'=>'insert, update'),
			array('make', 'length', 'max'=>63, 'on'=>'insert, update'),
			array('photo', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true,  'safe' => true, 'maxSize' => (1024 * 400), /* 300 Kb*/ 'on'=>'insert, update'), // this will allow empty field when page is update (remember here i create scenario update)

			array('id, assortmentId, price, description, make, photo', 'safe', 'on'=>'search'),
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
			'assortmentId' => Yii::t('general','Assortment'),
			'price' => Yii::t('general','Price'),
			'description' => Yii::t('general','Description'),
			'photo' => Yii::t('general','Photo'),
			'make' => Yii::t('general','Make'),
		);
	}
	public function scopes()
    {
        return array( 
            'first5'=>array(
                'order'=>'id ASC',
                'limit'=>5,
            ), 
        );
    }
	public function matchMakes($makes=null) //'AUDI,FORD'
	{
		if (!$makes) return $this; // если пустой, тогда не меняем, выводим все запчасти
		$criteria = new CDbCriteria;  
		$criteria->order = 'RAND()'; // сортируем случайным образом
		$criteria->limit = 5; 
		$criteria->compare('make', explode(',',$makes), true, 'OR');	// работает с массивом 
		$this->getDbCriteria()->mergeWith($criteria);
		return $this;
	}
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('assortmentId',$this->assortmentId);
		$criteria->compare('price',$this->price);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('make',$this->make,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->order='id ASC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}