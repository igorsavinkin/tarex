<?php

class InventoryreportController extends Controller 
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	
	//public $layout='//layouts/FrontendLayoutPavel';
	
	public $InventoryEventTypes = array( 
	    Events::TYPE_SALE, // 18 - продажа
		Events::TYPE_SALES_RETURN, // or RETURN 28 - возврат
		Events::TYPE_ENTER_INITIAL_BALANCES_OF_GOODS, // 27 -- ввод начальных остатков
		Events::TYPE_PURCHASE, // 31 -- покупка (у поставщика)
		Events::TYPE_PURCHASE_RETURN, // 32  -- возврат (поставщику)
		Events::TYPE_TRANSFER, // 33	 -- перемещение
	);
	
	public $InventoryEventTypesDebit = array(  
		Events::TYPE_SALES_RETURN, // or RETURN 28 - возврат
		Events::TYPE_ENTER_INITIAL_BALANCES_OF_GOODS, // 27 -- ввод начальных остатков
		Events::TYPE_PURCHASE, // 31 -- покупка (у поставщика) 
		Events::TYPE_TRANSFER, // 33	 -- перемещение - тогда смотрим Subconto2
	);
	
	public $InventoryEventTypesCredit = array( 
	    Events::TYPE_SALE, // 18 - продажа   
		Events::TYPE_PURCHASE_RETURN, // 32  -- возврат (поставщику) 
	);
	
	public function loadModel($modelName,$criteria)
	{
		$model=$modelName::model()->findAll($criteria);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}	
	
	public function FOpeningBalances($modelName,$criteria)
	{
		$OpeningBalances=0;
		$model=$modelName::model()->findAll($criteria);
		if (!empty($model)){
			foreach ($model as $r){			
			//	if ($r->EventTypeId  in (24,19,20)){
				if ($r->EventTypeId==Events::TYPE_ENTER_INITIAL_FINANCIAL_BALANCES || 
					$r->EventTypeId==Events::TYPE_INFLOW_CASHLESS_MONEY || 
					$r->EventTypeId==Events::TYPE_CASH_IN_ORDER
					) //if ($r->EventTypeId==24 || $r->EventTypeId==19 || $r->EventTypeId==20){
				{				
					$OpeningBalances += $r->totalSum;					
				}else{
					$OpeningBalances -= $r->totalSum;					
				}
			
			}
		}
		return $OpeningBalances;
	}
	
	
	public function actionAdmin() 
	{
		$modelName='Events';	
		$model=new $modelName;	
		//echo 'Inventory Event Types = '; print_r($this->InventoryEventTypes); // массив объявленный в этом классе 
		if(isset($_POST[$modelName]))
		{
			$model->attributes = $_POST[$modelName];	 
						
			$criteria=new CDbCriteria(array(
				'condition'=>'EventTypeId IN (' . implode(', ', $this->InventoryEventTypes) . ') ',
				'order'=>'Begin ASC',
			)); 
		// условие по контрагенту
			if (!empty($model->contractorId)) $criteria->condition .= ' AND contractorId = '.$model->contractorId;
		// условие по складам		
			if (!empty($model->Subconto1)) $criteria->condition .= ' AND Subconto1 = '.$model->Subconto1;
			
			$UserRole = Yii::app()->user->role;
			$UserOrganization = Yii::app()->user->organization;
			if ($UserRole >= User::ROLE_DIRECTOR) 
				$criteria->condition .= " AND organizationId <= {$UserOrganization}";
			
			//Посчитаем начальные остатки
			$criteriaOpeningBalances=new CDbCriteria(array(
					'order'=>'Begin ASC',
				));
			if (isset($model->Begin)) {
				$criteriaOpeningBalances->condition = $criteria->condition . " AND Begin < '".$model->Begin."'";
				$criteria->condition .= " AND Begin >= '". $model->Begin."' ";
			}
			$OpeningBalances=$this->FOpeningBalances($modelName,$criteriaOpeningBalances);  
			
			if (isset($model->End)) 
				$criteria->condition .= " AND Begin <= '". $model->End . "' ";
 		
			//echo '<br>$criteria->condition = ', $criteria->condition;
			$modelRes=$this->loadModel($modelName,$criteria);	 
		}
		
		$this->render('admin',
			array('model'=>$model, 'modelRes'=>$modelRes, 'OpeningBalances'=>$OpeningBalances, 'dataProvider'=>$dataProvider) 	
		);	
	}
	public function actionWarehouse($id=null)
	{
		$warehouse = new Warehouse;
		if (isset($_POST['Warehouse']))
			$warehouse->attributes = $_POST['Warehouse'];
		$warehouse->id = $_POST['Warehouse']['id'];
		
		$event = new Events;		
		$event->eventTypes = $this->InventoryEventTypes; // массив значений
		
		if (isset($_POST['Events'])) {
			$event->attributes = $_POST['Events'];
			$event->eventTypes =  $_POST['Events']['EventTypeId'];
		}      
		
		
	// подготовка данных для отчёта	
		if ($id) 
			$assortment = Assortment::model()->findByPk($id);
		else 	
			$assortment = new Assortment;
				 
	/*	формируем индексы событий для подсчёта дебита и кредита */
		//echo 'eventTypes = '; print_r($event->eventTypes); 	 
		$eventTypesDebit = ($event->eventTypes) ? array_intersect($this->InventoryEventTypesDebit, $event->eventTypes) : $this->InventoryEventTypesDebit;
		//echo '<br>$eventTypesDebit = ';  print_r($eventTypesDebit);
		  
		$eventTypesCredit = ($event->eventTypes) ? array_intersect($this->InventoryEventTypesCredit, $event->eventTypes) : $this->InventoryEventTypesCredit;
		//echo '<br>$eventTypesCredit = '; print_r($eventTypesCredit);		
		
		$inputArr = array(
			'warehouse'=>$warehouse->id ? array($warehouse->id) : array(), 
			'eventTypes'=>$event->eventTypes ? $event->eventTypes : array(), 
			'eventTypesDebit'=>$eventTypesDebit  ? $eventTypesDebit  : array(), 
			'eventTypesCredit'=>$eventTypesCredit ? $eventTypesCredit : array(), 
			'assortmentIds'=>$id ? array($id) : array(), 
			'contractorIds'=> $event->contractorId ? array($event->contractorId) : array(), 
			'dates'=> array('begin'=>$event->Begin, 'end'=>$event->End), 
			'assortmentId'=>$_GET['id'],			
		);
	  //  echo 'input data ='; print_r($inputArr); echo '<br>';
		 
	// вычисление сгруппированного отчёта	
		if($_POST['bywarehouse'] OR $_POST['all']) 
			$arrayDataProviderGroup = $assortment->getGroupReport($inputArr);	//print_r($inputArr);	
	// вычисление  отчёта	по каждому 
		if($_POST['byassortment'] OR $_POST['all']) 
			$arrayDataProvider = $assortment->getReport($inputArr);	 
	// вычисление отчёта	по каждой позиции
		if($_POST['particular_assortment'] OR $_POST['all']) 
			$dataProviderAssortment  = $assortment->getAssortmentReport($inputArr); 
	 
		$this->render('warehouse', array(
			'event'=>$event, 
			'warehouse'=>$warehouse, 
			'dataProvider'=>$arrayDataProvider,
			'dataProviderGroup'=>$arrayDataProviderGroup,
			'dataProviderAssortment'=>$dataProviderAssortment,
		));
	}
}