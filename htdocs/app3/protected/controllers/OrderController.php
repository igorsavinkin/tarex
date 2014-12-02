<?php
include('EventsController.php'); 
	
class OrderController extends EventsController 
{ 
/*	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'denisTpl', 'clone2', 'create2', 'test3', 'test1'), 
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'update', 'update2', 'admin', 'PrintSF', 'PrintOrder', 'PrintSchet', 'PrintPPL', 'PrintPPL2', 'LoadContent','loadContent', 'clone'),
				'users'=>array('@'),  
			), 
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'), 
				'roles'=>array(User::ROLE_ADMIN),  
			),
			array('allow',  // deny all users
				'users'=>array('*'),
			),
		);
	} 
*/	
	
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	
	public function actiontest1()
	{
		echo 'test1';
	}
	
	public function actionAdmin()
	{ 
		if(isset($_GET['quickOpen']))
			$this->redirect(array('update', 'id'=>$_GET['quickOpen']));
		
		$model=new Order('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];

		$this->render('admin',array(
			'model'=>$model,
		));
		
		
	} 	
 
	public function actionIndex()
	{
		$model=new Order('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 
	
	public function actionLoadContent()
	{   
			$eventId=$_POST['Events']['id'];
		$model=$this->loadModel($eventId);  
		
		if (Yii::app()->user->role<=5){ 
			
			$ShablonId=User::model()->findbypk(Yii::app()->user->id)->ShablonId;
			if ($ShablonId!=0){
				$LoadDataSettings=LoadDataSettings::model()->findByPk($ShablonId); 
			}
		
		} // ???
					
		//$LoadDataSettings=LoadDataSettings::model()->findByPk($_POST['LoadDataSettingsID']); 
		$LoadDataSettings=LoadDataSettings::model()->findByPk($_POST['LoadDataSettings']['id']);  
		
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
		
		//$Discount=0;
		//$Discount=User::model()->findByPk($model->contractorId)->discount;
		
		
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
			 	$SearchString=str_replace(  array('.', ' ', '-')  , '' , $SearchString); 
					//echo '/'.$SearchString.'/<br>';
				if ($SearchString=='')  continue;
				
				$Amount=$as->getCell($AmountColumnNumber . $startRow)->getValue(); 
				$Price=$as->getCell($PriceColumnNumber . $startRow)->getValue(); 
				$criteria = new CDbCriteria; 
				$criteria->params = array(':value'=>$SearchString);
				$criteria->condition = 'title = :value OR oem = :value OR article = :value';
				$Assortment=Assortment::model()->find($criteria); 
				
				if($Assortment==null) {$error .= Yii::t('general','Row #') . $startRow . '. ' .  Yii::t('general','Could not find assortment item on ') . $ColumnSearch. ' = "'. $SearchString . '"<br />'; 
				} 
				else {
					
					//$DiscountNew =$this->actionFDiscount($Assortment,$model->contractorId,$model->Begin);
					//$DiscountNew = $Assortment->countDiscount( $model->Begin, $model->contractorId);
					
					
					// $DefaultPrice=$Assortment->priceS;
					// if ($DiscountNew!=0) $FinalPrice=($DefaultPrice+$DefaultPrice*$DiscountNew/100)*$CurrentRate;
					
					//echo '<br>FinalPrice '.$FinalPrice.'/DefaultPrice'.$DefaultPrice*$CurrentRate;
					
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
						
						//$eventContent->price = $eventContent->RecommendedPrice = $item->getPrice($model->contractorId);	
						
						//$FinalPrice=round(($DefaultPrice+$DefaultPrice*$Discount/100)*$CurrentRate,2);
						$FinalPrice=$Assortment->getPrice2($model->contractorId);
						//if ($DiscountNew!=0) $FinalPrice=round(($DefaultPrice+$DefaultPrice*$DiscountNew/100)*$CurrentRate,2) ;
						
						if ($Price>0) {
							$EventContent->price=$Price;
						}else{	
							
							$EventContent->price=$FinalPrice;
						}
						$EventContent->RecommendedPrice = $FinalPrice;
						$EventContent->cost=$EventContent->price * $EventContent->assortmentAmount;   // 	
						$EventContent->cost_w_discount = $EventContent->cost;   // 	почему?
					}else{
			//Создаём новый состав заказа
						
						$EventContent=new EventContent;
						$EventContent->eventId=$eventId; 
						$EventContent->assortmentId=$Assortment->id;
						$EventContent->assortmentTitle=$Assortment->title;
						$EventContent->assortmentAmount = $Amount;
						$DefaultPrice=$Assortment->priceS; 
						//$FinalPrice=round(($DefaultPrice+$DefaultPrice*$Discount/100)*$CurrentRate,2);
						$contractorId=$model->contractorId; 
						
						$FinalPrice=$Assortment->getPrice2($contractorId);
						//echo 'contractorId'.$contractorId;
						//return; 
						
						//if ($DiscountNew!=0) $FinalPrice=round(($DefaultPrice+$DefaultPrice*$DiscountNew/100)*$CurrentRate,2);
						
						if ($Price>0) {
							$EventContent->price=$Price;
						}else{
							
							$EventContent->price=$FinalPrice;
						}
						$EventContent->RecommendedPrice=$FinalPrice;
						//$EventContent->RecommendedPrice=1000;
						$EventContent->cost=$EventContent->price*$Amount;   // 	
						$EventContent->cost_w_discount=$EventContent->cost;   // 

						//print_r($EventContent);
					} // конец нового состава заказа
					$model->totalSum = EventContent::getTotalSumByEvent($model->id);
					$model->save();
					
					//echo($EventContent->eventId.' '.$EventContent->assortmentTitle.' '.$EventContent->assortmentAmount.' '.$EventContent->price.' '.$EventContent->cost.' '.$EventContent->assortmentTitle);
					//print_r($EventContent);
						
					if (!$EventContent->save()) $error .= Yii::t('general', 'Failure saving assortment item located at row #') . $startRow . '<br />';	
					 
				} // end "if ($Assortment==null)"			
			}
			if (!empty($error)) { 
				Yii::app()->user->setFlash('error', Yii::t('general', "Some rows from the file have not been saved into the order") . ": <br />" . $error );
			} else { Yii::app()->user->setFlash('success',Yii::t('general', "All the rows from the file have been saved into the order") . '.' ); 	} 	
			
		} else { 	throw new CHttpException(404, 'No file has been loaded...');  } 
	// возврат к заказу	
		$this->redirect( array('update' , 'id'=>$eventId , '#' => 'tab2' ));  
	} 
	
