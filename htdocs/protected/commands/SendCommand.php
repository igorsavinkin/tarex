<?php
class SendCommand extends CConsoleCommand
{
    public function actionIndex()
	{	
	   	// check mail - 
		//mail('igor.savinkin@gmail.com', 'check command runnig at '. date('H:i:s'), 'Check is ok, send from "Send" command & action "index" '); 
	 	
	//	echo 'day of week: ', getdate()['wday'], '<br>'; 
		$now = new CDbExpression("NOW()");
		for($i=1; $i<4; $i++)  
		{
			$criteria=new CDbCriteria;
			$criteria->compare('daysOfWeek', getdate()['wday'] , true); // сравнение по вхождению текущего дня недели с теми днями что в модели PriceListSetting		 
			if ($i>1) {
			    $criteria->addCondition("time{$i} < " . $now . " AND lastSentDate{$i} < '". date('Y-m-d') . "' ");
				// условие что время посылки не первое не должно быть нулевым
				$criteria->addCondition("time{$i} <> '00:00:00' ");
			}
		    else 
				$criteria->addCondition('time < '. $now . ' AND lastSentDate < "'. date('Y-m-d') . '" ');
			
			//echo ' <br>criteria='; print_r($criteria); echo ' $i=', $i;
			$this->sendByCriteria($criteria, $i);
		}
		
	//	$criteria->addCondition('time2 < '. $now . ' AND lastSentDate2 < "'. date('Y-m-d') . '" ', 'OR' );
	//	$criteria->addCondition('time3 < '. $now . ' AND lastSentDate3 < "'. date('Y-m-d') . '" ', 'OR' ); // дата последней посылки должна быть меньше чем текущая дата	
	 	//$criteria->addCondition();	 
	 
	//	echo '<br>Matched criteria<br>';
		
	
	/*	foreach(PriceListSetting::model()->findAll($criteria) as $pls)
		{ 
			//echo  'user id = ', $pls->userId, '. <br> ';
			//посылка прайса		
			$user = User::model()->findByPk($pls->userId);	
		    $username = $user->username;
			$result = $this->runPHPMailer($pls->format, array($pls->email,  $username, $pls->userId, $pls->carmakes, $pls->columns , $pls->name   )); // email, имя пользователя, его id , марки, колонки для вывода и имя файла
				
			if($result) 
			{ 
				echo 'Послано письмо клиенту "',   $username , '" на ', $pls->email , ' с прикреплённым Прайс Листом формата "' , $pls->format ,'" в ', date('H:i:s') . PHP_EOL;
				$pls->lastSentDate= date('Y-m-d'); // сохраняем дату посылки в модели/базе чтобы потом сравнивать с ней
				$pls->save(false);
			// send mail to manager
				$managerEmail = isset($user->parentId) ? User::model()->findByPk($user->parentId)->email : null; 
				if ($managerEmail) 
					mail($managerEmail, '=?UTF-8?B?'.base64_encode('Прайс лист послан клиенту "' . $username .'"').'?=',
						'Послано письмо клиенту "'.   $username . '" на '. $pls->email . ' с прикреплённым Прайс Листом формата "' . $pls->format .'" в '.date('H:i:s') . PHP_EOL, 
						"From: ". Yii::app()->params['adminEmail'] . "\r\n Content-type: text/html;\r\n charset=UTF-8\r\nMime-Version: 1.0\r\n"); 
			}				
			else 
				{ echo 'Не удалось послать письмо клиенту "',   $username , '" на ', $pls->email ,  ' в ', date('H:i:s'); }				
		}	*/	 
	}  
	public function sendByCriteria($criteria, $time='')
	{ 
		//mail('igor.savinkin@gmail.com', 'check command runnig at '. date('H:i:s'), 'Check is ok, send from "Send" command & action "index". $criteria= ' . print_r($criteria, true));
		
		$time = ('1'==$time) ? '' : $time; // для 1 мы присваиваем '' (пустую строку)
		foreach(PriceListSetting::model()->findAll($criteria) as $pls)
		{ 
			//echo  'user id = ', $pls->userId, '. <br> ';
			//посылка прайса		
			$user = User::model()->findByPk($pls->userId);	
		    $username = $user->username;
			$result = $this->runPHPMailer($pls->format, array($pls->email,  $username, $pls->userId, $pls->carmakes, $pls->columns , $pls->name   )); // email, имя пользователя, его id , марки, колонки для вывода и имя файла
				
			if($result) 
			{ 
				echo 'Послано письмо клиенту "',   $username , '" на ', $pls->email , ' с прикреплённым Прайс Листом формата "' , $pls->format ,'" в ', date('H:i:s') . PHP_EOL;
				$lsd = 'lastSentDate'.$time;
				$pls->{$lsd} = date('Y-m-d'); // сохраняем дату посылки в модели/базе чтобы потом сравнивать с ней
				$pls->save(false);
			// send mail to manager
				$managerEmail = isset($user->parentId) ? User::model()->findByPk($user->parentId)->email : null; 
				if ($managerEmail) 
					mail($managerEmail, '=?UTF-8?B?'.base64_encode('Прайс лист послан клиенту "' . $username .'"').'?=',
						'Послано письмо клиенту "'.   $username . '" на '. $pls->email . ' с прикреплённым Прайс Листом формата "' . $pls->format .'" в '.date('H:i:s') . PHP_EOL, 
						"From: ". Yii::app()->params['adminEmail'] . "\r\n Content-type: text/html;\r\n charset=UTF-8\r\nMime-Version: 1.0\r\n"); 
			}				
			else 
				{ echo 'Не удалось послать письмо клиенту "',   $username , '" на ', $pls->email ,  ' в ', date('H:i:s'); }				
		}	
	
	}
	public function runPHPMailer( $extention=null, $mailArr=null)
	{ 
		if ($extention == null)
		{	echo 'Не задано расширение'; 
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
		// this is Прайс лист в прикреплении
		$msg=Yii::t('general', 'Price List is in an Attachment');
		$mail->MsgHTML('<h4>'. $msg . '.</h4>');
		$mail->AddAddress($mailArr[0], $mailArr[1]); 
	 
		$userId = $mailArr[2];
		$makes = $mailArr[3];
		$columns = $mailArr[4];
		$filename =  (''!=$mailArr[5]) ?  $mailArr[5] . '.' . $extention :  'TAREX price list '. date('d-m-Y') . '.' .  $extention;
		if ('csv' == $extention) 
			$mail->AddStringAttachment( $this->getPricelistCSV($userId, $makes, $columns) , $filename); 
		if ('xls' == $extention) 
			$mail->AddStringAttachment( $this->getPricelist($userId, $makes, $columns) , $filename); 
		
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
		$objPHPExcel->getProperties()->setTitle("Office 2003 XLS Price list at ". date('d.m.Y H:i:s')."   ");
		$objPHPExcel->getProperties()->setSubject("Office 2003 XLS Document");
		$objPHPExcel->getProperties()->setDescription("Test document for Office 2004 XLS, generated using PHP classes.");
		
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
			$columnsArr = array( 'article2', 'title', 'oem', 'manufacturer',  'make',  'Price',  'availability',  'MinPart');
		$arr=array();	
		$translationArr = array(	'article2'=>'Артикул',	'availability'=>'Доступность',	'model'=>'Модель', 'title'=>'Название','model'=>'Модель', 'make'=>'Марка',  'Price'=>'Цена',  'oem'=> 'OEM', 'manufacturer'=>'Производитель', 'MinPart'=>'Мин. партия');
		$letters = range('A', 'H');
		$i=0; // для итерации по буквам - $letters[$i]
		foreach($columnsArr as $column) 
		{
			$objPHPExcel->getActiveSheet()->SetCellValue( $letters[$i].'1',  $translationArr[$column]); 
			switch ($column)
			{
				case 'article2': 				
				case 'make': 
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
		$criteria->order =   'make, manufacturer'; // сортировка по марке и производителю
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
	 
		// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); // xlsx
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); // xls
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
			$columnsArr = array( 'article2', 'title', 'oem',  'make',  'Price',  'availability');
		$arr=array();	
		$translationArr = array(	'article2'=>'Артикул',	'availability'=>'Доступность',	'model'=>'Модель', 'title'=>'Название','model'=>'Модель', 'make'=>'Марка',  'Price'=>'Цена',  'oem'=> 'OEM', 'manufacturer'=>'Производитель', 'MinPart'=>'Мин. партия');
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
		$criteria->order =   'make, manufacturer'; // сортировка по марке и производителю
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