<?php

/**
 * This is the model class for table "{{assortment}}".
 *
 * The followings are the available columns in table '{{assortment}}':
 * @property string $id
 * @property integer $parent_id
 * @property string $subgroup
 * @property string $title
 * @property string $model
 * @property string $make
 * @property string $measure_unit
 * @property integer $price
 * @property integer $discount
 * @property string $imageUrl
 * @property string $fileUrl
 * @property integer $isService
 * @property integer $depth
 * @property string $article
 * @property double $priceS
 * @property string $oem
 * @property integer $organizationId
 * @property string $manufacturer
 * @property string $agroup
 * @property integer $availability
 * @property string $country
 * @property integer $MinPart
 * @property integer $YearBegin
 * @property integer $YearEnd
 * @property string $Currency
 * @property string $Analogi
 * @property string $Barcode
 * @property string $Misc
 * @property string $PartN
 * @property string $COF
 * @property string $Category
 */
class Assortment extends CActiveRecord implements IECartPosition
{
	public $amount; 		   // additional amount variable
	public $itemSearch, $modelMake;    // additional variable for search purpose 
	public $warehousesArray= array();
	/**
	 * @return string the associated database table name
	 */
	function getId(){
        return  $this->id;
    } 
	public function tableName()
	{
		return '{{assortment}}';
	}
 	public function rules()
	{
	 	return array(
		//	array('parent_id, subgroup, title, model, make, measure_unit, price, discount, imageUrl, fileUrl, isService, depth, article, priceS, oem, organizationId, manufacturer, agroup, availability, country, MinPart, YearBegin, YearEnd, Currency, Analogi, Barcode, Misc, PartN, COF, Category', 'required'),
		   array('title, model, make, article, priceS, oem, organizationId, manufacturer, availability', 'required'),
			array('parent_id, price, discount, isService, depth, organizationId, availability, MinPart, YearBegin, YearEnd', 'numerical', 'integerOnly'=>true),
			array('priceS', 'numerical'),
			array('subgroup, make, agroup', 'length', 'max'=>50),
			array('title, imageUrl, fileUrl, Barcode, Misc, PartN, COF, Category, itemSearch, specialDescription', 'length', 'max'=>255),
			array('model, article, manufacturer, country, Currency', 'length', 'max'=>200),
			array('measure_unit', 'length', 'max'=>20),
	 		array('id, parent_id, subgroup, title, model, make, measure_unit, price, discount, imageUrl, fileUrl, isService, depth, article, priceS, oem, organizationId, manufacturer, agroup, availability, country, MinPart, YearBegin, YearEnd, Currency, Analogi, Barcode, Misc, PartN, COF, Category, warehouseId, itemSearch, specialDescription, notes', 'safe', 'on'=>'search'),
		);
	}
 	public function relations()
	{
	 	return array(
				'warehouse'=> array(self::BELONGS_TO, 'Warehouse', 'warehouseId'),  		
		);
	}
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('general','Primary key'),
			'parent_id' => Yii::t('general','parent_id'),
			'subgroup' => Yii::t('general','Subgroup'),
			'title' => Yii::t('general','Title'),
			'model' => Yii::t('general','Model'),
			'make' => Yii::t('general','Make'),
			'measure_unit' => Yii::t('general','Measure Unit'),
			'price' => Yii::t('general','price'),
			'discount' => Yii::t('general','Discount'),
			'imageUrl' => Yii::t('general','Image Url'),
			'fileUrl' => Yii::t('general','File Url'),
			'isService' => Yii::t('general','isService'),
			'depth' => Yii::t('general','depth'),
			'article' => Yii::t('general','Article'),
			'priceS' => Yii::t('general','Price $'),
			'сurrentPrice' => Yii::t('general','Current Price'), 
			'oem' => Yii::t('general','OEM'),
			'organizationId' => Yii::t('general','organizationId'),
			'manufacturer' => Yii::t('general','Manufacturer'),
			'agroup' => Yii::t('general','Group'),
			'subgroup' => Yii::t('general','Subgroup'),
			'availability' => Yii::t('general','Availability'),
			'country' => Yii::t('general','Country'),
			'MinPart' => Yii::t('general','MinPart'),
			'YearBegin' => Yii::t('general','YearBegin'),
			'YearEnd' => Yii::t('general','YearEnd'),
			'Currency' => Yii::t('general','Currency'),
			'Analogi' => Yii::t('general','Analogi'),
			'Barcode' => Yii::t('general','Barcode'),
			'Misc' => Yii::t('general','Misc'),
			'PartN' => Yii::t('general','Part N'),
			'COF' => Yii::t('general','Cof'),
			'Category' => Yii::t('general','Category'),
			'amount' => Yii::t('general','Amount'),
			'warehouseId' => Yii::t('general','Warehouse'),
			'itemSearch' => Yii::t('general','Quick item search'),
			'specialDescription' => Yii::t('general','Special description'),
			'notes' => Yii::t('general','Notes'),
		);
	}
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id );
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('subgroup',$this->subgroup,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('warehouseId',$this->warehouseId);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('make',$this->make,true);
		$criteria->compare('measure_unit',$this->measure_unit,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('imageUrl',$this->imageUrl,true);
		$criteria->compare('fileUrl',$this->fileUrl,true);
		$criteria->compare('isService',$this->isService);
		$criteria->compare('depth',$this->depth);
		$criteria->compare('article',$this->article,true);
		$criteria->compare('priceS',$this->priceS);
		$criteria->compare('oem',$this->oem,true);	
		$criteria->compare('organizationId',$this->organizationId);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('agroup',$this->agroup,true);
		$criteria->compare('availability',$this->availability);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('MinPart',$this->MinPart);
		$criteria->compare('YearBegin',$this->YearBegin);
		$criteria->compare('YearEnd',$this->YearEnd);
		$criteria->compare('Currency',$this->Currency,true);
		$criteria->compare('Analogi',$this->Analogi,true);
		$criteria->compare('Barcode',$this->Barcode,true);
		$criteria->compare('Misc',$this->Misc,true);
		$criteria->compare('PartN',$this->PartN,true);
		$criteria->compare('COF',$this->COF,true);
		$criteria->compare('Category',$this->Category,true);
		$criteria->compare('specialDescription',$this->specialDescription,true);
		$criteria->compare('notes',$this->notes,true);
		
		$RoleId = Yii::app()->user->role;
		$OrganizationId = Yii::app()->user->organization;

		// Отбор номенклатуры по организации на уровне модели
		if(!empty($OrganizationId) && $RoleId!=1){ 
			$criteria->compare('OrganizationId', $OrganizationId);
		}
		if (Yii::app()->user->isGuest) $pagesize = 33;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
						'pageSize' =>  $pagesize ?  $pagesize  : Yii::app()->user->pageSize,
					),			
		));
	}   
	public function stool()
	{
		$criteria=new CDbCriteria;		  
	 	$criteria->compare('subgroup', $this->subgroup,true);		
	//	$criteria->addCondition("manufacturer <> ''");	 // добавляем это условие чтобы найти все позиции, а не (категории или подкатегории)
		
		if ($this->itemSearch) $criteria->addCondition('oem LIKE "%' . $this->itemSearch . '%" OR article LIKE "%' . $this->itemSearch . '%" ', 'AND'); 
		
		if ($this->modelMake) $criteria->addCondition('model LIKE "%' . $this->modelMake . '%" OR make LIKE "%' . $this->modelMake . '%" ', 'AND'); 
		
		// oтбор номенклатуры по организации 
		if(Yii::app()->user->role != User::ROLE_ADMIN) 
			$criteria->compare('organizationId', Yii::app()->user->organization);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
						'pageSize' =>  5, //$pagesize ?  $pagesize  : Yii::app()->user->pageSize,
					),		
		));
	}
	
	public function searchItemCriteria()
	{
		$criteria=new CDbCriteria;	 
		// поиск по itemSearch
		$criteria->compare('oem',  $this->itemSearch, true, 'OR'); 		 
		$criteria->compare('article',  $this->itemSearch, true, 'OR');		 
		return $criteria;
	}
  
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}  
	
	public function getPrice($ContractorId){ // учитывает скидку клиента (залогиненного) И скидку исходя из настроек ценнообразования Pricing
		
		if ($ContractorId!=''){
			$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), Yii::app()->user->id );	
			$discount = $discountNew ? $discountNew : User::model()->findByPk(Yii::app()->user->id)->discount;  		
		}else{
			$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), $ContractorId );	
			$discount = $discountNew ? $discountNew : User::model()->findByPk($ContractorId)->discount;  		
		}
		
		
		
		if (empty($discount)) $discount = 0;
        
		//echo 'discount /'.$discount.'/';
		
		return round($this->getCurrentPrice() * (1 + $discount/100), 2);
		
		
		
    }
	 
	public function getCurrentPrice() // возвращаем текущую цену исходя из последней настройки в документе Установка цен (Exchangerates)  
	    // не учитывает скидку клиента (см. getPrice() )
	{ 
		$criteria = new CDbCriteria;
		$criteria->order = 'Begin DESC';
		$criteria->condition = 'Currency = "USD" '; 
		$org = Yii::app()->user->isGuest ?  '7' : Yii::app()->user->organization;  // для гостей (Yii::app()->user->isGuest) мы выводим цену для компании 7
		$criteria->addCondition('organizationId = ' . $org );
		
		$rate = Exchangerates::model()->find($criteria); // находим одну последнюю по времени (Begin DESC).
		
		//echo ''.$rate->totalSum.'/'.$this->priceS.'/'.;
		return $rate->totalSum * $this->priceS;  
	}
 
	public function countDiscount( $date, $userId )
	{  
		//echo 'assortment '.$this->id.'/ user'.$userId.'/date'.$date; 
		$Discount=0;
		
		if (Yii::app()->user->isGuest){
			$Pricing=Pricing::model()->findall(array('order'=>'Date DESC', 'condition'=>'Date <= :Date AND isActive = 1 AND GroupFilter=4', 'params'=>array(':Date'=>$date) ));		
			
		}else{
			$Pricing=Pricing::model()->findall(array('order'=>'Date DESC', 'condition'=>'Date <= :Date AND isActive = 1 ', 'params'=>array(':Date'=>$date) ));
		
		}
		
		foreach ($Pricing as $r){
			
			$Field=$r->SubgroupFilter;			
			if($Field!=''){
				$FieldToCompare=mb_strtolower($this->subgroup);
				if (strstr($Field, "=")!=''){
					if ($FieldToCompare!=mb_strtolower(Substr($Field,1))){
						continue;
					}
				}elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
					if(stristr($Field, $FieldToCompare)=='' ) continue;
				}elseif (stristr ($Field, "Содержит")!='' ){
					$Pos=strpos ($Field, " ");
					$SearchString=Substr($Field, $Pos+1);
					if(stristr($FieldToCompare, $SearchString)== false ) continue;
				}
			}
			
			$Field=$r->TitleFilter;			
			if($Field!=''){
				$FieldToCompare=mb_strtolower($this->title);
				if (strstr($Field, "=")!=''){
					if ($FieldToCompare!=mb_strtolower(Substr($Field,1))){
						continue;
					}
				}elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
					if(stristr($Field, $FieldToCompare)=='' ) continue;
				}elseif (stristr ($Field, "Содержит")!='' ){
					$Pos=strpos ($Field, " ");
					$SearchString=Substr($Field, $Pos+1);
					if(stristr($FieldToCompare, $SearchString)== false ) continue;
				}
			}
			
			$Field=$r->ModelFilter;			
			if($Field!=''){
				$FieldToCompare=mb_strtolower($this->model);
				if (strstr($Field, "=")!=''){
					if ($FieldToCompare!=mb_strtolower(Substr($Field,1))){
						continue;
					}
				}elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
					if(stristr($Field, $FieldToCompare)=='' ) continue;
				}elseif (stristr ($Field, "Содержит")!='' ){
					$Pos=strpos ($Field, " ");
					$SearchString=Substr($Field, $Pos+1);
					if(stristr($FieldToCompare, $SearchString)== false ) continue;
				}
			}

			$Field=$r->MakeFilter;			
			if($Field!=''){
				$FieldToCompare=mb_strtolower($this->make); 
				if (strstr($Field, "=")!=''){ 
						//	if (  $FieldToCompare !=  mb_strtolower(Substr($Field,1))){
						if ( $FieldToCompare  != mb_strtolower( Substr($Field,1 ))) continue; 
				} elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
					if(stristr($Field, $FieldToCompare)=='' ) continue;
				} elseif (stristr($Field, "Содержит")  == '' ){
					$Pos=strpos($Field, " "); 
					$SearchString =  mb_substr($Field, $Pos+1);
					if(stristr($FieldToCompare, $SearchString) === false ) continue;
				}
			}

			$Field=$r->ArticleFilter;			
			if($Field!=''){
				$FieldToCompare=mb_strtolower($this->article);
				if (strstr($Field, "=")!=''){
					if ($FieldToCompare!=mb_strtolower(Substr($Field,1))){
						continue;
					}
				}elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
					if(stristr($Field, $FieldToCompare)=='' ) continue;
				}elseif (stristr ($Field, "Содержит")!='' ){
					$Pos=strpos ($Field, " ");
					$SearchString=Substr($Field, $Pos+1);
					if(stristr($FieldToCompare, $SearchString) == false ) continue;
				}
			}

			$Field=$r->OemFilter;			
			if($Field!=''){
				$FieldToCompare=mb_strtolower($this->oem);
				if (strstr($Field, "=")!=''){
					if ($FieldToCompare!=mb_strtolower(Substr($Field,1))){
						continue;
					}
				}elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
					if(stristr($Field, $FieldToCompare)=='' ) continue;
				}elseif (stristr ($Field, "Содержит")!='' ){
					$Pos=strpos ($Field, " ");
					$SearchString=Substr($Field, $Pos+1); 
					if(stristr($FieldToCompare, $SearchString)== false ) continue;
				}
			}			
			
			$Field=$r->ManufacturerFilter;			
			if($Field!=''){
				$FieldToCompare= mb_strtolower($this->manufacturer);
				if (strstr($Field, "=")!=''){
					if ($FieldToCompare!=mb_strtolower(Substr($Field,1))){
						continue;
					}
				}elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
					if(stristr($Field, $FieldToCompare)=='' ) continue;
				}elseif (stristr ($Field, "Содержит")!='' ){
					$Pos=strpos ($Field, " ");
					$SearchString=Substr($Field, $Pos+1);
					if(stristr($FieldToCompare, $SearchString)== false ) continue;
				}
			}			
			
			$Field=$r->CountryFilter;			
			if($Field!=''){
				$FieldToCompare=mb_strtolower($this->country);
				if (strstr($Field, "=")!=''){
					if ($FieldToCompare!=mb_strtolower(Substr($Field,1))){
						continue;
					}
				}elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
					if(stristr($Field, $FieldToCompare)=='' ) continue;
				}elseif (stristr ($Field, "Содержит")!='' ){
					$Pos=strpos ($Field, " ");
					$SearchString=Substr($Field, $Pos+1);
					if(stristr($FieldToCompare, $SearchString)== false ) continue;
				}
			}			
			
	//Фильтры по пользователю / группе	//echo 'user'.$userId;
