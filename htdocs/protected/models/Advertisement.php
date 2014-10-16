<?php
/**
 * This is the model class for table "{{advertisement}}".
 *
 * The followings are the available columns in table '{{advertisement}}':
 * @property integer $id
 * @property integer $blockId
 * @property string $content
 * @property integer $isActive
 */
class Advertisement extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{advertisement}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('blockId', 'required'),
			array('isActive', 'numerical', 'integerOnly'=>true),
			array('content', 'length','max' =>65500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, blockId, content, isActive', 'safe', 'on'=>'search'),
		);
	}
	public function attributeLabels() 
	{
		return array(
			'id' => Yii::t('general','ID'),
			'blockId' => Yii::t('general','Ad block name'),
			'content' => Yii::t('general','Content'),
			'isActive' => Yii::t('general','is Active'),
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
		$criteria->compare('blockId',$this->blockId);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('isActive',$this->isActive);
		$criteria->order='id ASC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,  'pagination'=>array('pageSize'=>20),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Advertisement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
