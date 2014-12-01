<?php
class SendCommand extends CConsoleCommand
{
    public function actionIndex()
	{	
	//mail('igor.savinkin@gmail.com', 'check command runnig at '. date('H:i:s'), 'Check is ok, send from "Send" command & action "index".');	// check mail - 
	 	
	//	echo 'day of week: ', getdate()['wday'], '<br>'; 
		$criteria=new CDbCriteria;
		$criteria->compare('daysOfWeek', getdate()['wday'] , true); // сравнение по вхождению текущего дня недели с теми днями что в модели PriceListSetting
	 
		$now = new CDbExpression("NOW()"); 
		$criteria->addCondition('time < '. $now);
	// 	$criteria->addCondition('lastSentDate < "'. date('Y-m-d') . '" ' ); // дата последней посылки должна быть меньше чем текущая дата		 
	
		//$i=1;
	//	echo '<br>Matched criteria<br>';
		foreach(PriceListSetting::model()->findAll($criteria) as $pls)
		{ 
			//echo  'user id = ', $pls->userId, '. <br> ';
			//посылка прайса			
		    $username = User::model()->findByPk($pls->userId)->username;
			$result = $this->runPHPMailer($pls->format, array($pls->email,  $username, $pls->userId, $pls->carmakes, $pls->columns   )); // email, имя пользователя, его id , марки и колонки для вывода
				
			if($result) 
			{ 
				echo 'Mail is sent to ',   $username , ' at ', $pls->email , ' with attached price list in ' , $pls->format ,' format at ', date('H:i:s');
				$pls->lastSentDate= date('Y-m-d');
				$pls->save(false);
			}				
			else 
				{ echo 'Mail failed to ',   $username , ' to ', $pls->email ,  ' at ', date('H:i:s'); }				
		}		 
	}  
	