//echo 'Discount2 /'.$Discount.'/';


			if (Yii::app()->user->isGuest) $Discount=$r->Value;
			//echo 'Discount '.$Discount;
			//return $Discount;

			if (empty($userId) || $userId==0) continue;
			
			$Field=$r->UsernameFilter;		
			if($Field!='' && $FieldToCompare!=''){ 	
				$FieldToCompare=mb_strtolower( User::model()->findbypk($userId)->username );
				if (strstr($Field, "=")!=''){
					if ($FieldToCompare!=mb_strtolower(Substr($Field,1))){
						continue;
					}
				}elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
					if(stristr($Field, $FieldToCompare)=='' ) continue;
				}elseif (stristr ($Field, "Содержит")!='' ){
					$Pos=strpos ($Field, " ");
					$SearchString=Substr($Field, $Pos+1);
					if(stristr($FieldToCompare, $SearchString)== false ) continue;
				}
			}			
			
			//Фильтр по группе пользователя
			$Field=$r->GroupFilter;			
			if($Field!='' && $FieldToCompare!='' ){
				$FieldToCompare=mb_strtolower( User::model()->findbypk($userId)->Group );
				//echo 'Discount/'.$Discount.'/Field/'.$Field.'/FieldToCompare/'.$FieldToCompare.'/';
				
				if ($FieldToCompare!=$Field){
						continue;
				}
			}			
			
			
			$Field=$r->SubgroupFilter;			
			if($Field!=''){
				$FieldToCompare=mb_strtolower($this->subgroup);
				if (strstr($Field, "=")!=''){
					if ($FieldToCompare!=mb_strtolower(Substr($Field,1))){
						continue;
					}
				}elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
					if(stristr($Field, $FieldToCompare)=='' ) continue;
				}elseif (stristr ($Field, "Содержит")!='' ){
					$Pos=strpos ($Field, " ");
					$SearchString=Substr($Field, $Pos+1);
					if(stristr($FieldToCompare, $SearchString)== false ) continue;
				}
			}			
			
			$Discount=$r->Value;
			break;
		}
		
		
		return $Discount;		
	}
	
	public function available()  // пока не работает
	{
		EventContent::model()->findAllByAttributes(array('assortmentId'=>$this->model));
	} 
	public function quantityReserved() // пока не работает
	{
		$i=0;
		foreach(EventContent::model()->findAllByAttributes(array('assortmentId'=>$this->id)) as $ec)
		{			
			$type = Events::model()->findByPk($ec->eventId)->EventTypeId;
			//if ($ec->event->EventTypeId) 
			if ($type) return $type; 				
		}
		return 0;		
	} 
	
	public function getAssortmentReport($inputData=null)
	{ 		
		$query = "SELECT event.id, type.name, event.totalSum, event.organizationId
						FROM  `tarex_eventcontent` as content
						LEFT JOIN  `tarex_events`       as event ON eventId =   event.id
						LEFT JOIN  `tarex_assortment`   as a     ON assortmentId =  a.id
						LEFT JOIN  `tarex_eventtype`    as type  ON eventTypeid =   type.id
						LEFT JOIN  `tarex_organization` as org   ON event.organizationId = org.id
						WHERE Subconto1 > 0";
						
		 $criteria=new CDbCriteria;
         $criteria->condition='StatusId = '. Events::STATUS_COMPLETED;		 
		 if ($inputData['warehouse']) 
			$criteria->addInCondition('Subconto1', $inputData['warehouse']); 
		 else 
			$criteria->addCondition('Subconto1 > 0');		
		if ($inputData['eventTypes']) 
		   $criteria->addInCondition('EventTypeId', $inputData['eventTypes']); 
		if ($inputData['assortmentIds']) 
		   $criteria->addInCondition('a.id', $inputData['assortmentIds']); 	
			
		  $where=$criteria->condition;
          $params=$criteria->params;
			        
		$command = Yii::app()->db->createCommand();     
        $resultQuery = $command->select('a.id as assortment_id, 
			assortmentTitle as ItemTitle, 
			event.id, 
			type.name as EventType, 
			assortmentAmount, 
			cost,
			warehouse.name as warehouse')
        ->from('tarex_eventcontent')
        ->leftjoin('tarex_events		       		AS event',  'eventId =   event.id')
        ->leftjoin('tarex_assortment     		AS a',        'assortmentId =  a.id')
        ->leftjoin('tarex_eventtype 	  		AS type' ,   'eventTypeid =   type.id')
        ->leftjoin('tarex_organization 	    AS org' ,    'event.organizationId = org.id') 
        ->leftjoin('tarex_warehouse 	        AS warehouse' ,    'event.Subconto1 = warehouse.id') 
		->where($where, $params);
		
		echo '<br><b>DETAILED QUERY BY ASSORTMENT ITEM: </b>"' , $resultQuery->text , '" ';
		echo '<br><b>DETAILED QUERY BY ASSORTMENT ITEM params: </b>'; print_r($params);  
        $result = $resultQuery->queryAll();
		
		//return $result; // return an array
      	return new CArrayDataProvider($result, array());
	}
	
	public function getReport($inputData=null)
	{ 		
		$query = "SELECT event.id as id, type.name, event.totalSum, event.organizationId
						FROM  `tarex_eventcontent` as content
						LEFT JOIN  `tarex_events`       as event ON eventId =   event.id
						LEFT JOIN  `tarex_assortment`   as a     ON assortmentId =  a.id
						LEFT JOIN  `tarex_eventtype`    as type  ON eventTypeid =   type.id
						LEFT JOIN  `tarex_organization` as org   ON event.organizationId = org.id
						LEFT JOIN `tarex_warehouse` `warehouse` ON event.Subconto1 = warehouse.id WHERE (Subconto1 > 0 AND (StatusId = 24)) AND (EventTypeId IN (18, 28, 27, 31, 32, 33)) "; 
						
		 $criteria=new CDbCriteria;
         $criteria->condition = 'StatusId = '. Events::STATUS_COMPLETED;
		 
		 if ($inputData['warehouse']) 
			$criteria->addInCondition('Subconto1', $inputData['warehouse']); 
		 else 
			$criteria->addCondition('Subconto1 > 0');
		 
		if ($inputData['eventTypes']) 
		   $criteria->addInCondition('EventTypeId', $inputData['eventTypes']); 	
			
		  $where=$criteria->condition;
          $params=$criteria->params;
			        
		$command = Yii::app()->db->createCommand();     
        $resultQuery = $command->select('event.id, type.name as EventType, assortmentTitle as ItemTitle , event.totalSum as EventTotal, org.name as organization, warehouse.name as warehouse')
        ->from('tarex_eventcontent')
        ->leftjoin('tarex_events		       		AS event',  'eventId =   event.id')
        ->leftjoin('tarex_assortment     		AS a',        'assortmentId =  a.id')
        ->leftjoin('tarex_eventtype 	  		AS type' ,   'eventTypeid =   type.id')
        ->leftjoin('tarex_organization 	    AS org' ,    'event.organizationId = org.id') 
        ->leftjoin('tarex_warehouse 	        AS warehouse' ,    'event.Subconto1 = warehouse.id') 
		->where($where, $params);
		
		echo '<br><b>DETAILED QUERY: </b>"' , $resultQuery->text , '" ';
		echo '<br><b>DETAILED QUERY params: </b>'; print_r($params);  
        $result = $resultQuery->queryAll();
		
		//return $result; // return an array
      	return new CArrayDataProvider($result, array());
	}
	
	public function getGroupReport($inputData=null)
	{ 		
		$query = "SELECT warehouse.id as id, warehouse.name as 'warehouse name', /*round(sum(event.totalSum),2) as 'Total Sum', */
			round(sum(sum_sign_by_eventtype(eventTypeid,  event.totalSum) ), 2) AS 'Total Sum new', 
				FROM `tarex_events` AS event
				LEFT JOIN `tarex_warehouse`  AS warehouse ON event.Subconto1 = warehouse.id 
				-- JOIN  `tarex_eventcontent`   as content    ON content.eventid =  event.id ---- неправильно даёт результат если добавить
				WHERE EventTypeId = 18 AND Subconto1 > 0
				GROUP BY Subconto1";
	// с помощью CDbCriteria мы формируем WHERE условие и привязку параметров, потом передаём это в CDbCommand				
		$criteria=new CDbCriteria; 
		$criteria->condition = 'Subconto1 > 0';
		$criteria->addCondition('StatusId = '. Events::STATUS_COMPLETED);
		   
	// фильтрация по типам событий если заданы   	
		if ($inputData['eventTypes']) 
		   $criteria->addInCondition('EventTypeId', $inputData['eventTypes']); 
		
		if ($inputData['warehouse']) 
			$criteria->addInCondition('Subconto1', $inputData['warehouse']); 
		// else 		$criteria->addCondition('Subconto1 > 0');	
			
		$where=$criteria->condition;
		$params=$criteria->params; 
			      
		$command = Yii::app()->db->createCommand();     
        $resultQuery = $command->select("warehouse.id, warehouse.name AS 'Warehouse',
			round(sum(sum_sign_by_eventtype(eventTypeid,  event.totalSum) ), 2) AS 'TotalSum' ")
        ->from('tarex_events AS event') 
        ->leftjoin('tarex_warehouse AS warehouse' , 'event.Subconto1 = warehouse.id') 
		->where($where, $params)
		->group('Subconto1');
		
		echo '<br><b>GROUPED QUERY: </b>"' , $resultQuery->text , '" ';		
		echo '<br><b>GROUPED QUERY params: </b>'; print_r($params);  
        $result = $resultQuery->queryAll();
		
		//return $result;
      	return new CArrayDataProvider($result, array());
	}
}
