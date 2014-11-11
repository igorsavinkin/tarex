<?php
/**
 * This is the model class for table "{{officeVehicle}}".
 *
 * The followings are the available columns in table '{{officeVehicle}}':
 * @property integer $id
 * @property string $first_registration_date
 * @property string $make
 * @property string $model
 * @property string $driver
 * @property string $vin
 * @property string $milage
 * @property string $last_maintenance_date
 * @property string $milage_since_last_maintenance
 */
class OfficeVehicle extends CActiveRecord
{
 
	public function tableName()
	{
		return '{{officeVehicle}}';
	}
 
	public function rules()
	{
	 	return array(
			//array('first_registration_date, make, model, vin, milage, last_maintenance_date, milage_since_last_maintenance', 'required'),
			array('make, model, vin, driver', 'length', 'max'=>255),
			array('milage, milage_since_last_maintenance', 'length', 'max'=>12),
			array('id, first_registration_date, make, model, vin, milage, last_maintenance_date, milage_since_last_maintenance, driver', 'safe', 'on'=>'search, insert'),
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
			'first_registration_date' => Yii::t('general','First Registration Date'),
			'make' => Yii::t('general','Make'),
			'model' => Yii::t('general','Model'),
			'driver' => Yii::t('general','Driver'),
			'vin' => Yii::t('general','Vin'),
			'milage' => Yii::t('general','Milage (km)'),
			'last_maintenance_date' => Yii::t('general','Last Maintenance Date'),
			'milage_since_last_maintenance' => Yii::t('general','Milage Since Last Maintenance (km)'),
		);
	}
 
	public function search()
	{ 
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('first_registration_date',$this->first_registration_date,true);
		$criteria->compare('make',$this->make,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('driver',$this->driver,true);
		$criteria->compare('vin',$this->vin,true);
		$criteria->compare('milage',$this->milage,true);
		$criteria->compare('last_maintenance_date',$this->last_maintenance_date,true);
		$criteria->compare('milage_since_last_maintenance',$this->milage_since_last_maintenance,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}