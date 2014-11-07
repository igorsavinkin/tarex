<?php

/**
 * This is the model class for table "{{max_discount}}".
 *
 * The followings are the available columns in table '{{max_discount}}':
 * @property integer $id
 * @property string $prefix
 * @property double $value
 * @property string $manufacturer
 */
class MaxDiscount extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{max_discount}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prefix, value, manufacturer', 'required'),
			array('value', 'numerical'),
			array('prefix', 'length', 'max'=>2),
			array('manufacturer', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, prefix, value, manufacturer', 'safe', 'on'=>'search'),
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
			'prefix' => Yii::t('general','Prefix'),
			'value' => Yii::t('general','Value'),
			'manufacturer' => Yii::t('general','Manufacturer'),
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
		$criteria->compare('prefix',$this->prefix,true);
		$criteria->compare('value',$this->value);
		$criteria->compare('manufacturer',$this->manufacturer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MaxDiscount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
