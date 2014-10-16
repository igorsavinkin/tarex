<?php
/**
 * This is the model class for table "{{assortmentFake}}".
 *
 * The followings are the available columns in table '{{assortmentFake}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $organizationId
 * @property string $agroup
 * @property string $subgroup
 * @property string $title
 * @property string $measure_unit
 * @property integer $price
 * @property integer $discount
 * @property string $imageUrl
 * @property string $fileUrl
 * @property integer $isService
 * @property integer $depth
 * @property string $model
 * @property string $article
 * @property double $priceS
 * @property string $oem
 * @property string $manufacturer
 * @property integer $availability
 * @property string $country
 * @property string $make
 * @property integer $MinPart
 * @property integer $YearBegin
 * @property integer $YearEnd
 * @property string $Currency
 * @property string $Analogi
 */
class AssortmentFake extends CActiveRecord
{
	public function tableName()
	{
		return '{{assortmentfake}}';
	}
 
	public function rules()
	{
		 	return array(
			array('parent_id, organizationId, agroup, subgroup, title, measure_unit, price, discount, imageUrl, fileUrl, isService, depth, model, article, priceS, oem, manufacturer, availability, country, make, MinPart, YearBegin, YearEnd, Currency, Analogi', 'required'),
			array('parent_id, organizationId, price, discount, isService, depth, availability, MinPart, YearBegin, YearEnd, groupCategory', 'numerical', 'integerOnly'=>true),
			array('priceS', 'numerical'),
			array('agroup, subgroup, make', 'length', 'max'=>50),
			array('title, imageUrl, fileUrl', 'length', 'max'=>255),
			array('measure_unit', 'length', 'max'=>20),
			array('model, article, manufacturer, country, Currency', 'length', 'max'=>200), 
			array('id, parent_id, organizationId, agroup, subgroup, title, measure_unit, price, discount, imageUrl, fileUrl, isService, depth, model, article, priceS, oem, manufacturer, availability, country, make, MinPart, YearBegin, YearEnd, Currency, Analogi, groupCategory', 'safe', 'on'=>'search'),
		);
	}
  
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('general','номер'),
			'parent_id' => Yii::t('general','идентификатор родителя'),
			'organizationId' => Yii::t('general','идентификатор организации'),
			'agroup' => Yii::t('general','Agroup'),
			'subgroup' => Yii::t('general','Subgroup'),
			'groupCategory' => Yii::t('general','Category'),
			'title' => Yii::t('general','описание предмета'),
			'measure_unit' => Yii::t('general','Measure Unit'),
			'price' => Yii::t('general','Price'),
			'discount' => Yii::t('general','Discount'),
			'imageUrl' => Yii::t('general','локатор (ссылка) на изображение к этому наименованию'),
			'fileUrl' => Yii::t('general','локатор на файл к этому наименованию'),
			'isService' => Yii::t('general','это наименование - услуга'),
			'depth' => Yii::t('general','глубина вложенности группы'),
			'model' => Yii::t('general','Model'),
			'article' => Yii::t('general','Article'),
			'priceS' => Yii::t('general','Price S'),
			'oem' => Yii::t('general','Oem'),
			'manufacturer' => Yii::t('general','Manufacturer'),
			'availability' => Yii::t('general','Availability'),
			'country' => Yii::t('general','Country'),
			'make' => Yii::t('general','марка машины'),
			'MinPart' => Yii::t('general','Min Part'),
			'YearBegin' => Yii::t('general','Year Begin'),
			'YearEnd' => Yii::t('general','Year End'),
			'Currency' => Yii::t('general','Currency'),
			'Analogi' => Yii::t('general','Analogi'),
		);
	}
 
	public function search()
	{
	 	$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('organizationId',$this->organizationId);
		$criteria->compare('agroup',$this->agroup,true);
		$criteria->compare('subgroup',$this->subgroup,true);
		$criteria->compare('groupCategory',$this->groupCategory);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('measure_unit',$this->measure_unit,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('imageUrl',$this->imageUrl,true);
		$criteria->compare('fileUrl',$this->fileUrl,true);
		$criteria->compare('isService',$this->isService);
		$criteria->compare('depth',$this->depth);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('article',$this->article,true);
		$criteria->compare('priceS',$this->priceS);
		$criteria->compare('oem',$this->oem,true);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('availability',$this->availability);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('make',$this->make,true);
		$criteria->compare('MinPart',$this->MinPart);
		$criteria->compare('YearBegin',$this->YearBegin);
		$criteria->compare('YearEnd',$this->YearEnd);
		$criteria->compare('Currency',$this->Currency,true);
		$criteria->compare('Analogi',$this->Analogi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getCurrentPrice() // возвращаем текущую цену исходя из последней настройки в документе Установка цен (Exchangerates)  
	    // не учитывает скидку клиента 
	{ 
		$criteria = new CDbCriteria;
		$criteria->order = 'Begin DESC';
		$criteria->condition = 'Currency = "USD" '; 
		$org = Yii::app()->user->isGuest ?  '7' : Yii::app()->user->organization;  // для гостей (Yii::app()->user->isGuest) мы выводим цену для компании 7
		$criteria->addCondition('organizationId = ' . $org );
		
		$rate = Exchangerates::model()->find($criteria); // находим одну последнюю по времени (Begin DESC).		
		
		return $rate->totalSum * $this->priceS;  //echo ''.$rate->totalSum.'/'.$this->priceS.'/'.;
	}
	public function getPrice(){ // учитывает скидку клиента (залогиненного) И скидку исходя из настроек ценнообразования Pricing		 
		$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), Yii::app()->user->id );	
		$discount = $discountNew ? $discountNew : User::model()->findByPk(Yii::app()->user->id)->discount;  		 
		if (empty($discount)) $discount = 0; 		
		return round($this->getCurrentPrice() * (1 + $discount/100), 2);		
    }
	
	public function getPrice2($Id){ // учитывает скидку клиента (залогиненного) И скидку исходя из настроек ценнообразования Pricing
		//echo 'Id '.$Id;
		//return;		
		if ($Id==''){
			$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), Yii::app()->user->id );	
			$discount = $discountNew ? $discountNew : User::model()->findByPk(Yii::app()->user->id)->discount;  		
		}else{
			$discountNew = $this->countDiscount( date("Y-m-d H:i:s"), $Id );	
			$discount = $discountNew ? $discountNew : User::model()->findByPk($Id)->discount;  	
			//echo 'discount /'.$discount.'/discountNew/'.$discountNew;//return;			
		}		
		if (empty($discount)) $discount = 0;  	//echo 'discount /'.$discount.'/';    		
		return round($this->getCurrentPrice() * (1 + $discount/100), 2);
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
	
}