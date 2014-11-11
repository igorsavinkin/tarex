<?php

/**
 * This is the model class for table "{{asortment_remains}}".
 *
 * The followings are the available columns in table '{{asortment_remains}}':
 * @property integer $id
 * @property string $date
 * @property integer $eventid
 * @property integer $assortmentid
 * @property integer $amount
 * @property double $sum
 * @property integer $warehouseid
 * @property integer $contractorid
 * @property integer $authorid
 */
class AsortmentRemains extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{asortmentremains}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('eventid, assortmentid, amount, sum, warehouseid, contractorid, authorid', 'required'),
			array('eventid', 'required'),
			array('eventid, assortmentid, amount, warehouseid, contractorid, authorid', 'numerical', 'integerOnly'=>true),
			array('sum', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, eventid, assortmentid, amount, sum, warehouseid, contractorid, authorid', 'safe', 'on'=>'search'),
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
			'date' => Yii::t('general','Date'),
			'eventid' => Yii::t('general','Eventid'),
			'assortmentid' => Yii::t('general','Assortmentid'),
			'amount' => Yii::t('general','Amount'),
			'sum' => Yii::t('general','Sum'),
			'warehouseid' => Yii::t('general','Warehouseid'),
			'contractorid' => Yii::t('general','Contractorid'),
			'authorid' => Yii::t('general','Authorid'),
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('eventid',$this->eventid);
		$criteria->compare('assortmentid',$this->assortmentid);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('sum',$this->sum);
		$criteria->compare('warehouseid',$this->warehouseid);
		$criteria->compare('contractorid',$this->contractorid);
		$criteria->compare('authorid',$this->authorid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsortmentRemains the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
