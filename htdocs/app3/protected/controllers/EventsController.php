<?php

class EventsController extends Controller
{
	 public function filters()
	 { 
		 return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request 
		);
	}

	public function accessRules()
	{
		return array( 
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'denisTpl', 'clone2', 'create2', 'test3', 'test1'), 
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'update2', 'PrintSF', 'PrintOrder', 'PrintSchet', 'PrintLabels', 'PrintPPL', 'PrintPPL2', 'LoadContent', 'loadContent', 'clone', 'bulkActions'),
				'users'=>array('@'),  
			), 
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('@'),   
			), 
			array('allow', 
				'actions'=>array('update'), 
				//	'users'=>array('@'),  
				'expression'=>array($this, 'UpdateEvent'),
			),
			array('allow',  
				'actions'=>array('delete'), 
				'roles'=>array(User::ROLE_ADMIN),  
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} 
	public function actionBulkActions()
	{ 
		// print_r($_POST);
		if ($_GET['name'] == 'delete-bulk') {			
			Events::model()->deleteByPk($_POST['itemId']); 
		} 
	}
	
	 
	public function actionClone()
	{  
		$oldEvent = $this->loadModel($_POST['id']);
		$newEvent = $oldEvent->cloneEvent($_POST['newEventTypeId']);
		$this->redirect( array(  strtolower($newEvent->EventType->Reference)  . '/update' , 'id'=>$newEvent->id , 'Subsystem'=> 'Warehouse automation', 'Reference'=>$newEvent->EventType->Reference ));  
	}
	public function actionCreate()
	{ 
		$model=new Events;	
		$model->Begin = date('Y-m-d H-i-s');
		$model->organizationId = Yii::app()->user->organization;  
		$model->authorId = Yii::app()->user->id;
		if (Yii::app()->user->role > 5)  
			$model->contractorId = $model->authorId; 
		// находим тип создаваемого события по $_GET['Reference'] 
		$model->EventTypeId = Eventtype::model()->findByAttributes(array('Reference'=>Yii::app()->controller->id))->id;	
		
		$model->Reference =  Yii::app()->controller->id;		 
		$model->StatusId  = Events::STATUS_NEW;  
		$model->save();  
		// переходим на действие update с только что сохранённым заказом
		$this->redirect(array('update', 'id'=>$model->id));
	}	 
 
 
 
 public function actionPrintPPL($id)
	{ 
		/* Include PHPExcel */
		$DocEvent=Events::model()->findByPk($id);
	//	$organization=Organization::model()->findByPk($DocEvent->organizationId);			
		$organization=User::model()->findByPk($DocEvent->authorId); 
		if (empty($organization)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you as user are not registered with any organization.')); 
			$this->redirect( array('update','id'=>$id));
		}	
		$contactor=Contractor::model()->findByPk($DocEvent->contractorId);
		if (empty($contactor)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you have not defined any contractor for this order. Turn to field "Contractor" and save the order.')); 
			$this->redirect( array('update','id'=>$id));
		}	
		 
		$DocEventContentA=Array();
		$DocEventContent=EventContent::model()->findAllByAttributes(array('eventId'=>$DocEvent->id));
		$DocEventContent=EventContent::model()->findAllByAttributes(array('eventId'=>$DocEvent->id));
		if (!empty($DocEventContent)) {
			foreach( $DocEventContent as $r)
			{
				$Ass=Assortment::model()->FindByPk($r->assortmentId);
				//echo $Ass->id; 
				
				$DocEventContentA[]=$Ass->title.'; '.$Ass-> price.'; '.$r-> assortmentAmount;
			}		
		}
		else{ // если нет содержимого заказа 
		    Yii::app()->user->setFlash('error', Yii::t('general', 'There is no content in the order to print in invoice.')); 
			$this->redirect( array('update','id'=>$id));		//return;		
		}
			 	
		//spl_autoload_unregister(array('YiiBase','autoload'));        
		require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';
	
		//echo $id;
		
		// Create new PHPExcel object
		//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
		//$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');//'Excel2007'
		$filename='Счет-фактура.xlsx';
		$objPHPExcel = $objReader->load("files/Shablon1.xlsx"); // БланкОтчета.xlsx
		$as = $objPHPExcel->getActiveSheet();
		//$column = 'A1';
		
		$DateY=Substr($DocEvent->Begin,0,4);
		$DateM=Substr($DocEvent->Begin,5,2);
		$DateD=Substr($DocEvent->Begin,8,2);
		
		
		if($DateM=='01') {$month1='января';  $month2='ЯНВАРЬ';}
		if($DateM=='02') {$month1='февраля';  $month2='ФЕВРАЛЬ';}
		if($DateM=='03') {$month1='марта';  $month2='МАРТ';}
		if($DateM=='04') {$month1='апреля';  $month2='АПРЕЛЬ';}
		if($DateM=='05') {$month1='мая';  $month2='МАЙ';}
		if($DateM=='06') {$month1='июня';  $month2='ИЮНЬ';}
		if($DateM=='07') {$month1='июля';  $month2='ИЮЛЬ';}
		if($DateM=='08') {$month1='августа';  $month2='АВГУСТ';}
		if($DateM=='09') {$month1='сентября';  $month2='СЕНТЯБРЬ';}
		if($DateM=='10') {$month1='октября';  $month2='ОКТЯБРЬ';}
		if($DateM=='11') {$month1='ноября';  $month2='НОЯБРЬ';}
		if($DateM=='12') {$month1='декабря';  $month2='ДЕКАБРЬ';}

		

		$as->getCell('B2')->setValue('Счет-фактура № '.$id.' от '.$DateD.' '.$month1.' '.$DateY.' г.');
		
		$as->getCell('B4')->setValue('Продавец: '.$organization->name);
		$as->getCell('B5')->setValue('Адрес: '.$organization->address);
		$as->getCell('B6')->setValue('ИНН/КПП продавца: '.$organization->inn.'/'.$organization->kpp);
		
		$as->getCell('B8')->setValue('Грузополучатель и его адрес: '.$contactor->name.', '.$contactor->address);
		$as->getCell('B10')->setValue('Покупатель: '.$contactor->name);
		$as->getCell('B11')->setValue('Адрес: '.$contactor->address);
		$as->getCell('B12')->setValue('ИНН/КПП покупателя: '.$contactor->inn.'/'.$contactor->kpp);

		//$row=18; $Itogo=0; $ItogoNds=0; $ItogoBND=0; 
		$iterator=17; $Itogo-0; $ItogoBND=0; $ItogoNDS=0;
			foreach( $DocEventContentA as $r)
			{
				//echo $r ;
				$Arr=explode (";",$r);
			
			 if ($iterator>17) {	 
					//echo 
					$as->insertNewRowBefore($iterator, 1); 
					$as->MergeCells('B'.$iterator.':C'.$iterator); $as->MergeCells('D'.$iterator.':E'.$iterator); 
					$as->MergeCells('F'.$iterator.':H'.$iterator);
					$as->MergeCells('I'.$iterator.':J'.$iterator);  $as->MergeCells('K'.$iterator.':L'.$iterator.'');
					$as->MergeCells('M'.$iterator.':O'.$iterator.''); $as->MergeCells('P'.$iterator.':Q'.$iterator.''); 
					$as->MergeCells('S'.$iterator.':V'.$iterator.''); $as->MergeCells('W'.$iterator.':X'.$iterator.'');
					$as->getCell('D'.$iterator.'')->setValue($as->getCell('D17')->getValue());
					$as->getCell('F'.$iterator.'')->setValue($as->getCell('F17')->getValue());
					$as->getCell('P'.$iterator.'')->setValue($as->getCell('P17')->getValue());
					$as->getCell('R'.$iterator.'')->setValue($as->getCell('R17')->getValue());
					$as->getCell('Y'.$iterator.'')->setValue($as->getCell('Y17')->getValue());				
					$as->getCell('X'.$iterator.'')->setValue($as->getCell('X17')->getValue());
					$as->getCell('Z'.$iterator.'')->setValue($as->getCell('Z17')->getValue());
					$as->getCell('AA'.$iterator.'')->setValue($as->getCell('AA17')->getValue());
			 }
				
				$Count=$Arr[2];
				$Summ=$Arr[2]*$Arr[1];
				$Nds=$Summ-$Summ/118*100;
				$BezNds=$Summ-$Nds;
				if ($Count!=0)	{$PriceBNds=$BezNds/$Count; }else {$PriceBNds; }

				//количество и цена
			    $as->getCell('B'.$iterator)->setValue($Arr[0] );
  			    $as->getCell('I'.$iterator)->setValue ( number_format($Count,3,',',' ')   );
			    $as->getCell('K'.$iterator)->setValue(number_format($PriceBNds,2,',',' ') );
				
				$as->getCell('M'.$iterator)->setValue(number_format($BezNds,2,',',' ') );
				$as->getCell('S'.$iterator)->setValue(number_format($Nds,2,',',' ')   );
				$as->getCell('W'.$iterator)->setValue(number_format($Summ,2,',',' '));
				
				
				$Itogo+=$Summ;
				$ItogoBND+=$BezNds;
				$ItogoNDS+=$Nds;
				
				
				$iterator++;
			}
		
		//Итоги
			$as->getCell('M'.$iterator)->setValue(number_format($ItogoBND,2,',',' '));
			$as->getCell('S'.$iterator)->setValue(number_format($ItogoNDS,2,',',' '));
			$as->getCell('W'.$iterator)->setValue(number_format($Itogo,2,',',' '));
		
		
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');  
		$objWriter->save('php://output');  	
	
		
	}
	
	
	
	public function actionPrintSF($id)
	{  
	/* Include PHPExcel */
		$DocEvent=Events::model()->findByPk($id);
	//	$organization=Organization::model()->findByPk($DocEvent->organizationId);			
		$organization=User::model()->findByPk($DocEvent->authorId); 
		if (empty($organization)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you as user are not registered with any organization.')); 
			$this->redirect( array('update','id'=>$id));
		}	
		$contactor=Contractor::model()->findByPk($DocEvent->contractorId);
		if (empty($contactor)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you have not defined any contractor for this order. Turn to field "Contractor" and save the order.')); 
			$this->redirect( array('update','id'=>$id));
		}	
		 
		$DocEventContentA=Array();
		$DocEventContent=EventContent::model()->findAllByAttributes(array('eventId'=>$DocEvent->id));
		$DocEventContent=EventContent::model()->findAllByAttributes(array('eventId'=>$DocEvent->id));
		if (!empty($DocEventContent)) {
			foreach( $DocEventContent as $r)
			{
				$Ass=Assortment::model()->FindByPk($r->assortmentId);
				//echo $Ass->id; 
				
				$DocEventContentA[]=$Ass->title.'; '.$Ass-> price.'; '.$r-> assortmentAmount;
			}		
		}
		else{ // если нет содержимого заказа 
		    Yii::app()->user->setFlash('error', Yii::t('general', 'There is no content in the order to print in invoice.')); 
			$this->redirect( array('update','id'=>$id));		//return;		
		}
			 	
		//spl_autoload_unregister(array('YiiBase','autoload'));        
		require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';
	
		//echo $id;
		
		// Create new PHPExcel object
		//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
		//$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');//'Excel2007'
		$filename='Счет-фактура.xlsx';
		$objPHPExcel = $objReader->load("files/Shablon1.xlsx"); // БланкОтчета.xlsx
		$as = $objPHPExcel->getActiveSheet();
		//$column = 'A1';
		
		$DateY=Substr($DocEvent->Begin,0,4);
		$DateM=Substr($DocEvent->Begin,5,2);
		$DateD=Substr($DocEvent->Begin,8,2);
		
		
		if($DateM=='01') {$month1='января';  $month2='ЯНВАРЬ';}
		if($DateM=='02') {$month1='февраля';  $month2='ФЕВРАЛЬ';}
		if($DateM=='03') {$month1='марта';  $month2='МАРТ';}
		if($DateM=='04') {$month1='апреля';  $month2='АПРЕЛЬ';}
		if($DateM=='05') {$month1='мая';  $month2='МАЙ';}
		if($DateM=='06') {$month1='июня';  $month2='ИЮНЬ';}
		if($DateM=='07') {$month1='июля';  $month2='ИЮЛЬ';}
		if($DateM=='08') {$month1='августа';  $month2='АВГУСТ';}
		if($DateM=='09') {$month1='сентября';  $month2='СЕНТЯБРЬ';}
		if($DateM=='10') {$month1='октября';  $month2='ОКТЯБРЬ';}
		if($DateM=='11') {$month1='ноября';  $month2='НОЯБРЬ';}
		if($DateM=='12') {$month1='декабря';  $month2='ДЕКАБРЬ';}

		

		$as->getCell('B2')->setValue('Счет-фактура № '.$id.' от '.$DateD.' '.$month1.' '.$DateY.' г.');
		
		$as->getCell('B4')->setValue('Продавец: '.$organization->name);
		$as->getCell('B5')->setValue('Адрес: '.$organization->address);
		$as->getCell('B6')->setValue('ИНН/КПП продавца: '.$organization->inn.'/'.$organization->kpp);
		
		$as->getCell('B8')->setValue('Грузополучатель и его адрес: '.$contactor->name.', '.$contactor->address);
		$as->getCell('B10')->setValue('Покупатель: '.$contactor->name);
		$as->getCell('B11')->setValue('Адрес: '.$contactor->address);
		$as->getCell('B12')->setValue('ИНН/КПП покупателя: '.$contactor->inn.'/'.$contactor->kpp);

		//$row=18; $Itogo=0; $ItogoNds=0; $ItogoBND=0; 
		$iterator=17; $Itogo-0; $ItogoBND=0; $ItogoNDS=0;
			foreach( $DocEventContentA as $r)
			{
				//echo $r ;
				$Arr=explode (";",$r);
			
			 if ($iterator>17) {	 
					//echo 
					$as->insertNewRowBefore($iterator, 1); 
					$as->MergeCells('B'.$iterator.':C'.$iterator); $as->MergeCells('D'.$iterator.':E'.$iterator); 
					$as->MergeCells('F'.$iterator.':H'.$iterator);
					$as->MergeCells('I'.$iterator.':J'.$iterator);  $as->MergeCells('K'.$iterator.':L'.$iterator.'');
					$as->MergeCells('M'.$iterator.':O'.$iterator.''); $as->MergeCells('P'.$iterator.':Q'.$iterator.''); 
					$as->MergeCells('S'.$iterator.':V'.$iterator.''); $as->MergeCells('W'.$iterator.':X'.$iterator.'');
					$as->getCell('D'.$iterator.'')->setValue($as->getCell('D17')->getValue());
					$as->getCell('F'.$iterator.'')->setValue($as->getCell('F17')->getValue());
					$as->getCell('P'.$iterator.'')->setValue($as->getCell('P17')->getValue());
					$as->getCell('R'.$iterator.'')->setValue($as->getCell('R17')->getValue());
					$as->getCell('Y'.$iterator.'')->setValue($as->getCell('Y17')->getValue());				
					$as->getCell('X'.$iterator.'')->setValue($as->getCell('X17')->getValue());
					$as->getCell('Z'.$iterator.'')->setValue($as->getCell('Z17')->getValue());
					$as->getCell('AA'.$iterator.'')->setValue($as->getCell('AA17')->getValue());
			 }
				
				$Count=$Arr[2];
				$Summ=$Arr[2]*$Arr[1];
				$Nds=$Summ-$Summ/118*100;
				$BezNds=$Summ-$Nds;
				if ($Count!=0)	{$PriceBNds=$BezNds/$Count; }else {$PriceBNds; }

				//количество и цена
			    $as->getCell('B'.$iterator)->setValue($Arr[0] );
  			    $as->getCell('I'.$iterator)->setValue ( number_format($Count,3,',',' ')   );
			    $as->getCell('K'.$iterator)->setValue(number_format($PriceBNds,2,',',' ') );
				
				$as->getCell('M'.$iterator)->setValue(number_format($BezNds,2,',',' ') );
				$as->getCell('S'.$iterator)->setValue(number_format($Nds,2,',',' ')   );
				$as->getCell('W'.$iterator)->setValue(number_format($Summ,2,',',' '));
				
				
				$Itogo+=$Summ;
				$ItogoBND+=$BezNds;
				$ItogoNDS+=$Nds;
				
				
				$iterator++;
			}
		
		//Итоги
			$as->getCell('M'.$iterator)->setValue(number_format($ItogoBND,2,',',' '));
			$as->getCell('S'.$iterator)->setValue(number_format($ItogoNDS,2,',',' '));
			$as->getCell('W'.$iterator)->setValue(number_format($Itogo,2,',',' '));
		
		
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');  
		$objWriter->save('php://output');  	
	
	}
	
	
	public function actionPrintOrder($id)
	{  
		/* Include PHPExcel */
		$DocEvent=Events::model()->findByPk($id);
	/*	$organization=Organization::model()->findByPk($DocEvent->organizationId);			
		if (empty($organization)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you as user are not registered with any organization.')); 
			$this->redirect( array('update','id'=>$id));
		}	
		$contactor=Contractor::model()->findByPk($DocEvent->contractorId);
		if (empty($contactor)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you have not defined any contractor for this order. Turn to field "Contractor" and save the order.')); 
			$this->redirect( array('update','id'=>$id));
		}	*/
		 
		$DocEventContentA=Array();
		$DocEventContent=EventContent::model()->findAllByAttributes(array('eventId'=>$DocEvent->id));
		if (!empty($DocEventContent)) {
			foreach( $DocEventContent as $r)
			{
				$Ass=Assortment::model()->FindByPk($r->assortmentId);
				//echo $Ass->id;
				
				$DocEventContentA[]= $Ass->title.'; '.  // Arr[0]   Наименование,
					$Ass->price . '; ' .  						   // Arr[1]   Цена
					$r->assortmentAmount . ';' . 			   // Arr[2]   Количество
					$Ass->article . '; ' . 				 		   // Arr[3]   Артикул
					round( ( $Ass->price * $r->assortmentAmount ) * ( 100 - $r->discount) / 100 , 2);   // Arr[4]  сумма cо скидкой
				//  
				// echo  '<br>discount = ', $r->discount;
			}		
		}

		else{ // если нет содержимого заказа 
		    Yii::app()->user->setFlash('error', Yii::t('general', 'There is no content in the order to print in invoice.')); 
			$this->redirect( array('update','id'=>$id));		//return;		
		}
			 		
		//exit;	
		spl_autoload_unregister(array('YiiBase','autoload'));        
		require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';
		
		// Create new PHPExcel object
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');//'Excel2007'
		
		$objPHPExcel = $objReader->load("files/OrderTemplate.xlsx"); // 
		$as = $objPHPExcel->getActiveSheet();
		
		$DateY=Substr($DocEvent->Begin,0,4);
		$DateM=Substr($DocEvent->Begin,5,2);
		$DateD=Substr($DocEvent->Begin,8,2);
		
		
		if($DateM=='01') {$month1='января';  $month2='ЯНВАРЬ';}
		if($DateM=='02') {$month1='февраля';  $month2='ФЕВРАЛЬ';}
		if($DateM=='03') {$month1='марта';  $month2='МАРТ';}
		if($DateM=='04') {$month1='апреля';  $month2='АПРЕЛЬ';}
		if($DateM=='05') {$month1='мая';  $month2='МАЙ';}
		if($DateM=='06') {$month1='июня';  $month2='ИЮНЬ';}
		if($DateM=='07') {$month1='июля';  $month2='ИЮЛЬ';}
		if($DateM=='08') {$month1='августа';  $month2='АВГУСТ';}
		if($DateM=='09') {$month1='сентября';  $month2='СЕНТЯБРЬ';}
		if($DateM=='10') {$month1='октября';  $month2='ОКТЯБРЬ';}
		if($DateM=='11') {$month1='ноября';  $month2='НОЯБРЬ';}
		if($DateM=='12') {$month1='декабря';  $month2='ДЕКАБРЬ';}

		

		$as->getCell('B2')->setValue('ЗАКАЗ № '.$id.' от '.$DateD.' '.$month1.' '.$DateY.' г.');
		
		
		$as->getCell('B4')->setValue('Покупатель: '.$contactor->name);
		$as->getCell('B5')->setValue('Адрес: '.$contactor->address);
		$as->getCell('B6')->setValue('ИНН/КПП покупателя: '.$contactor->inn.'/'.$contactor->kpp);

		//$row=18; $Itogo=0; $ItogoNds=0; $ItogoBND=0; 
		$iterator=10; $Itogo=0; $ItogoBND=0; $ItogoNDS=0;
			foreach($DocEventContentA as $r)
			{
				//echo $r ;
				 $Arr=explode (";",$r);
				$Count=$Arr[2];
				$Summ=$Arr[4]; //$Arr[2]*$Arr[1] ;
				if($Count!=0) 
				{
					$Price=round($Summ/$Count,2);
				}else $Price=0;

				
				 if ($iterator>10) 
				 {	  			 
					$as->insertNewRowBefore($iterator, 1);
					$iterator1=$iterator-1;
					
					$as->MergeCells('C'.$iterator.':D'.$iterator); 
					$as->MergeCells('E'.$iterator.':F'.$iterator); 
					$as->MergeCells('G'.$iterator.':I'.$iterator);
					$as->MergeCells('J'.$iterator.':K'.$iterator);  
					$as->MergeCells('L'.$iterator.':M'.$iterator.'');
					$as->MergeCells('N'.$iterator.':O'.$iterator.''); 
					
					$as->getCell('B'.$iterator)->setValue($Arr[3] ); //Артикул
					$as->getCell('C'.$iterator)->setValue($Arr[0] ); //Наименование
				
				//	$as->getCell('L'.$iterator.'')->setValue($as->getCell('L'.$iterator1)->getValue());

					$as->getCell('J'.$iterator)->setValue ( number_format($Count,3,',',' ')   ); //Кол-во
					$as->getCell('L'.$iterator)->setValue(number_format($Price ,2,',',' ') ); //Цена
					$as->getCell('N'.$iterator)->setValue(number_format($Summ,2,',',' '));//Сумма
					
					$as->getCell('E'.$iterator.'')->setValue($as->getCell('E'.$iterator1)->getValue());
					$as->getCell('G'.$iterator.'')->setValue($as->getCell('G'.$iterator1)->getValue());
		
				
				 }
 
				

				
				$Nds=$Summ-$Summ/118*100;
				$BezNds=$Summ-$Nds;
				if ($Count!=0)	{ $PriceBNds=$BezNds/$Count; } else { $PriceBNds; }


			    $as->getCell('B'.$iterator)->setValue($Arr[3] ); //Артикул
			    $as->getCell('C'.$iterator)->setValue($Arr[0] ); //Наименование
				
  			    $as->getCell('J'.$iterator)->setValue ( number_format($Count,3,',',' ')   ); //Кол-во
	 	        $as->getCell('L'.$iterator)->setValue(number_format($Price ,2,',',' ') ); //Цена
				$as->getCell('N'.$iterator)->setValue(number_format($Summ,2,',',' '));//Сумма

				
				
				$Itogo+=$Summ;
				$ItogoBND+=$BezNds;
				$ItogoNDS+=$Nds;
				
				
				$iterator++;
			}
		
		//Итоги
		//	$as->getCell('M'.$iterator)->setValue(number_format($ItogoBND,2,',',' '));
		//	$as->getCell('S'.$iterator)->setValue(number_format($ItogoNDS,2,',',' '));
			$as->getCell('N'.$iterator)->setValue(number_format($Itogo,2,',',' '));
		
		
		$filename="Заказ_№{$id}_от_{$DateD}{$month1}{$DateY}.xlsx";
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');  
		$objWriter->save('php://output');  	
	
	}
 	 
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id); 
		if(isset($_POST['Events']))
		{
			$oldStatus = $model->StatusId;
			$model->attributes = $_POST['Events'];
			// при сохранении события выходим из "нового" статуса и переводим его в статус "в работе" 
			if ($model->StatusId == Events::STATUS_NEW) 
				$model->StatusId = Events::STATUS_IN_WORK; 	
			
			switch (mb_strtolower(Yii::app()->controller->id))
			{ 
				case 'recruitement': // для приёма на работу
					if ($model->StatusId == Events::STATUS_COMPLETED  && (Events::STATUS_COMPLETED != $oldStatus) ) 
					{
						$newEmployee = User::loadModel($model->contractorId);
						$newEmployee->isEmployee = 1;
						print_r($newEmployee);
						if ($newEmployee->save(false))
							Yii::app()->user->setFlash('success', Yii::t('general','The system user') . ' <b>' . $newEmployee->username . '</b> ' . Yii::t('general','has been hired to your company') . '.');
					}
					break;
			}
				
			if($model->save() && $_POST['ok']) 
				$this->redirect(array('admin', 'Reference'=>$_POST['Events']['Reference']));
		}
		
		if(!empty($_GET['StatusId'])  ){
				$model->StatusId=$_GET['StatusId'];
				if($model->save()) 
					$this->redirect(array('admin', 'Reference'=>$app->session['Reference']));
		}		
			
		$assortment=new Assortment('search');
		$assortment->unsetAttributes();  // clear any default values
		if(isset($_GET['Assortment'])) {					
			$assortment->attributes=$_GET['Assortment'];
		} 		 
		
