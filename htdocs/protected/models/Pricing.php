<?php

/**
 * This is the model class for table "{{pricing}}".
 *
 * The followings are the available columns in table '{{pricing}}':
 * @property integer $id
 * @property string $Date
 * @property float $Value
 * @property integer $isActive
 * @property string $Comment
 * @property string $SubgroupFilter
 * @property string $TitleFilter
 * @property string $ModelFilter
 * @property string $MakeFilter
 * @property string $ArticleFilter
 * @property string $OemFilter
 * @property string $ManufacturerFilter
 * @property string $CountryFilter
 * @property string $FreeAssortmentFilter
 * @property string $UsernameFilter
 * @property string $GroupFilter
 */
class Pricing extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pricing}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Date, Comment, Value', 'required'),
			array('Value, isActive', 'numerical'),
			
			array('Comment', 'length', 'max'=>255),
			array('SubgroupFilter, TitleFilter, ModelFilter, MakeFilter, ArticleFilter, OemFilter, ManufacturerFilter, CountryFilter, FreeAssortmentFilter, UsernameFilter, GroupFilter', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Date, Comment, SubgroupFilter, TitleFilter, ModelFilter, MakeFilter, ArticleFilter, OemFilter, ManufacturerFilter, CountryFilter, FreeAssortmentFilter, UsernameFilter, GroupFilter, Value, isActive', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('general','ID'),
			'Date' => Yii::t('general','Date'),			
			'Value' => Yii::t('general','Discount value, %'),
			'isActive' =>Yii::t('general','is Active'),
			'Comment' => Yii::t('general','Comment'),
			'SubgroupFilter' => Yii::t('general','Subgroup Filter'),
			'TitleFilter' => Yii::t('general','Title Filter'),
			'ModelFilter' => Yii::t('general','Model Filter'),
			'MakeFilter' => Yii::t('general','Make Filter'),
			'ArticleFilter' => Yii::t('general','Article Filter'),
			'OemFilter' => Yii::t('general','OEM Filter'),
			'ManufacturerFilter' => Yii::t('general','Manufacturer Filter'),
			'CountryFilter' => Yii::t('general','Country Filter'),
			'FreeAssortmentFilter' => Yii::t('general','Free Assortment Filter'),
			'UsernameFilter' => Yii::t('general','Username Filter'),
			'GroupFilter' => Yii::t('general','Group Filter'),
		);
	} 

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('Date', $this->Date,true);
		$criteria->compare('Value', $this->Value); 
		$criteria->compare('isActive', $this->isActive);
		$criteria->compare('Comment',$this->Comment,true);
		$criteria->compare('SubgroupFilter',$this->SubgroupFilter,true);
		$criteria->compare('TitleFilter',$this->TitleFilter,true);
		$criteria->compare('ModelFilter',$this->ModelFilter,true);
		$criteria->compare('MakeFilter',$this->MakeFilter,true);
		$criteria->compare('ArticleFilter',$this->ArticleFilter,true);
		$criteria->compare('OemFilter',$this->OemFilter,true);
		$criteria->compare('ManufacturerFilter',$this->ManufacturerFilter,true);
		$criteria->compare('CountryFilter',$this->CountryFilter,true);
		$criteria->compare('FreeAssortmentFilter',$this->FreeAssortmentFilter,true);
		$criteria->compare('UsernameFilter',$this->UsernameFilter,true);
		$criteria->compare('GroupFilter',$this->GroupFilter,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pricing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
