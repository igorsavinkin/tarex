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
			array('eventId, assortmentId, assortmentTitle, assortmentAmount, price, cost,  RecommendedPrice', 'required', 'except'=>'simple'),
			array('price, cost, basePrice, RecommendedPrice, discount', 'numerical'),
			array('eventId, assortmentId, assortmentAmount', 'numerical', 'integerOnly'=>true),
			 array('assortmentArticle', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, eventId, assortmentId, assortmentTitle, assortmentAmount, discount, price, cost, RecommendedPrice, assortmentArticle, basePrice', 'safe', 'on'=>'search'),
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
			'assortmentArticle' => Yii::t('general','Article'),
			'discount' => Yii::t('general','Discount'),
			'price' => Yii::t('general','Price'),
			'basePrice' => Yii::t('general','Base Price'),
			'cost' => Yii::t('general','Cost'), 
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
		$criteria->compare('assortmentArticle',$this->assortmentArticle);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('price',$this->price);
		$criteria->compare('cost',$this->cost); 

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
	public function priceCssClass() 
	{
		if ($this->price < $this->RecommendedPrice) return 'redbgcolor'; 
		if ($this->price > $this->basePrice) return 'green';		
	} 
	public function getDiscountOpt($contractorId=null )
	{ 		
		$discGroupId = DiscountGroup::getDiscountGroup($this->assortmentArticle);
		if(!$discGroupId) 
			return Yii::t('general','no discount group applied');
		$discGroupName = DiscountGroup::getDiscountGroupName($this->assortmentArticle);
	//	echo 'contractor: ', $contractorId, '; ';
		if ($contractorId) 
		{
			$ugd = UserGroupDiscount::model()->findByAttributes(array('userId'=>$contractorId,'discountGroupId'=>$discGroupId /*$discountGroup->name*/));
			if(isset($ugd)) 
				 return $ugd->value . '% ('. $discGroupName. ')';  
			else 		
				 return '('.$discGroupName.')'; //$discountGroup->name;
		}
		return Yii::t('general', 'no contractor given'); 
	}
}