	public function runPHPMailer( $extention=null, $mailArr=null)
	{ 
		if ($extention == null)
		{	echo 'No extention is given'; 
			exit();			
		}
		Yii::import('ext.phpmailer.JPhpMailer');
		$mail = new JPhpMailer;
		$mail->IsSMTP(); 
		$mail->Host = 'smtp.ht-systems.ru';
		$mail->SMTPAuth = true;
		$mail->Username = 'igor.savinkin@tarex.ru';
		$mail->Password = 'godmanig1';
		$mail->SetFrom('info@tarex.ru', 'TAREX.RU');
		$mail->Subject = 'TAREX price list '. date('Y-m-d'); 
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		// this is 
		$msg=Yii::t('general', 'Price List is in Attachment');
		$mail->MsgHTML('<h4>'. $msg . '.</h4>');
		$mail->AddAddress($mailArr[0], $mailArr[1]); 
	 
		$userId = $mailArr[2];
		$makes = $mailArr[3];
		$columns = $mailArr[4];
		if ('csv' == $extention) 
			$mail->AddStringAttachment( $this->getPricelistCSV($userId, $makes, $columns) , 'TAREX price list '. date('d-m-Y') . '.' .  $extention); 
		if ('xls' == $extention) 
			$mail->AddStringAttachment( $this->getPricelist($userId, $makes, $columns) , 'TAREX price list '. date('d-m-Y') . '.' .  $extention); 
		
		return ($mail->Send()) ? true : false;  
	}
	public function getPricelist($userId=null, $makes=null, $columns=null)
	{   		
		// PHPExcel    
		include_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';
		include_once Yii::getPathOfAlias('ext').  '/PHPExcel/Writer/Excel2007.php';

		// Create new PHPExcel object 	 
		$objPHPExcel = new PHPExcel();

		// Set properties	 
		$objPHPExcel->getProperties()->setCreator("TAREX Company, www.tarex.ru");
		$objPHPExcel->getProperties()->setLastModifiedBy("www.tarex.ru");
		$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Price list at ". date('d.m.Y H:i:s')."   ");
		$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Document");
		$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
		
		// Add data to document
		$objPHPExcel->setActiveSheetIndex(0);
/*		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
*/	
		if ($columns)  // $columns - строковая переменная содержащая колонки для прайса
			$columnsArr = array_unique(explode(',' , $columns));
		else 
			$columnsArr = array( 'article2', 'title', 'oem', 'manufacturer',  'model',  'Price',  'availability',  'MinPart');
		$arr=array();	
		$translationArr = array(	'article2'=>'Артикул',	'availability'=>'Доступность',	'model'=>'Модель', 'title'=>'Название','model'=>'Модель',  'Price'=>'Цена',  'oem'=> 'OEM', 'manufacturer'=>'Производитель', 'MinPart'=>'Мин. партия');
		$letters = range('A', 'H');
		$i=0; // для итерации по буквам - $letters[$i]
		foreach($columnsArr as $column) 
		{
			$objPHPExcel->getActiveSheet()->SetCellValue( $letters[$i].'1',  $translationArr[$column]); 
			switch ($column)
			{
				case 'article2': 
					$objPHPExcel->getActiveSheet()->getColumnDimension($letters[$i])->setWidth(20);
					break;
				case 'title': 
					$objPHPExcel->getActiveSheet()->getColumnDimension($letters[$i])->setWidth(80);
					break;
				case 'oem': 
				case 'model': 
				case 'MinPart': 
				case 'manufacturer': 
				case 'availability': 
					$objPHPExcel->getActiveSheet()->getColumnDimension($letters[$i])->setWidth(17);
					break; 
			} 
			$i++;
		}			
		
/*		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Артикул');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Название');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'OEM');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Модель');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Производитель');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Цена');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Наличие');	*/		
		$criteria = new CDbCriteria(); 
	//	$criteria->addInCondition("article2", array('BZ04020mcl', 'd5091m', '1el008369091'));
		$criteria->condition =   'measure_unit<>"" AND price>0';
	// добавляем условие выбора конкретных марок если они заданы
		if ($makes) 
			$criteria->addInCondition('make', explode(',' , $makes));
			
		$counter=2;		
		foreach( Assortment::model()->findAll($criteria) as $item)
		{
			$arr=array();
			$i=0; // для итерации по буквам - $letters[$i]
			foreach($columnsArr as $column) 
			{	
				if ('Price' != $column)  
					$objPHPExcel->getActiveSheet()->SetCellValue($letters[$i].$counter, $item->$column);
				else  
					$objPHPExcel->getActiveSheet()->SetCellValue($letters[$i].$counter, $item->getPriceConsole($userId)); 		
				$i++;			
			}	
			$counter++;					
		}
 
		$objPHPExcel->getActiveSheet()->setTitle('ТАРЕКС прайс лист на ' . date('d-m-Y'));
	 
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		ob_start();
	/*	ob_end_clean();
		$filename='ТАРЕКС прайс лист на '. date('d-m-Y'). '.xlsx';  
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');  */
		
		$objWriter->save('php://output'); 
		$excelOutput = ob_get_clean();
		return $excelOutput;
	}  
	public function getPricelistCSV($userId=null,  $makes, $columns=null) // sendFile
	{ 	
	// writing csv into string ...   
		// если заданы колонки
		if ($columns)  // $columns - строковая переменная содержащая колонки для прайса
			$columnsArr = array_unique(explode(',' , $columns));
		else 
			$columnsArr = array( 'article2', 'title', 'oem',  'model',  'Price',  'availability');
		$arr=array();	
		$translationArr = array(	'article2'=>'Артикул',	'availability'=>'Доступность',	'model'=>'Модель', 'title'=>'Название','model'=>'Модель',  'Price'=>'Цена',  'oem'=> 'OEM', 'manufacturer'=>'Производитель', 'MinPart'=>'Мин. партия');
		foreach($columnsArr as $column) 
			$arr[] = $translationArr[$column];   
			//$arr[] = Assortment::model()->getAttributeLabel($column);   // не работает в cli так как не определён язык
			
		$output="\xEF\xBB\xBF"; // мы ставим BOM в начале содержимого файла 
		//$arr = array( Yii::t('general', 'Article'), Yii::t('general', 'Title'), 'OEM' , Yii::t('general', 'Make') , Yii::t('general', 'Price') ,   Yii::t('general', 'Availability'));  
	    $output .= implode( ';' ,  $arr) . "\xA"; // добавляем здесь конец строки
		
	// начало итераций по записям		
		$criteria = new CDbCriteria(); 
	//	$criteria->addInCondition("article2", array('BZ04020mcl', 'd5091m', '1el008369091'));
		$criteria->condition =   'measure_unit<>"" AND price>0';	
    // добавляем условие выбора конкретных марок если они заданы
		if ($makes) 
			$criteria->addInCondition('make', explode(',' , $makes));
		
		foreach(Assortment::model()->findAll($criteria) as $d)
		{ 
			$arr=array();
			foreach($columnsArr as $column) 
			{
			// формируем массив для записи потом данных	
				if ('Price' != $column) 
					$arr[] =  $d->$column;
				else  
					$arr[] = $d->getPriceConsole($userId); 				
			}
			$output .= implode( ';' , $arr) . "\xA"; // разделитель - точка с запятой и потом конец строки			
		}   
		return $output;
	}	 
}