	public function actionCreate($contractorId=null)
	{ 
		$model=new Order;	
		$model->Begin = date('Y-m-d H-i-s');
		$model->organizationId = Yii::app()->user->organization;  
		$model->authorId=Yii::app()->user->id;
		if (isset($contractorId))  
			$model->contractorId=$contractorId; 
		elseif (Yii::app()->user->role > 5)  
			$model->contractorId=$model->authorId; 
		
		$model->EventTypeId = Events::TYPE_ORDER;  
		$model->StatusId = Events::STATUS_NEW;  
		
		if(isset($_POST['Events']) OR isset($_POST['Order']))
		{ 
			$oldStatus = $model->StatusId;
			$model->attributes = isset($_POST['Events']) ? $_POST['Events'] : $_POST['Order'];	
			
			if ($model->contractorId) 
			{
				$user = User::model()->findByPk($model->contractorId); 
			// меняем тип оплаты и номер шаблона если другой/поставлен контрагент			    
				if ($user->PaymentMethod) 
					$model->PaymentType = $user->PaymentMethod;
				if ($user->ShablonId) 
			        $loadDataSetting->id = $user->ShablonId;
			}
		 /*
		  // посылка письма клиенту (контрагенту) об cоздании нового заказа
					$orderLink = CHtml::LInk( 'заказа', $this->createAbsoluteUrl('order/update', array('id'=>$model->id, '#' => 'tab2')));
					$newStatusName = Yii::t('general', EventStatus::model()->findByPk($model->StatusId)->name);
					mail( $user->email, 
						"Создание нового заказа №{$model->id} в компании TAREX на cтатус {$newStatusName}",
						"Уважаемый {$user->username}.<br> Статус вашего {$orderLink} №{$model->id} был изменён на статус '{$newStatusName}'.", "Content-type: text/html\r\n"); */	 


			 
				/**/
			if($model->save(false)) 
			{
				if (isset($_POST['OK'])) 
					$this->redirect(array('admin',  'Subsystem' => 'Warehouse automation', 'Reference'=>'Order'));
				else	
					// переходим на действие update с только что сохранённым заказом
					$this->redirect(array('update', 'id'=>$model->id));
			} 
			else print_r($model->errors);
		} 
		$this->render('create', array('model'=>$model)); 		
	}	
	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id); 
		//$loadDataSetting = new LoadDataSettings; 
	// задаём настройку шаблона либо из настроек контрагента либо из настроек залогиненного пользователя
		$contractorId = ($model->contractorId) ? $model->contractorId : Yii::app()->user->id;
		$user = User::model()->findByPk($contractorId);
		$loadDataSetting = (LoadDataSettings::model()->findByPk($user->ShablonId)) ? LoadDataSettings::model()->findByPk($user->ShablonId) : LoadDataSettings::model()->findByPk(1); // если всё же не нашли шаблон, то тогда берём первую настройку - findByPk(1)	 
		
		if(isset($_POST['Events']))
		{ 
			$oldStatus = $model->StatusId;
			$model->attributes=$_POST['Events'];	
			
			if ($model->contractorId) 
			{
				$user = User::model()->findByPk($model->contractorId); 
				if ($oldStatus != $model->StatusId && $user->email) 
				{ 
	// посылка письма клиенту (контрагенту) об изменении статуса заказа
					$orderLink = CHtml::LInk(/*Yii::t('general','order')*/ 'заказа', $this->createAbsoluteUrl('order/update', array('id'=>$model->id, '#' => 'tab2')));
					$newStatusName = Yii::t('general', EventStatus::model()->findByPk($model->StatusId)->name);
					mail( $user->email, 
						"Изменение статуса заказа №{$model->id} в компании TAREX на cтатус {$newStatusName}",
						"Уважаемый {$user->username}.<br> Статус вашего {$orderLink} №{$model->id} был изменён на статус '{$newStatusName}'.", "Content-type: text/html\r\n");				
				}


			   if ($user->PaymentMethod) 
					$model->PaymentType = $user->PaymentMethod;
				if ($user->ShablonId) 
			        $loadDataSetting->id = $user->ShablonId;
			}	/**/
			if($model->save()) 
			{
				if (isset($_POST['OK'])) 
					$this->redirect(array('admin',  'Subsystem' => 'Warehouse automation', 'Reference'=>'Order'));
			} 
			else print_r($model->errors);
		} 
		
		if (isset($_GET['pageSize'])) {
            $pageSize = $_GET['pageSize'];
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        } else 		
			$pageSize = Yii::app()->user->getState('pageSize') ? Yii::app()->user->getState('pageSize') : Yii::app()->params['defaultPageSize'];	 
			
	 	$assortment = new Assortment('search');
		$assortment->unsetAttributes();  // clear any default values
		if(isset($_GET['Assortment'])) {					
			$assortment->attributes=$_GET['Assortment'];
		}  		 
		
		
		
