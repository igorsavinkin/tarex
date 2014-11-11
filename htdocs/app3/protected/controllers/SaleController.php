<?php
include('EventsController.php');

	
class SaleController extends EventsController { 

/*
public function accessRules()
	{
		return array( 
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'update', 'update2', 'PrintSF', 'PrintOrder', 'PrintSchet', 'PrintLabels', 'PrintPPL', 'PrintPPL2', 'LoadContent','loadContent', 'clone'),
				'users'=>array('@'), 
			)
		);
	} */
	

public function actionPrintLabels()
{  
	$eventId=$_GET['eventId'];
	//echo 'id '.$eventId;
	
	$EventsContent=EventContent::model()->findallbyattributes(array('eventId'=>$eventId));
	
	spl_autoload_unregister(array('YiiBase','autoload'));   	
	require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';

	//echo $id;
	
	// Create new PHPExcel object
	//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
	//$objPHPExcel = new PHPExcel();
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');//'Excel2007'
	$filename='Barcode.xlsx';
	$objPHPExcel = $objReader->load("files/Barcode.xlsx"); // БланкОтчета.xlsx
	
	//$as = $objPHPExcel->setActiveSheet(0);
	$as = $objPHPExcel->getActiveSheet(0);
	//$column = 'A1';

	//$as->getCell('A1')->setValue('123');
	//$as->getCell('B4')->setValue('Покупатель: ');	
	
	$i=3;
	foreach ($EventsContent as $r){
	
		//echo $r->assortmentTitle;
		if($r->Barcode==0) {
			$Barcode=$this->FGenerateBarcode();
			$r->Barcode=$Barcode;
			$r->save();
		}
		//$as->insertNewRowBefore(1, 2);
		$as->getCell('A'.$i)->setValue($r->assortmentTitle);
		$as->duplicateStyle($as->getStyle('A1'), 'A'.$i); 
		$i++;
		$as->getCell('A'.$i)->setValue($r->Barcode);
		$as->duplicateStyle($as->getStyle('A2'), 'A'.$i); 
		$i++; 
		
		
		//$this->FGenerateBarcode();
		//echo 'Barcode/'.$r->Barcode.'<br>';
		
	}
	
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel) ;
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');  
	$objWriter->save('php://output');  	

}

public function FGenerateBarcode(){
	$criteria=new CDbCriteria;
	$criteria->order='Barcode ASC';
	
	$Barcode=0;
	$EventsContent=EventContent::model()->findall($criteria);
	foreach ($EventsContent as $r){
		if ($r->Barcode!=0){
			$Barcode=$r->Barcode; //echo $Barcode;		
		}
		return $Barcode+1;
	}
}


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
}


