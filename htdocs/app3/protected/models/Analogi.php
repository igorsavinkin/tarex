<?php

/**
 * This is the model class for table "{{analogi}}".
 *
 * The followings are the available columns in table '{{analogi}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $oem
 * @property string $fullname
 * @property string $brand
 * @property integer $reliability
 */
class Analogi extends CActiveRecord
{
	public $currentPrice, $availability;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{analogi}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name, oem, fullname, brand, reliability', 'required'),
			array('reliability', 'numerical', 'integerOnly'=>true),
			array('code, oem', 'length', 'max'=>100),
			array('name, fullname, brand', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, oem, fullname, brand, reliability', 'safe', 'on'=>'search'),
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
			'code' => Yii::t('general','Code'),
			'name' => Yii::t('general','Name'),
			'oem' => Yii::t('general','Oem'),
			'fullname' => Yii::t('general','Fullname'),
			'brand' => Yii::t('general','Brand'),
			'reliability' => Yii::t('general','Reliability'),
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('oem',$this->oem,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('reliability',$this->reliability);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Analogi the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