// если что-то из ассортимента добавляется в событие
		if (isset($_POST['add-to-event']) && isset($_POST['Assortment']))
		{
			echo 'RecommendedPrice1 '. $eventContent->RecommendedPrice;
			$item = Assortment::model()->findByPk($_POST['Assortment']['id']);
			$eventContent = new EventContent;
			$eventContent->assortmentId = $item->id;
			$eventContent->assortmentTitle = $item->title;
			$eventContent->eventId = $id;
			$eventContent->assortmentAmount = $_POST['Assortment']['amount'];			
			$eventContent->price = $eventContent->RecommendedPrice = $item->getPrice($model->contractorId);	 

			// считаем новые стоимость и стоимость со скидкой
			$eventContent->cost = $eventContent->price * $eventContent->assortmentAmount;           
			$eventContent->cost_w_discount = $eventContent->cost;                 
			// потом сохраняем его
			if ($eventContent->save(false)) { 				
				$model->totalSum = EventContent::getTotalSumByEvent($id);
				//echo "we've counted new sum : " , $model->totalSum;
				$model->save(); 
				Yii::app()->user->setFlash('success', Yii::t('general', "The new item"). ' <b>' . $eventContent->assortmentTitle . '</b> ' . Yii::t('general', "has been added to the event") . '.');
				}
			else 
				Yii::app()->user->setFlash('error', Yii::t('general', "Failure to add the item"). ' <b>' . $eventContent->assortmentTitle . '</b> ' . Yii::t('general', " to the event") . '.');
			
			// здесь мы делаем GET-redirect чтобы избежать повторного сохранения POST-параметров если пользователь перезагрузит браузер
			$this->redirect( array('update' , 'id'=>$id , '#' => 'tab2' )); 
		}// конец добавления ассортимента в событие		
		
		$this->render('update' ,array(
			'model'=>$model, 'assortment'=>$assortment,  'pageSize' =>$pageSize, 'loadDataSetting' => $loadDataSetting
		));
	} 
	
	public function actionUpdate2($id)
	{
		$model=$this->loadModel($id);   
		$this->layout='//layouts/simple';
		
	// пользователи	
		$user=new User();		 
		$user->unsetAttributes();  // clear any default values
	    if(isset($_GET['User']))
			$user->attributes=$_GET['User']; 
		$dataProviderUser = $user->stool();	
		
		if(isset($_POST['Events']))
		{
			$model->attributes=$_POST['Events'];			
			if($model->save()) 
			{
				if ($_POST['OK']) 
					$this->redirect(array('admin',  'Subsystem' => 'Warehouse automation', 'Reference'=>'Order'));
			} 
			else print_r($model->errors);
		} 
		
		if (isset($_GET['pageSize'])) {
            $pageSize = $_GET['pageSize'];
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        } else 		
			$pageSize = Yii::app()->user->getState('pageSize') ? Yii::app()->user->getState('pageSize') : Yii::app()->params['defaultPageSize'];	 
			
	 	$assortment = new Assortment('search');
		$assortment->unsetAttributes();  // clear any default values
		if(isset($_GET['Assortment'])) {					
			$assortment->attributes=$_GET['Assortment'];
		}  		 
		
// если что-то из ассортимента добавляется в событие
		if (isset($_POST['add-to-event']) && isset($_POST['Assortment']))
		{
			$item = Assortment::model()->findByPk($_POST['Assortment']['id']);
			$eventContent = new EventContent;
			$eventContent->assortmentId = $item->id;
			$eventContent->assortmentTitle = $item->title;
			$eventContent->eventId = $id;
			$eventContent->assortmentAmount = $_POST['Assortment']['amount'];			
			$eventContent->price = $eventContent->RecommendedPrice = $item->getPrice($model->contractorId);	

			// считаем новые стоимость и стоимость со скидкой
			$eventContent->cost = $eventContent->price * $eventContent->assortmentAmount;           
			$eventContent->cost_w_discount = $eventContent->cost;                 
			// потом сохраняем его
			if ($eventContent->save(false)) { 				
				$model->totalSum = EventContent::getTotalSumByEvent($id);
				//echo "we've counted new sum : " , $model->totalSum;
				$model->save(); 
				Yii::app()->user->setFlash('success', Yii::t('general', "The new item"). ' <b>' . $eventContent->assortmentTitle . '</b> ' . Yii::t('general', "has been added to the event") . '.');
				}
			else 
				Yii::app()->user->setFlash('error', Yii::t('general', "Failure to add the item"). ' <b>' . $eventContent->assortmentTitle . '</b> ' . Yii::t('general', " to the event") . '.');
			
			// здесь мы делаем GET-redirect чтобы избежать повторного сохранения POST-параметров если пользователь перезагрузит браузер
			$this->redirect( array('update2' , 'id'=>$id , '#' => 'tab2' )); 
		}// конец добавления ассортимента в событие		  
		
		
		
		$this->render('update2' ,array(
			'model'=>$model, 'assortment'=>$assortment,  'pageSize' =>$pageSize, 'dataProviderUser'=>$dataProviderUser
		));  
	}  
	
