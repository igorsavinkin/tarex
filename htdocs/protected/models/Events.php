<?php

/**
 * This is the model class for table "{{event}}".
 *
 * The followings are the available columns in table '{{event}}':
 * @property integer $id
 * @property string $Subject
 * @property string $eventNumber
 * @property string $Notes
 * @property string $Place
 * @property integer $EventTypeId
 * @property integer $organizationId
 * @property string $Begin
 * @property string $End
 * @property integer $contractorId
 * @property integer $contractId
 * @property double $Percentage
 * @property double $totalSum
 * @property integer $ReflectInCalendar
 * @property integer $ReflectInTree
 * @property integer $parent_id
 * @property integer $Priority
 * @property integer $StatusId
 * @property string $Comment
 * @property integer $PlanHours
 * @property double $FactHours
 * @property string $Tags
 * @property integer $bizProcessId
 * @property integer $manualTransactionEditing
 * @property string $dateTimeForDelivery
 * @property string $dateTimeForPayment
 */
class Events extends CActiveRecord
{
	const TYPE_MEETING = '1'; 
	const TYPE_CALL = '2';
	const TYPE_TASK = '3';
	const TYPE_ORDER = '4';
	const TYPE_PERSONAL = '6';
    const TYPE_PAYMENT = '8';
	const TYPE_CONTRACT = '11';	    	
    const TYPE_INFORMATION_1C = '13';	
    const TYPE_INFORMATION_PHP = '14';    
    const TYPE_INFLOW = '15'; // поступление
    const TYPE_MONEY_DOCUMENT= '16'; // денежный документ
    const TYPE_WRITE_OFF_CASHLESS_MONEY= '17'; // списание безналичных денежных средств
    const TYPE_SALE = '18'; // реализация
	const TYPE_INFLOW_CASHLESS_MONEY= '19'; // поступление безналичных денежных средств 
	const TYPE_CASH_IN_ORDER = '20'; // Приходный кассовый ордер ПКО
	const TYPE_CASH_OUT_ORDER = '21'; // Расходный кассовый ордер РКО
	const TYPE_NOTICE= '22'; // Уведомление
	const TYPE_NEWS= '23'; // Новость
	const TYPE_ENTER_INITIAL_FINANCIAL_BALANCES= '24'; // 
	
	const TYPE_EXCHANGE_RATE= '25'; // Курс валют
	const TYPE_PROFORMA= '26';          // Проформа
	const TYPE_ENTER_INITIAL_BALANCES_OF_GOODS = '27'; //  Ввод начальных остатков товаров
	const TYPE_SALES_RETURN = '28'; // Проформа
	const TYPE_RFQ= '29'; // RFQ (Запрос поставщику)
	const TYPE_PURCHASE_ORDER = '30'; // Заказ поставщику
	const TYPE_PURCHASE = '31'; // Покупка (Поступление)
	const TYPE_PURCHASE_RETURN = '32'; // Возврат поставщику
	const TYPE_TRANSFER = '33'; // Перемещение
	const TYPE_PRICING = '34'; // Установка цены
	const TYPE_HIRING = '35'; // Приём на работу
	const TYPE_LAY_OFF = '36'; // Увольнение с работы
	const TYPE_ADD_NEW_ASSORTMENT_ITEMS = '37'; // добавление новых запчастей от заказчика
	 
	/* Event statuses */
	const STATUS_NEW = '2';   // новый
	const STATUS_IN_WORK = '3';  // в работе
/*	const STATUS_REJECTED = '4';  // отказ
	const STATUS_COMPLETED = '5'; // выполнено
	const STATUS_REGISTERED = '6'; // оформлен
	const STATUS_INCOMING = '7'; // входящий
	const STATUS_RECLAMATION = '8'; // возврат
	const STATUS_IN_RESERVE = '9'; // в резерв
	*/
	const STATUS_DELIVERY = '10'; // доставка
	const STATUS_PAID = '11'; // оплачено 
	const STATUS_COMPLETED_AND_PAID = '12'; // выполнено и оплачено 
	const STATUS_DELIVERY_UP_TO_CUSTOMER = '13'; // доставка до клиента 
	const STATUS_REQUEST_TO_RESERVE = '14'; //Запрос в резерв
	const STATUS_REQUEST_TO_DELIVERY = '15'; //Запрос на доставку
 	const STATUS_CONFIRMED_TO_RESERVE = '16'; // подтверждён в резерв	
	const STATUS_CONFIRMED_WITH_CHANGES = '17'; // подтверждён с изменениями 
	const STATUS_REQUEST_TO_DELIVERY_WITH_CHANGES = '18'; // Подтверждён на доставку с изменениями
	const STATUS_REQUEST_TO_CANCELL = '19'; // Запрос на отмену
 	const STATUS_CANCELLED = '20'; // Отменено  
	const STATUS_DELIVERED = '21'; // Доставлено
 	const STATUS_SHIPPED = '22'; // Отгружено	
	const STATUS_CONFIRMED_TO_DELIVERY = '23'; // подтверждён на доставку
	const STATUS_COMPLETED = '24'; // Выполнено
	 
