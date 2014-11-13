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
 * @property integer $isSpecialOffer
 * @property integer $depth
 * @property string $article
 * @property string $article2
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
 * @property string $ItemCategory
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
		//	array('parent_id, subgroup, title, model, make, measure_unit, price, discount, imageUrl, fileUrl, isService, depth, article, priceS, oem, organizationId, manufacturer, agroup, availability, country, MinPart, YearBegin, YearEnd, Currency, Analogi, Barcode, Misc, PartN, COF, ItemCategory', 'required'),	
		
		/*****************************************/
		    array('title, article, priceS, oem, organizationId, availability', 'required'),
			array('parent_id, price, discount, isService, isSpecialOffer, depth, organizationId,  LeadTime, RealLeadTime, availability, MinPart, YearBegin, YearEnd, userId, SupplierCode, groupCategory', 'numerical', 'integerOnly'=>true),
			array('priceS, FOBCost', 'numerical'),	
			array('subgroup, make, agroup,CostCalculation,ItemOrigin, PurchaseCurrency, Currency, ItemCategory', 'length', 'max'=>50), 		 
			array('title, imageUrl, notes, fileUrl, Barcode, Misc, PartN, COF, itemSearch, specialDescription,ItemPosition,warehouse,Photos, techInfo', 'length', 'max'=>1000),
			array('Analogi','length', 'max'=>65355),
			
			array('model, article, article2,  manufacturer, country, specialDescription,SchneiderN,SchneiderOldN,TradeN, PartN, ItemCode', 'length', 'max'=>200),
			array('measure_unit, PIN, ItemFamily, ItemOrigin', 'length', 'max'=>20),
	 		array('id, parent_id, subgroup, title, model, make, measure_unit, price, discount, imageUrl, fileUrl, isService, depth, article, article2, priceS, oem, organizationId, manufacturer, agroup, availability, country, MinPart, YearBegin, YearEnd, Currency, Analogi, Barcode, Misc, PartN, COF, ItemCategory, warehouseId, itemSearch, specialDescription, notes, Photos, userId, ItemCode, FOBCost, PurchaseCurrency,   LeadTime , RealLeadTime, CostCalculation, ItemOrigin, ItemFamily, techInfo, SupplierCode, PIN, groupCategory, isSpecialOffer', 'safe', 'on'=>'search'),
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
			'groupCategory' => Yii::t('general','Category'),
			'title' => Yii::t('general','Title'),
			'model' => Yii::t('general','Model'),
			'make' => Yii::t('general','Make'),
			'measure_unit' => Yii::t('general','Measure Unit'),
			'price' => Yii::t('general','price'),
			'discount' => Yii::t('general','Discount'),
			'imageUrl' => Yii::t('general','Image'), //Yii::t('general','Image Url'),
			'fileUrl' => Yii::t('general','File Url'),
			'isService' => Yii::t('general','isService'),
			'depth' => Yii::t('general','depth'),
			'article' => Yii::t('general','Article'),
			'article2' => Yii::t('general','Article'),
			'priceS' => Yii::t('general','Price $'),
			'сurrentPrice' => Yii::t('general','Current Price'), 
			'oem' => Yii::t('general','OEM'),
			'organizationId' => Yii::t('general','Organization'),
			'manufacturer' => Yii::t('general','Manufacturer'),
			'agroup' => Yii::t('general','Group'),
			'subgroup' => Yii::t('general','Subgroup'),
			'availability' => Yii::t('general','Availability'),
			'country' => Yii::t('general','Country'),
			'MinPart' => Yii::t('general','MinPart'),
			'YearBegin' => Yii::t('general','YearBegin'),
			'YearEnd' => Yii::t('general','YearEnd'),
			'Currency' => Yii::t('general','Currency'),
			'Analogi' => Yii::t('general','Analogs'),
			'Barcode' => Yii::t('general','Barcode'),
			'Misc' => Yii::t('general','Misc'),
			'PartN' => Yii::t('general','Part N'),
			'COF' => Yii::t('general','Cof'),
			'ItemCategory' => Yii::t('general','Category'),
			'amount' => Yii::t('general','Amount'),
			'warehouse' => Yii::t('general','Warehouse'),
			'itemSearch' => Yii::t('general','Quick item search'),
			'specialDescription' => Yii::t('general','Special description'),
			'notes' => Yii::t('general', 'Notes'),
			'SchneiderN' => Yii::t('general','Schneider Number'),
			'SchneiderOldN' => Yii::t('general','old Schneider Number'),
			'specialDescription' => Yii::t('general','Special Description'),
			'userId'=>Yii::t('general', 'User created this item'),
			'FOBCost'=>Yii::t('general', 'FOB cost'),
		);
	}
	public function search($specialOffer=null)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id );
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('subgroup',$this->subgroup,true);
		$criteria->compare('groupCategory', $this->groupCategory);
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
		$criteria->compare('priceS',$this->priceS);
		
		
		$replaced4article = str_replace(array('.', '-', ' '), "", $this->article); // заменяем точки, тире и пробелы на ничего ТОЛЬКО для поиска по OEM и Артикулу 
		$criteria->compare('article', $replaced4article, true);	
		
		$replaced4article2 = str_replace(array('.', '-', ' '), "", $this->article2); // заменяем точки, тире и пробелы на ничего ТОЛЬКО для поиска по OEM и Артикулу 
		$criteria->compare('article', $replaced4article2, true);	 	
		 
	/*	$replaced4oem = str_replace(array('.', '-', ' '), "", $this->oem); // заменяем точки, тире и пробелы на ничего ТОЛЬКО для поиска по OEM и Артикулу 		
		$criteria->compare('oem', $replaced4oem);	*/
		
		$criteria->compare('oem', str_replace(array('.', '-', ' '), '', $this->oem), true);
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
		$criteria->compare('ItemCategory',$this->ItemCategory,true);
		$criteria->compare('specialDescription',$this->specialDescription,true);
		$criteria->compare('notes',$this->notes,true);
	// добавляем условие чтобы отсеять все общие записи в номенклатуре
		$criteria->addCondition("manufacturer <> '' ");
		
		$RoleId = Yii::app()->user->role;
		$OrganizationId = Yii::app()->user->organization;

		// Отбор номенклатуры по организации на уровне модели
		//if(!empty($OrganizationId) && $RoleId!=1){ 
		/*if(!empty($OrganizationId)){ 
			$criteria->compare('OrganizationId', $OrganizationId);
			//echo $OrganizationId;
		}*/
		if (Yii::app()->user->isGuest) $pagesize = 33;
		
		if ($specialOffer) 
			$criteria->compare('isSpecialOffer', '1');
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
						'pageSize' =>  isset($pagesize) ?  $pagesize  : Yii::app()->user->pageSize,
					),			
		));
	}

	public function search2()
	{
		$criteria=new CDbCriteria;
		
		$pagesize = 33;
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
		 
		$replaced4article = str_replace(array('.', '-', ' '), "", $this->article); // заменяем точки, тире и пробелы на ничего ТОЛЬКО для поиска по OEM и Артикулу 
		if ($this->itemSearch) 
		{  
			$replaced4oem = str_replace(array('.', '-', ' ') , "" , $this->article); // заменяем точки, тире и пробелы на ничего ТОЛЬКО для поиска по OEM и Артикулу 
			$criteria->addCondition('oem LIKE "%' . $replaced4oem . '%" OR article LIKE "%' . $replaced4oem . '%" ', 'AND'); 
		}
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
	
	public function getPriceOptMax()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('articles', $this->article, true); // нестрогое сравнение в поле Артикулы
		$discount = DiscountGroup::model()->find($criteria)->value; 
		//return isset($discount) ? $disc : '0';
		return round($this->getCurrentPrice() * (1 + $discount/100), 2); 
	}
	public function getDiscountOpt($contractorId=null )
	{ 
		$discGroupName = DiscountGroup::getDiscountGroupName($this->article2);
		$discGroupId = DiscountGroup::getDiscountGroup($this->article2);
		if(!$discGroupId) 
			return Yii::t('general','no discount group applied');
	
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
	public function getPriceOpt($contractorId=null ) 
	{ 	
		if ($contractorId) 
		{	
			$UserRole = User::model()->findByPk($contractorId)->role;
		
		// если это розничный клиент тогда мы выдаём цену с его скидкой из Ценообразования:  $this->getPrice($contractorId)			
			if ($UserRole == User::ROLE_USER_RETAIL) 
				return $this->getPrice($contractorId); // . ' retail';
		
		// если это оптовый клиент	то тогда ищем скидки в группах скидок для этого клиента по артикулу позиции	($this->article2)
			if ($UserRole == User::ROLE_USER) 
			{    
				$discGroupId = DiscountGroup::getDiscountGroup($this->article2); 
				$ugd = UserGroupDiscount::model()->findByAttributes(array('userId'=>$contractorId,'discountGroupId'=>$discGroupId ));
				return isset($ugd) ? round($this->getCurrentPrice() * (1 + $ugd->value/100), 2) : $this->getCurrentPrice();  	 
			}
		}
	 // если не задан контрагент или ни одно условие не выполнено, тогда выдаём базовую цену.
		return $this->getCurrentPrice(); //Yii::t('general', 'no contractor given'); 
	} 
 	public function getPrice($ContractorId=null)
	{ // учитывает скидку оптового клиента (залогиненного) И скидку исходя из настроек ценнообразования Pricing для всех других случаев	
		$ContractorId = isset($ContractorId) ? $ContractorId : Yii::app()->user->id;
        //echo 'ContractorId =', $ContractorId;
		$UserRole = User::model()->findByPk($ContractorId)->role;
	// если это оптовый клиент	то тогда ищем скидки в группах скидок для этого клиента по артикулу позиции	($this->article2)
		if ($UserRole == User::ROLE_USER) 
		{    
			$discGroupId = DiscountGroup::getDiscountGroup($this->article2); 
			$ugd = UserGroupDiscount::model()->findByAttributes(array('userId'=>$ContractorId,'discountGroupId'=>$discGroupId ));
			return isset($ugd) ? round($this->getCurrentPrice() * (1 + $ugd->value/100), 2) : $this->getCurrentPrice();  	
		}
				
	// если это розничный клиент или кто-то из работников тогда мы выдаём цену с его скидкой из Ценообразования:  $this->getPrice($contractorId)				 		 
		$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), $ContractorId );	
		//echo 'discountNew =', $discountNew, '<br>';
		$discount = $discountNew ? $discountNew : User::model()->findByPk($ContractorId)->discount;  				
		if (empty($discount)) $discount = 0; // echo 'discount =', $discount ;
		return round($this->getCurrentPrice() * (1 + $discount/100), 2);
			 
	/*	} else { // если не задан контрагент тогда выдаём цену из Ценообразования (Pricing) по залогиненному пользователю. 
			$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), Yii::app()->user->id );	
			if (Yii::app()->user->isGuest) 
				$discount = $discountNew; 
			else
				$discount = $discountNew ? $discountNew : User::model()->findByPk(Yii::app()->user->id)->discount;  		
			return round($this->getCurrentPrice() * (1 + $discount/100), 2);
		}*/
		
		return $this->getCurrentPrice() ; //Yii::t('general', 'no contractor given'). 'cp'; 
    } 
	/*public function getPrice($ContractorId=''){ // учитывает скидку клиента (залогиненного) И скидку исходя из настроек ценнообразования Pricing
	 
		if ( $ContractorId=='') {
		 	$UserRole = User::model()->findByPk(Yii::app()->user->id)->role;
			if ($UserRole == User::ROLE_USER) 
			{    
				$discGroupId = DiscountGroup::getDiscountGroup($this->article2); 
				$ugd = UserGroupDiscount::model()->findByAttributes(array('userId'=>$ContractorId,'discountGroupId'=>$discGroupId )); 
				return isset($ugd) ? round($this->getCurrentPrice() * (1 + $ugd->value/100), 2) : $this->getCurrentPrice();  	
			} else {	 	
				$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), Yii::app()->user->id );	
				if (Yii::app()->user->isGuest) 
					$discount = $discountNew; 
				else
					$discount = $discountNew ? $discountNew : User::model()->findByPk(Yii::app()->user->id)->discount;  		
			}
		}else{
			$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), $ContractorId );	
			$discount = $discountNew ? $discountNew : User::model()->findByPk($ContractorId)->discount;  		
		} 
		
		if (empty($discount)) $discount = 0;
        
		//echo 'discount /'.$discount.'/';
		
		return round($this->getCurrentPrice() * (1 + $discount/100), 2); 
    }*/
	
	
	// используется в OrderController
	public function getPrice2($Id){ // учитывает скидку клиента (залогиненного) И скидку исходя из настроек ценнообразования Pricing
		if ($Id==''){
			$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), Yii::app()->user->id );	
			$discount = $discountNew ? $discountNew : User::model()->findByPk(Yii::app()->user->id)->discount;  		
		}else{
			$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), $Id );	
			$discount = $discountNew ? $discountNew : User::model()->findByPk($Id)->discount;  
		}		
		if (empty($discount)) $discount = 0;		
		return round($this->getCurrentPrice() * (1 + $discount/100), 2);
    }	
	 
	public function getCurrentPrice() // возвращаем текущую цену исходя из последней настройки в документе Установка цен (Exchangerates)  
	    // не учитывает скидку клиента 
	{ 
		$criteria = new CDbCriteria;
		$criteria->order = 'Begin DESC';
		$criteria->condition = 'Currency = "USD" '; 
		$org = Yii::app()->user->isGuest ? Yii::app()->params['organization'] : Yii::app()->user->organization;  // для гостей (Yii::app()->user->isGuest) мы выводим цену для компании из Yii::app()->params['organization']
		$criteria->addCondition('organizationId = ' . $org );
		
		$rate = Exchangerates::model()->find($criteria); // находим одну последнюю по времени (Begin DESC).			
		//echo ''.$rate->totalSum.'/'.$this->priceS.'/';
		return $rate->totalSum * $this->priceS;  		
	}
 
	public function countDiscount( $date, $userId )
	{  
		//echo 'assortment '.$this->id.'/ user'.$userId.'/date'.$date; 
		$Discount=0;
		
		if (Yii::app()->user->isGuest){
			$Pricing=Pricing::model()->findall(array('order'=>'Date DESC', 'condition'=>'Date <= :Date AND isActive = 1 AND GroupFilter="3" ', 'params'=>array(':Date'=>$date) ));			
		}else{
			$Pricing=Pricing::model()->findall(array('order'=>'Date DESC', 'condition'=>'Date <= :Date AND isActive = 1 ', 'params'=>array(':Date'=>$date) ));
		}
		
		foreach ($Pricing as $r){
			
			$Field=$r->SubgroupFilter;	
		//	echo '$r->SubgroupFilter = ', $r->SubgroupFilter, '<br>';
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


			if (Yii::app()->user->isGuest) {
				$Discount=$r->Value;
			//	echo 'discount (Guest) = ', $Discount , '<br>';
				return $Discount;
			}
				
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
			if($Field!='' ){ 
			
				$FieldToCompare=mb_strtolower( User::model()->findbypk($userId)->Group );
				// echo 'Discount/'.$Discount.'/Field/'.$Field.'/FieldToCompare/'.$FieldToCompare.'/';
				
				if ($FieldToCompare!=$Field){
						continue;
				}
			}			
			
			
			
			
			$Discount=$r->Value;
			//echo 'Discount '.$Discount.'/Comment '.$r->Comment;
			//return;
			
			break;
		}
		
		
	//	echo 'discount = ', $Discount , '<br>';
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
        $resultQuery = $command->select('event.id, event.Begin as EventTime, 
		 type.name as EventType, 
		 contractor.username as Contractor, 
		 author.username as Author, 
		 assortmentTitle as ItemTitle,
         sum_sign_by_eventtype(eventTypeid,  event.totalSum) as EventTotal, 
		 org.name as organization, 
		 warehouse.name as warehouse')
        ->from('tarex_eventcontent')
        ->leftjoin('tarex_events		       		AS event',        'eventId =   event.id')
        ->leftjoin('tarex_assortment     		AS a',              'assortmentId =  a.id')
        ->leftjoin('tarex_eventtype 	  		AS type' ,         'eventTypeid =   type.id')
        ->leftjoin('tarex_organization 	    AS org' ,          'event.organizationId = org.id') 
        ->leftjoin('tarex_warehouse 	        AS warehouse' ,    'event.Subconto1 = warehouse.id') 
        ->leftjoin('tarex_user 	                AS contractor' ,     'event.contractorId = contractor.id') 
        ->leftjoin('tarex_user 	                AS author' ,          'event.authorId = author.id') 
		->where($where, $params);
		
		echo '<br><b>DETAILED QUERY: </b>"' , $resultQuery->text , '" ';
		echo '<br><b>DETAILED QUERY params: </b>'; print_r($params);  
        $result = $resultQuery->queryAll();
		
		//return $result; // return an array
      	return new CArrayDataProvider($result, array());
	}
	
	
	public function fob($begin=null, $end=null, $organizationId=null, $contractorId=null, $log=0)  
	{  
		// подсчёт суммы проданной позиции (за интервал)
		// sales TYPE_SALE 
	  
		$organizationId = $organizationId ? $organizationId : Yii::app()->params['organization'];
		//$contractorId = $contractorId ? $contractorId : Yii::app()->user->id;
		
		$criteria= new CDbCriteria;
	 	$criteria->select = 'cost'; //'sum(cost) as costs';  
		$criteria->compare('assortmentId', $this->id ); // http://www.yiiframework.com/doc/api/1.1/CDbCriteria#compare-detail
	 	if ($begin) $criteria->addCondition('Begin >= "' . $begin . '" ');
	 	if ($end) $criteria->addCondition('Begin <= "' . $end . '" ');
		if ($contractorId) $criteria->compare('contractorId', $contractorId);  // контрагент
		
		$criteria->compare('EventTypeId', Events::TYPE_SALE);  // продажа
	 	$criteria->compare('organizationId', $organizationId);  // организация 
	 	//	$criteria->group = 'EventTypeId';  
		 
		$ec = EventContent::model()->with('event')->findAll($criteria); //->with('event');
		//
		$sum=0;
		foreach($ec as $content)
		{
		    $sum+=$content->cost;			
		} 
		
		if ($log) {
			echo '<br>EventContent = '; print_r($ec);
			$tableSchema = EventContent::model()->getTableSchema();
			$command = EventContent::model()->getCommandBuilder()->createFindCommand($tableSchema, $criteria);
			echo '<br><b> sql command = ', $command->text;
		}
		else { return $sum;  }
	}
	
	public function getGroupReport($inputData=null)
	{ 		
     /*   if ($inputData['assortmentId'])
		{
			 $criteria= new CDbCriteria;
			 $criteria->condition = "id = {$inputData['assortmentId']} AND warehouseId = 6 ";
			 $assortment = Assortment::model()->find($criteria);
			 echo '<br>warehouse = ', $assortment->warehouseId;
			 echo '<br>load date = ', $assortment->date;
			 echo '<br>rest of this amount = ', $assortment->availability;   
			 echo '<br>cost of these assortment items = ', $assortment->availability * Assortment::getCurrentPrice();   
		}	*/  
		$queryInitialAmount ="Select COALESCE(warehouseId, 'Total') as warehouseId, 		 sum(availability) as sum,  round(SUM( availability * priceS ), 2) as 'cost_in_$' 
		from `tarex_assortment` 
		where priceS > 0
		AND `tarex_assortment`.date < NOW() -- or given date
		Group By warehouseId With ROLLUP";
		$command = Yii::app()->db->createCommand(); 
	    $initialAmountQuery = $command->select("COALESCE(warehouseId, 'Total') as warehouseId, 		 sum(availability) as sum,  round(SUM( availability * priceS ), 2) as 'cost_in_usd' ")
        ->from('tarex_assortment AS event')  
		->where('priceS>0') 
		->group('(warehouseId) WITH ROLLUP');
	//	echo '<br><b>InitialAmount QUERY: </b>"' , $initialAmountQuery->text , '" ';		/**/ 
        $initialAmountResult = $initialAmountQuery->queryAll();
	//	print_r($initialAmountResult);
		
		
		$query = "SELECT warehouse.id as id, warehouse.name as 'warehouse name', /*round(sum(event.totalSum),2) as 'Total Sum', */
			round(sum(sum_sign_by_eventtype(eventTypeid,  event.totalSum) ), 2) AS 'Total Sum new', 
				FROM `tarex_events` AS event
				LEFT JOIN `tarex_warehouse`  AS warehouse ON event.Subconto1 = warehouse.id 
				  `
				-- JOIN  `tarex_eventcontent`   as content    ON content.eventid =  event.id ---- неправильно даёт результат если добавить
				WHERE EventTypeId = 18 AND Subconto1 > 0
				AND event.Begin >  '2014-06-01 00:00:00'
				AND event.Begin < NOW() 
				GROUP BY Subconto1";
	// с помощью CDbCriteria мы формируем WHERE условие и привязку параметров, потом передаём это в CDbCommand				
		$criteria=new CDbCriteria; 
		$criteria->condition = 'Subconto1 > 0';
		$criteria->addCondition('StatusId = '. Events::STATUS_COMPLETED);
		   
	// фильтрация по типам событий если заданы   	
		if ($inputData['eventTypes']) 
		   $criteria->addInCondition('EventTypeId', $inputData['eventTypes']); 

	 /*  if ($inputData['eventTypesDebit']) 
		   $criteria->addInCondition('EventTypeId', $inputData['eventTypes']); 
		 */

		 
	// фильтрация по cкладам если заданы   	
		if ($inputData['warehouse']) 
			$criteria->addInCondition('Subconto1', $inputData['warehouse']);			
			
	// фильтрация по контрагентам если заданы   	
		if ($inputData['contractorIds']) 
			$criteria->addInCondition('contractorId', $inputData['contractorIds']); 
	
	// фильтрация по датам если заданы   	
		if ($inputData['dates']) {
			if ($inputData['dates']['begin']) 
				$criteria->addCondition("Begin >= '{$inputData['dates']['begin']}' ");  
			if ( !empty($inputData['dates']['end'])) 
				$criteria->addCondition("Begin <= '{$inputData['dates']['end']}' ");        
			else		
				$criteria->addCondition('Begin <= NOW() ');   
		}
			          
		// else 		$criteria->addCondition('Subconto1 > 0');	
			  
		$where=$criteria->condition; 
		$params=$criteria->params; 
			       
		$command = Yii::app()->db->createCommand();     
        $resultQuery = $command->select("COALESCE(warehouse.name, 'Total') AS 'WarehouseName',	
		     COALESCE(Subconto1, 'Total') AS 'Warehouse',		
			NULL as initSum,	
			round(sum(debit_sum(eventTypeid,  event.totalSum) ), 2) AS 'Debit', 			
			round(sum(credit_sum(eventTypeid,  event.totalSum) ), 2) AS 'Credit', 	round(sum(sum_sign_by_eventtype(eventTypeid,  event.totalSum) ), 2) AS 'TotalSumForPeriod'		
			")
        ->from('tarex_events AS event') 
        ->leftjoin('tarex_warehouse AS warehouse' , 'event.Subconto1 = warehouse.id')  
		->where($where, $params) 
		->group('(Subconto1) WITH ROLLUP');
		
	//	echo '<br><b>GROUPED QUERY: </b>"' , $resultQuery->text , '" ';		
	//	echo '<br><b>GROUPED QUERY params: </b>'; print_r($params);  
        $result = $resultQuery->queryAll();
		//echo '<br>'; print_r($result);
		
	// здесь мы добавляем начальные остатки только по номенклатуре
	    $criteria5 = new CDbCriteria();
		$criteria5->condition = 'Currency = "USD"';
		$criteria5->order = 'Begin DESC';
		$criteria5->limit = 1; 
		$rate = Exchangerates::model()->find($criteria5)->totalSum;
		$result[1]['initSum'] = $initialAmountResult[0]['cost_in_usd'] * $rate;
		$result[2]['initSum'] = $initialAmountResult[1]['cost_in_usd'] * $rate; 
		$result[3]['initSum'] = $initialAmountResult[2]['cost_in_usd'] * $rate;
		//return $result;
      	return new CArrayDataProvider($result, array());
	}    
	public function getImageIndex()
	{
		switch ($this->subgroup)
		{
			case 'ГИДРАВЛИЧЕСКАЯ СИСТЕМА': RETURN 1;
			case 'СИСТЕМА ОХЛАЖДЕНИЯ':         RETURN 2;
			case 'ОПТИКА':                                      RETURN 3;
			case 'ДЕТАЛИ КУЗОВА':                        RETURN 4;
			case 'СИСТЕМА ПОДВЕСКИ':	           RETURN 5;		
			case 'ТОПЛИВНАЯ СИСТЕМА':             RETURN 6;
			case 'ТОРМОЗНАЯ СИСТЕМА':            RETURN 7;
			case 'ХОДОВАЯ СИСТЕМА' :                RETURN 8;
//			КУЗОВ ОПТИКА ПОДВЕСКА СИСТЕМА ОХЛАЖДЕНИЯ СИСТЕМА ПОДВЕСКИ ТОРМОЗНАЯ СИСТЕМА ТРАНСМИСИЯ ХОДОВАЯ СИСТЕМА ЭЛЕКТРИКА		
		}	
	}
/*	public function fob($begin=null, $end=null) 
	{ 
		// подсчёт суммы проданной позиции (за интервал)
		// sales TYPE_SALE 
		$q='SELECT sum(cost) as costs 
		FROM `tarex_eventcontent` `t`    
		LEFT JOIN `tarex_events` as `e` ON t.eventId = e.id
		WHERE (t.assortmentId=' . $this->id . ') AND (e.Begin <= "' . $end . '" ) AND (e.EventTypeId=18)
		GROUP BY t.assortmentId';
		echo 'costs = '; echo Yii::app()->db->createCommand($q)->queryScalar();
		exit;
		$criteria= new CDbCriteria;
	 	$criteria->select = 'sum(cost) as costs';  
		$criteria->compare('assortmentId', $this->id ); // http://www.yiiframework.com/doc/api/1.1/CDbCriteria#compare-detail
	 	if ($begin) $criteria->addCondition('Begin >= "' . $begin . '" ');
	 	if ($end) $criteria->addCondition('Begin <= "' . $end . '" ');
		$criteria->compare('EventTypeId', Events::TYPE_SALE);  // продажа
		$criteria->group= 'assortmentId'; 
		
		echo 'costs = ' , $costs = EventContent::model()->with('event')->findAll($criteria); //->with('event');
		echo '<br>'; print_r($costs);
		foreach()
		$tableSchema = EventContent::model()->getTableSchema();
		$command = EventContent::model()->getCommandBuilder()->createFindCommand($tableSchema, $criteria);
		echo '<br><b> sql command = ', $command->text;
		//echo '<br>command params = ',  $command->params;
	}
*/ 
}
/*
SELECT event.id, eventType.name, event.totalSum, event.organizationId, 
round(sum(sum_sign_by_eventtype(eventTypeid,  event.totalSum) ), 2) AS 'TotalSumForPeriod'		
FROM  `tarex_eventcontent` as content
LEFT JOIN  `tarex_events`       as event ON eventid =   event.id
LEFT JOIN  `tarex_assortment`   as a     ON assortmentId =  a.id
LEFT JOIN  `tarex_eventtype`    as eventType  ON eventTypeid =   eventType.id
LEFT JOIN  `tarex_organization` as org   ON event.organizationId = org.id
WHERE Subconto1 > 0 
-- AND a.id = '<given assortment id>'
AND org.id = 7
GROUP BY Subconto1, event.id, content.cost WITH ROLLUP
*/