/********************************* Печатные формы **********************************/
	public function actionPrintSF($id)
	{  
		/* Include PHPExcel */
		$DocEvent=Events::model()->findByPk($id);
		$organization=Organization::model()->findByPk($DocEvent->organizationId);	 	
		if (empty($organization)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you as user are not registered with any organization.')); 
			$this->redirect( array('update','id'=>$id));
		}	 
		
		$user = User::model()->findByPk($DocEvent->contractorId);
		if (empty($user)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you have not defined any contractor for this order. Turn to field "Contractor" and save the order.')); 
			$this->redirect( array('update','id'=>$id));
		}	
		 
		$DocEventContentA = array(); 
		$DocEventContent = EventContent::model()->findAllByAttributes(array('eventId'=>$DocEvent->id)); 
		
		if (!empty($DocEventContent)) 
		{
			foreach($DocEventContent as $r)	 
				$DocEventContentA[] = $r->assortmentTitle.'; '.$r->price.'; '.$r->assortmentAmount;	
		}
		else{ // если нет содержимого заказа 
		    Yii::app()->user->setFlash('error', Yii::t('general', 'There is no content in the order to print in invoice.')); 
			$this->redirect(array('update','id'=>$id));		
		}			 	
		//spl_autoload_unregister(array('YiiBase','autoload'));        
		require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';
	
		// Create new PHPExcel object
		//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
		//$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');//'Excel2007'
		$filename='Счет-фактура.xlsx';
		$objPHPExcel = $objReader->load("files/Shablon1.xlsx"); // БланкОтчета.xlsx
		$as = $objPHPExcel->getActiveSheet();
		
		$DateY=Substr($DocEvent->Begin,0,4);
		$DateM=Substr($DocEvent->Begin,5,2);
		$DateD=Substr($DocEvent->Begin,8,2);		 

		$as->getCell('B2')->setValue('Счет-фактура № '.$id.' от '.$DateD.' '.$month1.' '.$DateY.' г.');
		$as->getCell('B4')->setValue('Продавец: '.$organization->name);
		$as->getCell('B5')->setValue('Адрес: '.$organization->address);
		$as->getCell('B6')->setValue('ИНН/КПП продавца: '.$organization->INN.'/'.$organization->KPP);
		
		$as->getCell('B8')->setValue('Грузополучатель и его адрес: '.$user->username.', '.$user->address);
		$month = $this->monthInLetters($DateM)[0];
		$as->getCell('B9')->setValue("К платежно-расчетному документу № {$id} от {$DateD} {$month} {$DateY}"); // 
		$as->getCell('B10')->setValue('Покупатель: '.$user->username);
		$as->getCell('B11')->setValue('Адрес: '.$user->address);
		$as->getCell('B12')->setValue('ИНН / КПП покупателя: '.$user->INN.' / '.$user->KPP);

		$iterator=17; $Itogo=0; $ItogoBND=0; $ItogoNDS=0;
	// Печать содержимого	
		foreach( $DocEventContentA as $r)
		{				
			 $Arr = explode (";",$r); 			 
			 if ($iterator>17) {	  
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
			$Summ=$Arr[2] * $Arr[1];
			$Nds=$Summ-$Summ/118*100;
			$BezNds=$Summ-$Nds;
			if ($Count!=0)	{$PriceBNds=$BezNds/$Count; }else {$PriceBNds; }

			//количество и цена
			$as->getCell('B'.$iterator)->setValue( $Arr[0] );
			$as->getCell('I'.$iterator)->setValue ( number_format($Count,3,',',' ')   );
			$as->getCell('K'.$iterator)->setValue( number_format($PriceBNds,2,',',' ') );
			
			$as->getCell('M'.$iterator)->setValue( number_format($BezNds,2,',',' ') );
			$as->getCell('S'.$iterator)->setValue( number_format($Nds,2,',',' ')   );
			$as->getCell('W'.$iterator)->setValue( number_format($Summ,2,',',' '));
			
			$Itogo+=$Summ;
			$ItogoBND+=$BezNds;
			$ItogoNDS+=$Nds;
			
			$iterator++;
		}
		
	//Итоги
		$as->getCell('M'.$iterator)->setValue(number_format($ItogoBND,2,',',' '));
		$as->getCell('S'.$iterator)->setValue(number_format($ItogoNDS,2,',',' '));
		$as->getCell('W'.$iterator)->setValue(number_format($Itogo,2,',',' '));

	// Вывод		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');  
		$objWriter->save('php://output');  	
	// redirect ? order/update&id=582#tab2
	}
	
	public function actionPrintOrder($id)
	{  
		/* Include PHPExcel */
		$DocEvent=Events::model()->findByPk($id);
 
		$contractor = User::model()->findByPk($DocEvent->contractorId);
		if (empty($contractor)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you have not defined any contractor for this order. Turn to field "Contractor" and save the order.')); 
			$this->redirect( array('update','id'=>$id));
		}	
		 
		$DocEventContentA=Array();
		$DocEventContent=EventContent::model()->findAllByAttributes(array('eventId'=>$DocEvent->id));
		if (!empty($DocEventContent)) 
		{
			foreach($DocEventContent as $r) 
			{  // $assortment =  Assortment::model()->findByAttributes(array('title'=>$r->assortmentTitle))
				$DocEventContentA[] = $r->assortmentTitle .'; '.  // Arr[0]   Наименование,
					$r->price . '; ' .  						   // Arr[1]   Цена
					$r->assortmentAmount . ';' . 			   // Arr[2]   Количество
					Assortment::model()->findByAttributes(array('title'=>$r->assortmentTitle))->article . '; ' . 				 		   // Arr[3]   Артикул
					$r->cost ;   // Arr[4]  сумма cо скидкой
			}
		}

		else{ // если нет содержимого заказа 
		    Yii::app()->user->setFlash('error', Yii::t('general', 'There is no content in the order to print in invoice.')); 
			$this->redirect( array('update','id'=>$id));		
		}
			 		
		spl_autoload_unregister(array('YiiBase','autoload'));        
		require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';
		
		// Create new PHPExcel object
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		
		$objPHPExcel = $objReader->load("files/OrderTemplate.xlsx");  
		$as = $objPHPExcel->getActiveSheet();
		
		$DateY=Substr($DocEvent->Begin,0,4);
		$DateM=Substr($DocEvent->Begin,5,2);
		$DateD=Substr($DocEvent->Begin,8,2);
		
		
		$as->getCell('A1')->setValue($id);

		$as->getCell('B2')->setValue('ЗАКАЗ № '.$id.' от '.$DateD.' '. $this->monthInLetters($DateM)[0] .' '.$DateY.' г.');
		$as->MergeCells('B4:C4'); 		
		$as->getCell('B4')->setValue('Покупатель: '.$contractor->username);
		$as->MergeCells('B5:C5'); 
		$as->getCell('B5')->setValue('Адрес: ' . $contractor->address); 
		$as->MergeCells('B6:C6'); 
		$as->getCell('B6')->setValue('ИНН/КПП покупателя: '.$contractor->INN.'/'.$contractor->KPP);

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
			
	public function actionPrintPPL($id)
	{ 
	/* Include PHPExcel */
		$DocEvent=Events::model()->findByPk($id);
		$organization=Organization::model()->findByPk($DocEvent->organizationId);			
		if (empty($organization)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you as user are not registered with any organization.')); 
			$this->redirect( array('update','id'=>$id));
		}	
		$user=User::model()->findByPk($DocEvent->contractorId);
		if (empty($user)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you have not defined any contractor for this order. Turn to field "Contractor" and save the order.')); 
			$this->redirect( array('update','id'=>$id));
		}		 
			 		
		//exit;	
		spl_autoload_unregister(array('YiiBase','autoload'));        
		require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';
		
		// Create new PHPExcel object
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');//'Excel2007'
		
		$objPHPExcel = $objReader->load("files/PPL.xlsx"); // 
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

		$as->getCell('A4')->setValue('Платежное поручение № '.$id);
		$as->getCell('I4')->setValue($DateD.'.'.$DateM.'.'.$DateY);
		
		$Sum=EventContent::getTotalSumByEvent($model->eventId);
		$as->getCell('B6')->setValue($this->num2str($Sum));
		$as->getCell('A7')->setValue('ИНН '.$user->INN);
		$as->getCell('F7')->setValue('КПП '.$user->KPP);
		$as->getCell('M7')->setValue($Sum,2,'-',' ');
		$as->getCell('A9')->setValue($user->name);
		//$as->getCell('M9')->setValue($user->account);
		//$as->getCell('A13')->setValue($user->bank);
		//$as->getCell('A17')->setValue($organization->bank);
		$as->getCell('A20')->setValue('ИНН '.$organization->INN);
		$as->getCell('F20')->setValue('КПП '.$organization->KPP);
		$as->getCell('A22')->setValue($organization->name);
	/*	
		//$row=18; $Itogo=0; $ItogoNds=0; $ItogoBND=0; 
		$iterator=22; $Itogo=0; $ItogoBND=0; $ItogoNDS=0; $index=1;
			foreach( $DocEventContentA as $r)
			{
				//echo $r ;
				$Arr=explode (";",$r);
			
			 if ($iterator>22) {	 
					//echo 
					$as->insertNewRowBefore($iterator, 1); 
					$as->MergeCells('B'.$iterator.':C'.$iterator);
					$as->MergeCells('D'.$iterator.':U'.$iterator); $as->MergeCells('V'.$iterator.':X'.$iterator); 
					$as->MergeCells('Y'.$iterator.':AA'.$iterator);
					$as->MergeCells('AB'.$iterator.':AF'.$iterator);  $as->MergeCells('AG'.$iterator.':AL'.$iterator.'');
					$as->getCell('B'.$iterator.'')->setValue($as->getCell('B22')->getValue());
					$as->getCell('D'.$iterator.'')->setValue($as->getCell('D22')->getValue());
					$as->getCell('V'.$iterator.'')->setValue($as->getCell('V22')->getValue());
					$as->getCell('Y'.$iterator.'')->setValue($as->getCell('Y22')->getValue());
					$as->getCell('AB'.$iterator.'')->setValue($as->getCell('AB22')->getValue());
					$as->getCell('AG'.$iterator.'')->setValue($as->getCell('AG22')->getValue());				
					
			 }
				
				$Count=$Arr[2];
				$Summ=$Arr[2]*$Arr[1];
				$Nds=$Summ-$Summ/118*100;
				$BezNds=$Summ-$Nds;
				if ($Count!=0)	{$PriceBNds=$BezNds/$Count; }else {$PriceBNds; }

				//количество и цена
				$as->getCell('B'.$iterator)->setValue($index);
			    $as->getCell('D'.$iterator)->setValue($Arr[0]);
  			    $as->getCell('V'.$iterator)->setValue(number_format($Count,0,',',' '));
			    $as->getCell('AB'.$iterator)->setValue(number_format($PriceBNds,2,',',' '));
				
				//$as->getCell('M'.$iterator)->setValue(number_format($BezNds,2,',',' ') );
				//$as->getCell('S'.$iterator)->setValue(number_format($Nds,2,',',' ')   );
				$as->getCell('AG'.$iterator)->setValue(number_format($Summ,2,',',' '));
				
				
				$Itogo+=$Summ;
				$ItogoBND+=$BezNds;
				$ItogoNDS+=$Nds;
				
				$index++;
				$iterator++;
			}
		
		//Итоги
			$iterator+=2;
			$as->getCell('AG'.$iterator)->setValue(number_format($ItogoBND,2,',',' '));
			$iterator++;
			$as->getCell('AG'.$iterator)->setValue(number_format($ItogoNDS,2,',',' '));
			$iterator++;
			$as->getCell('AG'.$iterator)->setValue(number_format($Itogo,2,',',' '));
		$iterator++;
		
		 
		$as->getCell('B'.$iterator)->setValue('Всего наименований '.$index.', на сумму '.$Itogo);
		$iterator++;
		$as->getCell('B'.$iterator)->setValue($this->num2str($Itogo));
		*/		
		
		$filename='ppl';
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');  
		$objWriter->save('php://output');
		
	}
	 
	protected function priceDataField($data,$row)
    { 
    	$field =  CHtml::textField('EventContent[price][' . $data->id .']', 
			$data->price,  
			array( 
				'style'=> 'width:55px',
				'ajax' => array(
				'type'=>'POST', 
				'url'=>CController::createUrl('/eventContent/updateEventContent', array( 'name' => 'savePrice')),
				'success' =>'js: function() { 
				/* here we update the current Grid with id = "orderscontent" */
								$.fn.yiiGridView.update("orderscontent");		
							}',					
					)
				)
		);		
	   $button = CHtml::ajaxSubmitButton(Yii::t('general', Yii::t('general','OK')) ,  array('eventContent/updateEventcontent', 'name' => 'savePrice') , array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent", 
							{   complete: function(jqXHR, status) {
									if (status=="success"){
										//console.log(jqXHR, status);
										//alert("#grid-total-sum.value = " + $("#grid-total-sum").text() );
										// заносим новую сумму в поле где сумма заказа в основной закладке копируя её из поля в новой сетке
										$("#total-sum").text( $("#grid-total-sum").text() );
									}
								}
							});
						}'),  array('style'=>'float:right;'));
						
	    return $field . $button; 	         
	} 
