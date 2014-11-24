<?php

/**
 * This is the model class for table "{{price_list_setting}}".
 *
 * The followings are the available columns in table '{{price_list_setting}}':
 * @property integer $id
 * @property integer $userId
 * @property string $format
 * @property string $daysOfWeek
 * @property string $time
 */
class PriceListSetting extends CActiveRecord
{
	public $_formats = array('csv'=>'csv', 'xls'=>'xls', 'xlsx'=>'xlsx');
	public function tableName()
	{
		return '{{price_list_setting}}';
	} 
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, format, daysOfWeek, time, email', 'required'),
			array('userId', 'numerical', 'integerOnly'=>true),
			array('format', 'length', 'max'=>4),
			array('daysOfWeek', 'length', 'max'=>255),
			array('email', 'email'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userId, format, daysOfWeek, time, email', 'safe', 'on'=>'search'),
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
			'userId' => Yii::t('general','User'),
			'format' => Yii::t('general','File Format'),
			'daysOfWeek' => Yii::t('general','Days Of Week'),
			'time' => Yii::t('general','Time'),
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('format',$this->format,true);
		$criteria->compare('daysOfWeek',$this->daysOfWeek,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PriceListSetting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
