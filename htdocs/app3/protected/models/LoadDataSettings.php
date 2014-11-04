<?php

/**
 * This is the model class for table "{{LoadDataSettings}}".
 *
 * The followings are the available columns in table '{{LoadDataSettings}}':
 * @property integer $id
 * @property string $TemplateName
 * @property string $ColumnSearch
 * @property string $ColumnNumber
 * @property integer $ListNumber
 * @property string $AmountColumnNumber
 */
class LoadDataSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{LoadDataSettings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('TemplateName, ColumnNumber, ListNumber, AmountColumnNumber, PriceColumnNumber', 'required'),
			array('ListNumber', 'numerical', 'integerOnly'=>true),
			array('TemplateName, ColumnSearch', 'length', 'max'=>255),
			array('ColumnNumber, AmountColumnNumber', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, TemplateName, ColumnSearch, ColumnNumber, ListNumber, AmountColumnNumber, PriceColumnNumber', 'safe', 'on'=>'search'),
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
			'TemplateName' => Yii::t('general','Template Name'),
			'ColumnSearch' => Yii::t('general','Column Search'),
			'ColumnNumber' => Yii::t('general','Column index (a-z) with Article'),//Yii::t('general','Column Number'),
			'ListNumber' => Yii::t('general','List number with an Order'), // Yii::t('general','List Number'),
			'AmountColumnNumber' => Yii::t('general','Column index (a-z) with Amount'), //Yii::t('general','Amount Column Number'),
			'PriceColumnNumber' => Yii::t('general','Column index (a-z) with Price'), //Yii::t('general','Price Column Number'),
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
		$criteria->compare('TemplateName',$this->TemplateName,true);
		$criteria->compare('ColumnSearch',$this->ColumnSearch,true);
		$criteria->compare('ColumnNumber',$this->ColumnNumber,true);
		$criteria->compare('ListNumber', $this->ListNumber);
		$criteria->compare('AmountColumnNumber', $this->AmountColumnNumber,true);
		$criteria->compare('PriceColumnNumber', $this->PriceColumnNumber,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoadDataSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