// ---- Написание суммы прописью
	public function num2str($num) 
	{
		$nul='ноль';
		$ten=array(array('','один','два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),array('','одна','две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),); 
		$a20=array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятьнадцать', 'шестьнадцать', 'семьнадцать', 'восемьнадцать','девятнадцать');
		$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят','восемьдесят','девяносто');
		$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот','семьсот','восемьсот','девятьсот');
		$unit=array(array('копейка','копейки','копеек',1), array('рубль','рубля','рублей',0),array('тысяча','тысячи','тысяч',1),array('миллион','миллиона','миллионов',0),array('миллиард','миллиарда','миллиардеров',0),);
		
		list($rub,$kop)=explode('.',sprintf("%015.2f",floatval($num)));
		$out=array();
		if (intval($rub)>0) {
			
			foreach(str_split($rub,3) as $uk=>$v) {
				
				if (!intval($v)) continue;;
				$uk=sizeof($unit)-$uk-1;
				$gender=$unit[$uk][3];
				list($i1,$i2,$i3)=array_map('intval',str_split($v,1));
				$out[]=$hundred[$i1];
				if($i2>1) $out[]=$tens[$i2].' '.$ten[$gender][$i3];
				else $out[]=$i2>0 ? $a20[$i3] : $ten[$gender][$i3];
				if ($uk>1) $out[]=$this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
			}
		}
		else $out[]=$nul;
		$out[]=$this->morph(intval($rub),$unit[1][0],$unit[1][1],$unit[1][2]);
		$out[]=$kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]);
		
		return trim(preg_replace('/ {2,}/',' ', join(' ',$out)));			
	}
