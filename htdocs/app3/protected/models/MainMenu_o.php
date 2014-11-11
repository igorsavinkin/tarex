<?php

/**
 * This is the model class for table "{{main_menu}}".
 *
 * The followings are the available columns in table '{{main_menu}}':
 * @property integer $id
 * @property string $Subsystem
 * @property string $Img
 * @property string $Reference
 * @property string $Link
 * @property string $RoleId
 */
class MainMenu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mainmenu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Subsystem, Img, Reference, Link, RoleId', 'required'),
			array('Subsystem, Img, Reference, Link, RoleId', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Subsystem, Img, Reference, Link, RoleId', 'safe', 'on'=>'search'),
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
			'Subsystem' => Yii::t('general','Subsystem'),
			'Img' => Yii::t('general','Img'),
			'Reference' => Yii::t('general','Reference'),
			'Link' => Yii::t('general','Link'),
			'RoleId' => Yii::t('general','User'),
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
		$criteria->compare('Subsystem',$this->Subsystem,true);
		$criteria->compare('Img',$this->Img,true);
		$criteria->compare('Reference',$this->Reference,true);
		$criteria->compare('Link',$this->Link,true);
		$criteria->compare('RoleId', Yii::app()->user->role /*$this->RoleId*/,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MainMenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
