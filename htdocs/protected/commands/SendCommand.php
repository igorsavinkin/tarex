<?php
class SendCommand extends CConsoleCommand
{
    public function actionIndex($type=5)
	{
		// check mail - 
		mail('igor.savinkin@gmail.com', 'check command runnig at '. date('H:i:s'), 'Check is ok, send from SendCommand & action index, type = ' . $type);
	 	
		echo 'day of week: ', getdate()['wday'], '<br>'; 
		$criteria=new CDbCriteria;
		$criteria->compare('daysOfWeek', getdate()['wday'] , true); // сравнение по вхождению текущего дня недели с теми днями что в модели PriceListSetting
	 
		$now = new CDbExpression("NOW()"); 
		$criteria->addCondition('time < '. $now);
	 	$criteria->addCondition('lastSentDate < "'. date('Y-m-d') . '" ' ); // дата последней посылки должна быть меньше чем текущая дата		 
	
		$i=1;
		echo '<br>Matched criteria<br>';
		foreach(PriceListSetting::model()->findAll($criteria) as $pls)
		{ 
			echo  'user id = ', $pls->userId, '. <br> ';
			//посылка прайса			
		    $username = User::model()->findByPk($pls->userId)->username;
			$result = $this->runPHPMailer($pls->format, array($pls->email,  $username, $pls->userId));// email, имя пользователя и его id
				
			if($result) 
			{ 
				echo date('H-i-s'), ' Mail is sent to <b>',   $username , '</b> at <b>', $pls->email , '</b> with attached price list in <b>' , $pls->format ,'</b> format<br>';
				$pls->lastSentDate= date('Y-m-d');
				$pls->save(false);
			}				
			else 
				{ echo 'Mail failed to <b>',   $username , '</b> at <b>', $pls->email , '</b><br>'; }				
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
		if ('csv' == $extention) 
			$mail->AddStringAttachment( $this->getPricelistCSV($userId) , 'TAREX price list '. date('d-m-Y') . '.' .  $extention); 
		if ('xls' == $extention) 
			$mail->AddStringAttachment( $this->getPricelist($userId) , 'TAREX price list '. date('d-m-Y') . '.' .  $extention); 
		
		return ($mail->Send()) ? true : false;  
	}
	public function getPricelist($userId=null)
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
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Артикул');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Название');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'OEM');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Марка');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Производитель');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Цена');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Наличие');
			
		$criteria = new CDbCriteria(); 
		$criteria->addInCondition("article2", array('BZ04020mcl', 'd5091m', '1el008369091'));
	//	$criteria->condition =   'measure_unit<>"" AND price>0';
		$counter=2;
		foreach( Assortment::model()->findAll($criteria) as $item)
		{
			if (isset($_GET['file'])) continue; 
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$counter, $item->article2);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$counter, $item->title);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$counter, $item->oem);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$counter, $item->make);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$counter, $item->manufacturer);
		 	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$counter, $item->getPriceConsole($userId));  
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$counter, $item->availability);
		 
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
	public function getPricelistCSV($userId=null) // sendFile
	{ 	
	// writing csv into string ...   
		$output="\xEF\xBB\xBF"; // мы ставим BOM в начале содержимого файла 
		$arr = array( Yii::t('general', 'Article'), Yii::t('general', 'Title'), 'OEM' , Yii::t('general', 'Make') , Yii::t('general', 'Price') ,   Yii::t('general', 'Availability'));  
	    $output .= implode( ';' ,  $arr) . "\xA"; // добавляем здесь конец строки
	 // начало итераций по записям
		
		$criteria = new CDbCriteria(); 
		$criteria->addInCondition("article2", array('BZ04020mcl', 'd5091m', '1el008369091'));
	//	$criteria->condition =   'measure_unit<>"" AND price>0';	
		foreach(Assortment::model()->findAll($criteria) as $d)
		{ 
			$output .= implode( ';' , array( $d->article2, $d->title, $d->oem,  $d->make,  $d->getPriceConsole($userId),  $d->availability)) . "\xA"; // разделитель - точка с запятой и потом конец строки
		}   
		return $output;
	}	 
}