// если что-то из ассортимента добавляется в событие
		if (isset($_POST['add-to-event']) && isset($_POST['Assortment']))
		{
			$item = Assortment::model()->findByPk($_POST['Assortment']['id']);
			// $model; // текущее событие
			$eventContent = EventContent::model()->findByAttributes(array('eventId'=>$id, 'assortmentTitle'=> $item->title));
			if ($eventContent){ 
		// редактируем данный  EventContent
				$eventContent->assortmentAmount += $_POST['Assortment']['amount'];
			}
			else { 
		// создаём новый EventContent 
				$eventContent = new EventContent;
				$eventContent->assortmentTitle = $item->title;
				$eventContent->eventId = $id;
				$eventContent->assortmentId = $_POST['Assortment']['id'];				
				$eventContent->assortmentAmount = $_POST['Assortment']['amount'];				
			}
			$eventContent->price = $item->currentPrice;	 // заносим текущую (новую по сравнению с тем что было) цену (см. getCurrentPrice() в модели Assortment )	
			// считаем новые стоимость и стоимость со скидкой 
			$eventContent->cost = $eventContent->price * $eventContent->assortmentAmount;
			$discount = User::model()->findByPk($model->contractorId)->discount;
			$eventContent->cost_w_discount = round($eventContent->cost * (100 - $discount) / 100);	
			// потом сохраняем его
			if ($eventContent->save(false)) { 				
				$model->totalSum = EventContent::getTotalSumByEvent($id);
				$model->save(); 
				Yii::app()->user->setFlash('success', Yii::t('general', "The new item"). ' <b>' . $eventContent->assortmentTitle . '</b> ' . Yii::t('general', "has been added to the event") . '.');
				}
			else 
				Yii::app()->user->setFlash('error', Yii::t('general', "Failure to add the item"). ' <b>' . $eventContent->assortmentTitle . '</b> ' . Yii::t('general', " to the event") . '.');
			 
			// здесь мы делаем GET-redirect чтобы избежать повторного сохранения POST-параметров если пользователь перезагрузит браузер
			$this->redirect( array( 'update' , 'id'=>$id , '#' => 'tab2' )); 
		}			
		
		$this->render('update' , array(
			'model'=>$model, 'assortment'=>$assortment 
		));
	} 
 
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	public function actionLoadContent()
	{  
		$eventId=$_POST['Events']['id'];
		$model=$this->loadModel($eventId);  
		
		if (Yii::app()->user->role<=5)
		{ 			
			$ShablonId=User::model()->findbypk(Yii::app()->user->id)->ShablonId;
			if ($ShablonId!=0)
			{
				$LoadDataSettings=LoadDataSettings::model()->findByPk($ShablonId); 
			}
		}
					
		$LoadDataSettings=LoadDataSettings::model()->findByPk($_POST['LoadDataSettingsID']); 
		
	    //print_r($LoadDataSettings);
		$СolumnNumber =  $LoadDataSettings->ColumnNumber;  
		$ListNumber= $LoadDataSettings->ListNumber;		
		$AmountColumnNumber= $LoadDataSettings->AmountColumnNumber;
		$PriceColumnNumber= $LoadDataSettings->PriceColumnNumber;
		
		$criteria=new CDbCriteria;
		$criteria->condition='Begin <= :Begin AND Currency="USD"';
		$criteria->order='Begin ASC';
		$criteria->params=array('Begin'=>$model->Begin);
		$Rate=Exchangerates::model()->findall($criteria);
		//print_r($Rate);
		foreach ($Rate as $r){
			$CurrentRate=$r->totalSum;
		}
		
		$Discount=0;
		$Discount=User::model()->findByPk($model->contractorId)->discount;
		
		//echo $CurrentRate;
				
		//$upfile = $_POST['FileUpload1'];	
		$upfile = CUploadedFile::getInstance('FileUpload1', 0);	
		//if (isset($_POST['add-to-event']) && isset($_POST['Assortment']))
		$Order=new Events;
		//$upfile = CUploadedFile::getInstance('FileUpload1', 0);		
		//if (isset( $_POST['FileUpload1'])) { 
		//print_r($upfile);
		if ($upfile) { 
			//echo 'FileUpload1 '.$_POST['FileUpload1'];
			//$Order->attributes=$_POST['Item'];
            $Order->file=$upfile;
			//print_r($Order->file->name);
			if (strstr($Order->file->name, 'xlsx')){
				$Order->file->saveAs('files/temp.xlsx');
				$file='files/temp.xlsx';
				$type='Excel2007';	
			}else{
				$Order->file->saveAs('files/temp.xls');
				$type='Excel5';	
				$file='files/temp.xls';
			}
			
			require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';
				
			//$type=''	
				 
			$objReader = PHPExcel_IOFactory::createReader($type);
			$objPHPExcel = $objReader->load($file); 
			$as = $objPHPExcel->setActiveSheetIndex( $ListNumber - 1 );	
			
			$highestRow = $as->getHighestRow();
			$error = '';
			for ($startRow = 1; $startRow <= $highestRow; $startRow ++) 
			{
			
				$SearchString=$as->getCell($СolumnNumber . $startRow)->getValue(); 
				$Amount=$as->getCell($AmountColumnNumber . $startRow)->getValue(); 
				$Price=$as->getCell($PriceColumnNumber . $startRow)->getValue(); 
				$criteria = new CDbCriteria;
			
				//echo '/'.$SearchString.'/<br>';
				if ($SearchString=='')  continue;
				
				$criteria->params = array(':value'=>$SearchString);
				$criteria->condition = 'title = :value OR oem = :value OR article = :value';
				$Assortment=Assortment::model()->find($criteria); 
				
				if($Assortment==null) {$error .= Yii::t('general','Row #') . $startRow . '. ' .  Yii::t('general','Could not find assortment item on ') . $ColumnSearch. ' = "'. $SearchString . '"<br />'; 
				} 
				else {
					//echo 'found';
					
					// добавляем в содержимое заказа
					$EventContent=EventContent::model()->find(array(
						'condition'=>'eventId =:eventId AND assortmentId=:assortmentId',
						'params'=>array(':eventId' =>$eventId, ':assortmentId'=>$Assortment->id)
					));
					if (!empty($EventContent)) {
			//Добавляем кол-во в заказ
						//echo 'assortmentAmount '.$EventContent->assortmentAmount.'/'.$Amount;
						$OldAmount=$EventContent->assortmentAmount;
						$EventContent->assortmentAmount=$OldAmount+$Amount;
						//echo 'assortmentAmount1 '.$EventContent->assortmentAmount;
						$DefaultPrice=$Assortment->priceS;
						$FinalPrice=($DefaultPrice+$DefaultPrice*$Discount/100)*$CurrentRate;
						if ($Price>0) {
							$EventContent->price=$Price;
						}else{	
							
							$EventContent->price=$FinalPrice;
							
						}
						$EventContent->RecommendedPrice = $FinalPrice;
						$EventContent->cost=$EventContent->price * $Amount;   // 	
						$EventContent->cost_w_discount = $EventContent->cost;   // 	почему?
					}else{
			//Создаём новый состав заказа
					
						$EventContent=new EventContent;
						$EventContent->eventId=$eventId; 
						$EventContent->assortmentId=$Assortment->id;
						$EventContent->assortmentTitle=$Assortment->title;
						$EventContent->assortmentAmount = $Amount;
						$DefaultPrice=$Assortment->priceS;
						$FinalPrice=($DefaultPrice+$DefaultPrice*$Discount)*$CurrentRate;
						if ($Price>0) {
							$EventContent->price=$Price;
						}else{
							
							$EventContent->price=$FinalPrice;
						}
						$EventContent->RecommendedPrice=$FinalPrice;
						$EventContent->cost=$EventContent->price*$Amount;   // 	
						$EventContent->cost_w_discount=$EventContent->cost;   // 	
					}
					//echo($EventContent->eventId.' '.$EventContent->assortmentTitle.' '.$EventContent->assortmentAmount.' '.$EventContent->price.' '.$EventContent->cost.' '.$EventContent->assortmentTitle);
					//print_r($EventContent);
						
					if (!$EventContent->save()) $error .= Yii::t('general', 'Failure saving assortment item located at row #') . $startRow . '<br />';	
					
				} // end "if ($Assortment==null)"			
			}
			if (!empty($error)) { 
				Yii::app()->user->setFlash('error', Yii::t('general', "Some rows from the file have not been saved into the order") . ": <br />" . $error );
			} else { Yii::app()->user->setFlash('success',Yii::t('general', "All the rows from the file have been saved into the order") . '.' ); 	} 	
			
		} else { 	throw new CHttpException(404, 'No file has been loaded...');  }
		//$this->redirect(array(Yii::app()->user->returnUrl));// возврат на наше действие...
		$this->redirect( array('orders/update' , 'id'=>$eventId , '#' => 'tab2' )); 
		// $this->render('update' ,array(
			// 'model'=>$model,  'activeTab' => 'tab2'
		 //));
	}
	 
	 
	public function actionIndex()
	{
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];			
		//print_r($model->attributes);
		$this->render('admin',array(
			'model'=>$model, 
		));
	}
	public function actionDenisTpl()
	{
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];
		
		$this->layout = '//layouts/FrontendLayoutDenis'; 
		
		$this->render('denis',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Events the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Events::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Events $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='events-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	} 
	/*public function UpdateEvent($user, $rule)
	{ 
		if ($user->checkAccess('1')) return true; // если это суперадмин - тогда ему позволено
		$event = Events::model()->findByPk($_GET['id']);// получаем само событие
		// если это старший менеджер или директор - тогда ему позволено редактировать любые события в своей компании 
		if ( $user->checkAccess('4') && ($user->organization == $event->organizationId)) return true; 
		
		// если это не новое событие, то тогда его уже нельзя редактировать ни менеджерам ни владельцу-пользователю
		//if ($event->StatusId != DocEvents::STATUS_NEW) return false;
		// пока убрал это для TAREX
	/*	
		if ( $user->checkAccess('5') && ($user->id == $event->organizationId)) return true; // если это (старший) менеджер или директор - тогда ему позволено смотреть любые события в своей компании 
		foreach (DocEventUsers::model()->findAllByAttributes(array('EventId' => $_GET['id'])) as $u)
		{ //пользователь есть на это событие и его права редактированиe или редактированиe и удалениe и это событие со статусом новое 
			if ($user->id == $u->UserId && $u->AccessId >= 2 && $event->StatusId == DocEvents::STATUS_NEW) return true;			
			// находим родителя и проверяем есть ли соответствие родителя если родитель - менеджер (не обязательно новое)	
			if ($user->checkAccess('5') && ($user->id == User::model()->findByPk($u->UserId)->parentId)) return true;					
		}
		 
		return false;
	}*/
	
	 protected function amountDataField($data,$row)
     { // ... generate the output for the column
	   // Params:
           // $data ... the current row data   
           // $row ... the row index 
		$list = array(); for($i=1; $i <= 100; $i++ ) { $list[$i] = $i; }
		return $dd = CHtml::dropDownList('EventContent[assortmentAmount][' . $data->id .']', 
			$data->assortmentAmount, 
			$list, 
			array( 
				'ajax' => array(
				'type'=>'POST', 
				'url'=>CController::createUrl('/eventContent/updateEventContent'),
				'success' =>'js: function() { /* here we update the current Grid with id = "orderscontent" */
					$.fn.yiiGridView.update("orderscontent", 
						{   complete: function(jqXHR, status) {
								if (status=="success"){
									//console.log(jqXHR, status);
									//alert("#grid-total-sum.value = " + $("#grid-total-sum").text() );
									// заносим новую сумму в поле где сумма заказа в основной закладке копируя её из поля в новой сетке
									$("#total-sum").text( $("#grid-total-sum").text() );
								}
							}
						});
					}',					
				)
			)
		);	
    } 
	protected function priceDataField($data,$row)
     { 
		$field =  CHtml::textField('EventContent[price][' . $data->id .']', 
			$data->price,  
			array( 
				'style'=> 'width:45px',
				'ajax' => array(
				'type'=>'POST', 
				'url'=>CController::createUrl('/eventContent/updateEventContent'),
				'success' =>'js: function() { /* here we update the current Grid with id = "orderscontent" */
								$.fn.yiiGridView.update("orderscontent");
								}',					
					)
				)
		);		
		$button = CHtml::ajaxSubmitButton(Yii::t('general', Yii::t('general','Save')) ,  array('eventContent/updateEventcontent', 'name' => 'savePrice'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent");}'), array('style'=>'float:right;')); 
		
		return $field . $button; 	          
    }
	protected function discountDataField($data,$row)
     { 
		$field =  CHtml::textField('EventContent[discount][' . $data->id .']', 
			round(($data->price - $data->assortment->getCurrentPrice())/$data->assortment->getCurrentPrice()*100, 2),  
			array( 
				'style'=> 'width:45px',
				'ajax' => array(
				'type'=>'POST', 
				'url'=>CController::createUrl('/eventContent/updateEventContent'),
				'success' =>'js: function() { /* here we update the current Grid with id = "orderscontent" */
								$.fn.yiiGridView.update("orderscontent");
								}',					
					)
				)
		);		
		$button = CHtml::ajaxSubmitButton(Yii::t('general', Yii::t('general','OK')) ,  array('eventContent/updateEventcontent', 'name' => 'saveDiscount'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent");}'), array('style'=>'float:right;')); 
		
		return $field . $button; 	         
    } 
	
	protected function titleDataField($data,$row)
    { 
		$Assortment=Assortment::model()->findbypk($data->id);
		if ($Assortment)
			return $data->assortmentTitle.' ('.$Assortment->article2.')'; 
		else		
			return '';		
    }  
	
	
	
	public function contractorType()
	{
		switch ( strtolower(Yii::app()->controller->id))
			{
				case	'purchase':
				case	'purchaseorder':
				case	'transfer':
				case	'rfq':
				case 'bankout':			
				case 'cashout':
				case 'deliveryin':
				case	'purchasereturn':
					return 'isSeller';
				
				case 'deliveryout':
				case 'bankin':			
				case 'cashin':			
				case 'sale':			
				case	'return':
				case	'order':
				case	'proforma':
				case	'rnp':
				default:
					return 'isCustomer';
			}
	}
	public function UpdateEvent($user, $rule)
	{ 
		if ($user->checkAccess(User::ROLE_ADMIN)) return true; // если это суперадмин - тогда ему позволено
		$event = Events::model()->findByPk($_GET['id']);// получаем само событие
		// если это старший менеджер или директор - тогда ему позволено редактировать любые события в своей компании 
		if($user->organization == $event->organizationId) 
		{
			if ( $user->checkAccess(User::ROLE_SENIOR_MANAGER)) return true; 
			// если это менеджер - тогда ему позволено редактировать событие где он   автор или события своих подчинённых
			elseif ( $user->checkAccess(User::ROLE_MANAGER)  && ($user->id == $event->authorId OR $user->id == User::model()->findByPk($event->contractorId)->parentId) ) return true; 
			// если это пользователь - тогда ему позволено редактировать событие где он или автор или контрагент
			elseif ( $user->checkAccess(User::ROLE_USER_RETAIL)   && ($user->id == $event->authorId OR $user->id == $event->contractorId ) ) return true; 
		}
		return false;
		
		// если это не новое событие, то тогда его уже нельзя редактировать ни менеджерам ни владельцу-пользователю
		//if ($event->StatusId != DocEvents::STATUS_NEW) return false;
		// пока убрал это для TAREX
		
	/*	if ( $user->checkAccess(ROLE_SENIOR_MANAGER) && ($user->id == $event->organizationId)) return true; // если это (старший) менеджер или директор - тогда ему позволено смотреть любые события в своей компании 
		foreach (DocEventUsers::model()->findAllByAttributes(array('EventId' => $_GET['id'])) as $u)
		{ //пользователь есть на это событие и его права редактированиe или редактированиe и удалениe и это событие со статусом новое 
			if ($user->id == $u->UserId && $u->AccessId >= 2 && $event->StatusId == DocEvents::STATUS_NEW) return true;			
			// находим родителя и проверяем есть ли соответствие родителя если родитель - менеджер (не обязательно новое)	
			if ($user->checkAccess('5') && ($user->id == User::model()->findByPk($u->UserId)->parentId)) return true;					
		}
		*/
		
	}
	public function getDiscount($data,$row)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('articles', $data->article, true); // нестрогое сравнение в поле Артикулы
		$disc = DiscountGroup::model()->find($criteria)->value; 
		return  isset($disc) ? $disc : '0';
	}			
}