	public $eventTypes = array();
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{events}}';
	}

	
	public $file;
	public $Reference;
	
	/** 
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		//	array('Subject, eventNumber, Notes, Place, EventTypeId, organizationId, Begin, End, contractId, Percentage, totalSum, ReflectInCalendar, ReflectInTree,  parent_id, Priority, StatusId, Comment, PlanHours, FactHours, Tags, bizProcessId, dateTimeForDelivery, dateTimeForPayment', 'required'),
			array('EventTypeId, organizationId, contractorId, contractId, ReflectInCalendar, ReflectInTree, parent_id, Priority, StatusId, PlanHours, bizProcessId, manualTransactionEditing, PaymentType, Subconto1, Subconto2', 'numerical', 'integerOnly'=>true),
			array('Percentage, totalSum, FactHours', 'numerical'),
			array('Subject, Place, Comment, Tags, Notes, Reference', 'length', 'max'=>200),
			array('eventNumber, Currency, Begin, End', 'length', 'max'=>50),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Subject, authorId, eventNumber, Notes, Place, EventTypeId, organizationId, Begin, End, contractorId, contractId, Percentage, totalSum, ReflectInCalendar, ReflectInTree, parent_id, Priority, StatusId, Comment, PlanHours, FactHours, Tags, bizProcessId, manualTransactionEditing, dateTimeForDelivery, dateTimeForPayment, PaymentType, Currency, Subconto1, Subconto2', 'safe', 'on'=>'search'),
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
			'EventType'=> array(self::BELONGS_TO, 'Eventtype', 'EventTypeId'),  
			'author'=> array(self::BELONGS_TO, 'User', 'authorId'),  
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('general','ID'), 
			'Currency' => Yii::t('general','Currency'), 
			'Subject' => Yii::t('general','Subject'),
			'eventNumber' => Yii::t('general','Event Number'),
			'Notes' => Yii::t('general','Notes'),  
			'Place' => Yii::t('general','Place'), 
			'EventTypeId' => Yii::t('general','Event Type'), 
			'Begin' =>Yii::t('general','Begin'), 'Начало',
			'End' =>Yii::t('general','End'), 'Окончание',
			'contractorId' => Yii::t('general', 'Contractor'),
			'authorId' => Yii::t('general', 'Event Author'), 
			'contractId' => Yii::t('general', 'Contract'),
			'Percentage' =>Yii::t('general', 'Percentage done'), 
			'ReflectInCalendar' =>Yii::t('general', 'Reflect in Calendar') , 
			'ReflectInTree' =>Yii::t('general', 'Reflect in Tree'), 
			'parent_id' => Yii::t('general', 'Parent'),
			'Priority' => Yii::t('general', 'Priority'), 
			'StatusId' => Yii::t('general', 'Status'), 
			'Comment' =>Yii::t('general', 'Comment'),
			'organizationId' =>Yii::t('general', 'Organization'),
			'PlanHours' =>Yii::t('general', 'Hours planned'),
			'FactHours' =>Yii::t('general', 'Hours fact (all users)'),
			'FactHours2' =>Yii::t('general', 'Hours fact (by the current user)'),
			'Tags' =>Yii::t('general', 'Tags'),
			'totalSum' =>Yii::t('general', 'Total sum, RUB'),
			'includeMe' =>Yii::t('general', 'include me'),
			'allSubbordinates' =>Yii::t('general', 'all subbordinates'), 
			'urgent' =>Yii::t('general', 'Urgent Events'),
			'notCompleted' =>Yii::t('general', 'not completed Events'),
			'bizProcessId' =>Yii::t('general', 'Business Process'),
			'PaymentType'=>Yii::t('general', 'Payment Type'), //'Тип Оплаты',
			'manualTransactionEditing' =>Yii::t('general', 'Manual Transaction editing'), 
		 	'dateTimeForDelivery' => Yii::t('general','Date & time for delivery'), //'дата и время когда ставить статус "Доставка"'),
			'dateTimeForPayment' => Yii::t('general','Date & time for payment'), //'время и дата для оплаты. Если не было оплаты, то высылаются письма с уведомлением'), 
		); 
	}

	public function search()
	{
		 $criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('Subject',$this->Subject,true);
		$criteria->compare('eventNumber',$this->eventNumber,true);
		$criteria->compare('Notes',$this->Notes,true);
		$criteria->compare('Place',$this->Place,true);
		$criteria->compare('contractorId',$this->contractorId);
		$criteria->compare('contractId',$this->contractId);
		$criteria->compare('authorId',$this->authorId);
		$criteria->compare('Percentage',$this->Percentage);
		$criteria->compare('totalSum',$this->totalSum);
		$criteria->compare('ReflectInCalendar',$this->ReflectInCalendar);
		$criteria->compare('ReflectInTree',$this->ReflectInTree);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('Priority',$this->Priority);
		$criteria->compare('StatusId',$this->StatusId);
		$criteria->compare('Comment',$this->Comment,true);
		$criteria->compare('PlanHours',$this->PlanHours);
		$criteria->compare('FactHours',$this->FactHours);
		$criteria->compare('Tags',$this->Tags,true);
		$criteria->compare('bizProcessId',$this->bizProcessId);
		$criteria->compare('manualTransactionEditing',$this->manualTransactionEditing);
		$criteria->compare('dateTimeForDelivery',$this->dateTimeForDelivery,true);
		$criteria->compare('dateTimeForPayment',$this->dateTimeForPayment,true);
		$criteria->compare('Subconto1',$this->Subconto1,true);
		$criteria->compare('Subconto2',$this->Subconto2,true); 

		if (Yii::app()->user->role != User::ROLE_ADMIN)        
			$criteria->compare('organizationId', Yii::app()->user->organization);
		else  
			$criteria->compare('organizationId',$this->organizationId);
	// фильтрация по пользователю если он - клиент 	
		if(Yii::app()->user->role == USER::ROLE_USER OR Yii::app()->user->role == USER::ROLE_USER_RETAIL) 
			$criteria->compare('contractorId', Yii::app()->user->id);	 
		
		
		if ($this->Begin) $criteria->addCondition('Begin >= "' . $this->Begin . '" ');
		if ($this->End) $criteria->addCondition('Begin <= "' . $this->End . '" ');
		
		$Reference = $_GET['Reference'] ? $_GET['Reference'] : Yii::app()->controller->id;
		$ModelEventType = Eventtype::model()->findByAttributes(array('Reference'=>$Reference));	 
		
		if (!empty($ModelEventType) && !empty($Reference) )
		{
			$criteria->compare('EventTypeId', $ModelEventType->id);			
		}  else {		
			$criteria->compare('EventTypeId', $this->EventTypeId);
		} 
		 
		$criteria->order= 'id DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>Yii::app()->params['defaultPageSize']),
		));
	}
	
	public function criteria()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('Subject',$this->Subject,true);
		$criteria->compare('eventNumber',$this->eventNumber,true);
		$criteria->compare('Notes',$this->Notes,true);
		$criteria->compare('Place',$this->Place,true); 
		$criteria->compare('contractorId',$this->contractorId);
		$criteria->compare('contractId',$this->contractId);
		$criteria->compare('authorId',$this->authorId);
		$criteria->compare('Percentage',$this->Percentage);
		$criteria->compare('totalSum',$this->totalSum);
		$criteria->compare('ReflectInCalendar',$this->ReflectInCalendar);
		$criteria->compare('ReflectInTree',$this->ReflectInTree);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('Priority',$this->Priority);
		$criteria->compare('StatusId',$this->StatusId);
		$criteria->compare('Comment',$this->Comment,true);
		$criteria->compare('PlanHours',$this->PlanHours);
		$criteria->compare('FactHours',$this->FactHours);
		$criteria->compare('Tags',$this->Tags,true);
		$criteria->compare('bizProcessId',$this->bizProcessId);
		$criteria->compare('manualTransactionEditing',$this->manualTransactionEditing);
		$criteria->compare('dateTimeForDelivery',$this->dateTimeForDelivery,true);
		$criteria->compare('dateTimeForPayment',$this->dateTimeForPayment,true);

		if (Yii::app()->user->role != User::ROLE_ADMIN)        
			$criteria->compare('organizationId', Yii::app()->user->organization);
		else  
			$criteria->compare('organizationId',$this->organizationId);	 
		
		if ($this->Begin) $criteria->addCondition('Begin >= "' . $this->Begin . '" ');
		if ($this->End) $criteria->addCondition('Begin <= "' . $this->End . '" '); // внимание, здесь мы сравниваем поле 'Begin' в базе (Begin - единственная дата события) со значением  атрибута модели 'End' из формы поиска (_search.php).
			 
		$criteria->order= 'id DESC';
		return $criteria; 
	}  
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotalsKeys($keys)
	{
		$records=self::model()->findAllByPk($keys);
		$sum=0;
		foreach($records as $record) 
		{
			if ($record->EventTypeId == self::TYPE_ORDER) $sum-=$record->totalSum; //else $sum+=$record->totalSum;
			
			if ($record->EventTypeId == self::TYPE_PAYMENT) $sum+=$record->totalSum;
		}
		return $sum;				
	}
 	public function getPriceCssClass() 
	{
		if ($this->price == $this->RecommendedPrice) return '';
		if ($this->price > $this->RecommendedPrice) return 'blue';
		if ($this->price < $this->RecommendedPrice) return 'green';
	}
	protected function afterDelete()
    {
		parent::afterDelete();
		EventContent::model()->deleteAllByAttributes(array( 'eventId' => $this->id)); 	 
	}
	public function __clone()  
	{  
		$new = new Events;
		$new->attributes = $this->attributes; // заносим в новое всё из предыдущего
		$new->id = null;   //  в новом мы сбрасываем id старого чтобы при save() присвоился новый id
		$new->begin = date('Y-m-d H:i:s');  // заносим в новое новую дату
		$new->save();
	// перенос содержимого события в новое событие
		$content = EventContent::findAllByAttributes(array('eventId'=>$this->id));
		foreach($content as $c)
		{
		    $newEventContent = new EventContent;
			$newEventContent->attributes = $c->attributes;
			$newEventContent->id = null; // обозначаем его как новый
			$newEventContent->eventId = $new->id; // меняем его eventId на id его только что сохранённого события
			$newEventContent->save();		
		}
		return $new;  // возвращаем новое событие
	}
	public function cloneEvent($newEventTypeId=null)  
	{  
		$new = new Events;
		$new->attributes = $this->attributes; // заносим в новое всё из предыдущего
		$new->id = null;   //  в новом мы сбрасываем id старого чтобы при save() присвоился новый id
		$new->Begin = date('Y-m-d H:i:s');  // заносим в новое новую дату
		if ($newEventTypeId) $new->EventTypeId = $newEventTypeId; // если передан параметр "новый тип события"- тогда мы назначаем событию этот новый тип 
		$new->save();
	// перенос содержимого события в новое событие
		$content = EventContent::model()->findAllByAttributes(array('eventId'=>$this->id));
		foreach($content as $c)
		{
		    $newEventContent = new EventContent;
			$newEventContent->attributes = $c->attributes;
			$newEventContent->id = null; // обозначаем его как новый
			$newEventContent->eventId = $new->id; // меняем его eventId на id его только что сохранённого события
			$newEventContent->save();		
		}
		return $new;  // возвращаем новое событие
	} 
	public function orderNotation()  
	{
		return CHtml::Link(Yii::t('general','Order') . ' ' . Yii::t('general','#') . $this->id.  ' ' . Yii::t('general','from date') . ' ' . Controller::FConvertDate($this->Begin) , array('order/update', 'id'=>$this->id));
		//Yii::t('general','Order') . ' ' . Yii::t('general','#') . $this->id.  ' ' . Yii::t('general','from date') . ' ' . Controller::FConvertDate($this->Begin);
	}
	public function ordersOfOrganization($organization)
	{
		$condition = 'EventTypeId = :EventTypeId'; 
		if ($organization) // если $organization = 0 тогда выбираются все организации
			$condition .= ' AND organizationId = '. $organization;
		$filteredOrders = self::model()->findAll( array( 
			'order'=>'id DESC', 
			'condition'=>$condition,
			'params'=>array('EventTypeId' => self::TYPE_ORDER),
				));
		foreach($filteredOrders as $order)  
			$orders[$order->id] = $order->orderNotation();	
		return $orders;	
	}
	protected function afterSave()
	{
		parent::afterSave();
		$contents = EventContent::model()->findAllByAttributes(array('eventId'=>$this->id));
	 
		if ($contents) 
		{	
			$sum=0;
			foreach($contents as $content)				
				$sum += $content->cost; //echo $content->assortmentTitle, ' --- ' , $content->cost, '<br>'; 

			$this->totalSum = $sum;
			//echo '$this->totalSum = ', $this->totalSum;
			$this->saveAttributes(array('totalSum')); // doe not call for before/afterSave() methods as opposite to $this->save(); 			
		}		 
	}  
}
