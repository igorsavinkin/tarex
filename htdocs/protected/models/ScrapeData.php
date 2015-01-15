<?php
/**
 * This is the model class for table "{{yigor}}".
 *
 * The followings are the available columns in table '{{yigor}}':
 * @property integer $id
 * @property string $marker
 * @property string $created
 * @property string $make
 * @property string $model
 * @property string $seria
 * @property string $engine
 * @property integer $year
 * @property string $owner
 * @property string $phone
 * @property integer $isChecked
 * @property integer $isPaid
 * @property string $link
 */
class ScrapeData extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{yigor}}';
	}
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('marker, created, make, model, seria, engine, year, owner, phone, isChecked, isPaid, link', 'required'),
			array('year, isChecked, isPaid', 'numerical', 'integerOnly'=>true),
			array('marker, make, model, seria, engine, phone', 'length', 'max'=>63),
			array('owner, link', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, marker, created, make, model, seria, engine, year, owner, phone, isChecked, isPaid, link', 'safe', 'on'=>'search'),
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
			'marker' => Yii::t('general','Marker'),
			'created' => Yii::t('general','Created'),
			'make' => Yii::t('general','Make'),
			'model' => Yii::t('general','Model'),
			'seria' => Yii::t('general','Seria'),
			'engine' => Yii::t('general','Engine'),
			'year' => Yii::t('general','Year'),
			'owner' => Yii::t('general','Owner'),
			'phone' => Yii::t('general','Phone'),
			'isChecked' => Yii::t('general','Is Checked'),
			'isPaid' => Yii::t('general','Is Paid'),
			'link' => Yii::t('general','Link'),
		);
	}
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('marker',$this->marker,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('make',$this->make,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('seria',$this->seria,true);
		$criteria->compare('engine',$this->engine,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('isChecked',$this->isChecked);
		$criteria->compare('isPaid',$this->isPaid);
		$criteria->compare('link',$this->link,true);
		$criteria->order='id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
