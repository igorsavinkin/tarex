<?php

/**
 * This is the model class for table "{{eventcontent}}".
 *
 * The followings are the available columns in table '{{eventcontent}}':
 * @property integer $id
 * @property integer $eventId
 * @property integer $assortmentId
 * @property string   $assortmentTitle
 * @property integer $assortmentAmount
 * @property integer $discount
 * @property integer $price
 * @property integer $cost
 * @property integer $cost_w_discount
 */
class EventContent extends CActiveRecord
{
	public $sumTotal; 
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{eventcontent}}';
	}
	public static function getTableN()
	{
		return EventContent::model()->tableName();
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eventId, assortmentId, assortmentTitle, assortmentAmount, price, cost, cost_w_discount, RecommendedPrice', 'required', 'except'=>'simple'),
			array('eventId, assortmentId, assortmentAmount,Barcode', 'numerical', 'integerOnly'=>true),
			//array('Barcode', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, eventId, Barcode, assortmentId, assortmentTitle, assortmentAmount, discount, price, cost, cost_w_discount, RecommendedPrice ', 'safe', 'on'=>'search'),
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
			'event'=>array(self::BELONGS_TO, 'Events', 'eventId'),
			'assortment'=>array(self::BELONGS_TO, 'Assortment', 'assortmentId'),
		/*	'sum' => array(self::STAT, 'Events', 'eventId',
                        'select' =>'SUM(cost)',
                        'where' => ' id = eventId ',
                ),*/
			//'assortment' => array(self::BELONGS_TO, 'Assortment', 'assortmentId'),
			//'assortment' => array(self::BELONGS_TO, 'Assortment', ' ' /* 'assortmentTitle' */,  array(  'title'=>'assortmentTitle' ), -- it doesn't work
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('general','ID'),
			'eventId' => Yii::t('general','Event'),
			'assortmentId' => Yii::t('general','Assortment'),
			'assortmentTitle' => Yii::t('general','Title'),
			'assortmentAmount' => Yii::t('general','Amount'),
			'discount' => Yii::t('general','Discount'),
			'price' => Yii::t('general','Price'),
			'cost' => Yii::t('general','Cost'),
			'cost_w_discount' => Yii::t('general','Cost with discount'),
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
		$criteria->compare('eventId',$this->eventId);
		$criteria->compare('assortmentId',$this->assortmentId);
		$criteria->compare('assortmentTitle',$this->assortmentTitle, true);
		$criteria->compare('assortmentAmount',$this->assortmentAmount);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('price',$this->price);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('cost_w_discount',$this->cost_w_discount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function getTotalSumByEvent($eventId)
	{
	   if ($eventId)
		  return round(Yii::app()->db->createCommand('SELECT sum(cost) FROM ' .  self::getTableN() /* self::tableName() */ . ' WHERE `eventId` = ' . $eventId)->queryScalar(), 2);
	   else 
		  return 0;
	}
	public function getAmountDropDown($eventId) 
	{
		$data = array(); for($i=1; $i <= 100; $i++ ) { $data[$i] = $i; }
		$dd = CHtml::dropDownList('EventContent[assortmentAmount]', $this->assortmentAmount, $data , array('id'=>'item-' . $eventId)/*, 
			array( 
				'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('/eventContent/updateEventContent'),		
				)
			)*/ 
		);    
		return $dd ; //. $as;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getPriceCssClass($contractorId=null) 
	{
		if ($this->price == $this->assortment->getPriceOpt($contractorId)) return '';
		if ($this->price > $this->assortment->getPriceOpt($contractorId)) return 'blue';
		if ($this->price < $this->assortment->getPriceOpt($contractorId)) return 'green';
	} 
	public function priceCssClass($contractorId=null) 
	{
		if ($this->price < $this->assortment->getPriceOptMax()) return 'redbgcolor';
		//if ($this->price == $this->assortment->getPriceOpt($contractorId)) return '';
		//if ($this->price > $this->assortment->getPriceOpt($contractorId)) return 'green';
		
	} 
}
