<?php

/**
 * This is the model class for table "{{sparePart}}".
 *
 * The followings are the available columns in table '{{sparePart}}':
 * @property integer $id
 * @property string $changeDate
 * @property string $OEM
 * @property string $article
 * @property integer $assortmentId
 * @property string $analogs
 */
class SparePart extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sparePart}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('changeDate, OEM', 'required'),
			array('assortmentId', 'numerical', 'integerOnly'=>true),
			array('OEM, article', 'length', 'max'=>255),
			array('analogs', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, changeDate, OEM, article, assortmentId, analogs', 'safe', 'on'=>'search'),
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
			'changeDate' => Yii::t('general','Change Date'),
			'OEM' => Yii::t('general','Oem'),
			'article' => Yii::t('general','Article'),
			'assortmentId' => Yii::t('general','Assortment'),
			'analogs' => Yii::t('general','Analogs'),
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
		$criteria->compare('changeDate',$this->changeDate,true);
		$criteria->compare('OEM',$this->OEM,true);
		$criteria->compare('article',$this->article,true);
		$criteria->compare('assortmentId',$this->assortmentId);
		$criteria->compare('analogs',$this->analogs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SparePart the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
