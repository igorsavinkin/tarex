<?php
/**
 * This is the model class for table "{{user_group_discount}}".
 *
 * The followings are the available columns in table '{{user_group_discount}}':
 * @property integer $id
 * @property integer $userId
 * @property integer $discountGroupId
 * @property double $value
 */
class UserGroupDiscount extends CActiveRecord
{
	public function tableName()
	{
		return '{{user_group_discount}}';
	}
	
	/*public function primaryKey(){
       return array('userId', 'discountGroupId');
    }*/
	
	public function rules()
	{
		return array(
			array('userId, discountGroupId, value', 'required'),
			array('userId, discountGroupId', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical'),
			array('id, userId, discountGroupId, value', 'safe', 'on'=>'search'),
		//	array('userId', 'uniqueCompositePK', 'uniquePKFields'=>'discountGroupId'),
		);
	}
	/*public function uniqueCompositePK($attribute, $params)
	{
		//$params['uniquePKFields'];
		// если уже есть такой элемент в базе, тогда мы выдаём ошибку
		if ( UserGroupDiscount::model()->findByAttributes(array('userId'=>$this->$attribute,'discountGroupId'=>$this->$params['uniquePKFields'])) ) 
		{
		    $this->addError($attribute, 'Такое составной ключ уже есть в системе!');
		};
	}*/
	
	public function relations()
	{
		return array(
		//	'user'=>array(BELONGS_TO, 'User', 'userId'),
		 	'discountGroup'=>array(self::BELONGS_TO, 'DiscountGroup', 'discountGroupId'),
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
			'discountGroupId' => Yii::t('general','Discount Group'),
			'value' => Yii::t('general','Discount') . ' %',
		);
	}
 
	public function search($userId=null)
	{	 
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		if($userId) 
			$criteria->compare('userId',$userId);
		else	
			$criteria->compare('userId',$this->userId);
		$criteria->compare('discountGroupId',$this->discountGroupId);
		$criteria->compare('value',$this->value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function discountField($id, $value)
	{
		$field = CHtml::textField('discount[' . $id .']', $value , array('size'=>4, "title"=>Yii::t('general', 'Press \'Save\' to save new value') ) );	
// пока кнопку не ставим, так как есть общая кнопка в форме		
		$button = CHtml::ajaxSubmitButton(Yii::t('general', Yii::t('general','Save')) ,  array(/*'eventContent/updateEventcontent', 'name' => 'saveDiscount'*/ ), array('success'  => 'js:  function() { $.fn.yiiGridView.update("user-group-discount-grid"); }'), array('style'=>'float:right;')); 
		
		return $field; //. $button;  
	}
}