// --- склонения	 
    public function morph($n,$f1,$f2,$f5) 
	{
		$n=abs(intval($n)) %100;
		if ($n>10 && $n<20) return $f5;
		$n=$n%10;
		if ($n>1 && $n<5) return $f2;
		if($n==1) return $f1;
		return $f5; 
	}
	public function monthInLetters($month)
	{
		switch($month)
		{
			case '01' : return array('января', 'ЯНВАРЬ');
			case '02' : return array('февраля', 'ФЕВРАЛЬ');
			case '03' : return array('марта', 'МАРТ');
			case '04' : return array('апреля', 'АПРЕЛЬ');
			case '05' : return array('мая', 'МАЙ');
			case '06' : return array('июня', 'ИЮНЬ');
			case '07' : return array('июля', 'ИЮЛЬ');
			case '08' : return array('августа', 'АВГУСТ');
			case '09' : return array('сентября', 'СЕНТЯБРЬ');
			case '10' : return array('октября', 'ОКТЯБРЬ');
			case '11' : return array('ноября', 'НОЯБРЬ');
			case '12' : return array('декабря', 'ДЕКАБРЬ'); 
		} 
	
	}
	public function actionPrintSchet($id)
	{
	 /* Include PHPExcel */
	  $DocEvent=Events::model()->findByPk($id);
	  $organization=Organization::model()->findByPk($DocEvent->organizationId);   
	  if (empty($organization)) {
	   Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you as user are not registered with any organization.')); 
	   $this->redirect( array('update','id'=>$id));
	  } 
	  $user=User::model()->findByPk($DocEvent->contractorId);
	  if (empty($user)) {
	   Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you have not defined any contractor for this order. Turn to field "Contractor" and save the order.')); 
	   $this->redirect( array('update','id'=>$id));
	  } 
	   
	  $DocEventContentA=Array();
	  $DocEventContent=EventContent::model()->findAllByAttributes(array('eventId'=>$DocEvent->id));
	  if (!empty($DocEventContent)) 
	  {
	        foreach($DocEventContent as $r)  
			{
				$DocEventContentA[] = $r->assortmentTitle .'; '.  // Arr[0]   Наименование 
					$r->price . '; ' .  						   // Arr[1]   Цена
					$r->assortmentAmount . ';' . 	   // Arr[2]   Количество
					$r->cost . ';' .                               // Arr[3]   Cумма cо скидкой
					Assortment::model()->findByAttributes(array('title'=>$r->assortmentTitle))->measure_unit; 				 		  // Arr[4]   Единица измерения
			}
	  }
	  else { // если нет содержимого заказа 
		  Yii::app()->user->setFlash('error', Yii::t('general', 'There is no content in the order to print in invoice.')); 
	   $this->redirect( array('update','id'=>$id));  //return;  
	  }
	   
	  spl_autoload_unregister(array('YiiBase','autoload'));        
	  require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';
	  
	  // Create new PHPExcel object
	  $objReader = PHPExcel_IOFactory::createReader('Excel5');//'Excel2007'
	  
	  $objPHPExcel = $objReader->load("files/Schet_n.xls"); // 
	  $as = $objPHPExcel->getActiveSheet();
  
	  $DateY = substr($DocEvent->Begin,0,4);
	  $DateM = substr($DocEvent->Begin,5,2);
	  $DateD = substr($DocEvent->Begin,8,2);
	  
	  $as->getCell('B5')->setValue($organization->Bank);
	  $as->getCell('Z5')->setValue($organization->BIC);
	  $as->getCell('Z6')->setValue($organization->CurrentAccount);
	  $as->getCell('Z8')->setValue($organization->CorrespondentAccount);

	  $as->getCell('E8')->setValue($organization->INN);
	  $as->getCell('N8')->setValue($organization->KPP);
	  $as->getCell('B13')->setValue('Счет на оплату № '. $id .' от '. $DateD .' '. $this->monthInLetters($DateM)[0] . ' ' . $DateY . ' г.');
	  $as->getCell('B9')->setValue($organization->name);
	  
	  $as->getCell('G17')->setValue($organization->name.', ИНН '.$organization->INN.', КПП '.$organization->KPP.', '.$organization->address);	  
		
	  $as->getCell('G19')->setValue($user->OrganizationInfo . ', ИНН ' . $user->INN . ', КПП '.$user->KPP.', '.$user->address); 
	  
	  $iterator = 22; $Itogo = 0; $ItogoBND = 0; $ItogoNDS = 0; $index = 1;

	 
	  foreach($DocEventContentA as $r)
	  { 
		$Arr = explode (";", $r);
	   
		if ($iterator>22) 
		{   
			 $as->insertNewRowBefore($iterator, 1); 
			 $as->MergeCells('B'.$iterator.':C'.$iterator);
			 $as->MergeCells('D'.$iterator.':U'.$iterator); 
			 $as->MergeCells('V'.$iterator.':X'.$iterator); 
			 $as->MergeCells('Y'.$iterator.':AA'.$iterator);
			 $as->MergeCells('AB'.$iterator.':AF'.$iterator);  
			 $as->MergeCells('AG'.$iterator.':AL'.$iterator.''); 
		}
		
		$Count = $Arr[2];
		$Summ = $Arr[3]; //$Arr[2]*$Arr[1];
		$Nds = $Summ-$Summ/118 * 100;
		$BezNds = $Summ - $Nds; 
		if ($Count != 0) {$PriceBNds = $BezNds/$Count; } else {$PriceBNds; }

		// данные содержимого заказа: количество и цена 
		$as->getCell('B'.$iterator)->setValue($index);
		$as->getCell('D'.$iterator)->setValue($Arr[0]);
		$as->getCell('V'.$iterator)->setValue(number_format($Count,0,',',' '));
		$as->getCell('Y'.$iterator)->setValue($Arr[4]); // 
		$as->getCell('AB'.$iterator)->setValue(number_format($PriceBNds,2,',',' ')); 
		$as->getCell('AG'.$iterator)->setValue(number_format($Summ,2,',',' '));
		
		$Itogo+=$Summ;
		$ItogoBND+=$BezNds;
		$ItogoNDS+=$Nds;
		
		$index++;
		$iterator++;
	  } 
	  $as->getCell('B'.$iterator)->setValue($index); // для наименования "Доставка автотранспортом" мы ставим его номер по порядку.
	//Итоги
		$iterator+=2;
		$as->getCell('AG'.$iterator)->setValue(number_format($ItogoBND,2,',',' '));
		$iterator++;
		$as->getCell('AG'.$iterator)->setValue(number_format($ItogoNDS,2,',',' '));
		$iterator++;
		$as->getCell('AG'.$iterator)->setValue(number_format($Itogo,2,',',' '));
		$iterator++;
		
	  $as->getCell('B'.$iterator)->setValue('Всего наименований '.$index.', на сумму '.$Itogo);
	  $iterator++;
	  $as->getCell('B'.$iterator)->setValue($this->num2str($Itogo));

	  $filename="Cчет_№{$id}_от_{$DateD}_{$DateM}_{$DateY}.xls";
	  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	  header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'.$filename.'"');
	  header('Cache-Control: max-age=0');  
	  $objWriter->save('php://output');
	}
/**************** конец Печатные формы *********************************/
}