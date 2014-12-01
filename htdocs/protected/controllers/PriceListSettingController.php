<?php
class PriceListSettingController extends Controller
{ 
	public $formats = array('csv'=>'csv', 'xls'=>'xls' /*, 'xlsx'=>'xlsx'*/);
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
				'actions'=>array( ),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'update', 'sendPrice', 'sendPriceAttachment' , 'testPHPMailer'), 
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin',  'delete'),
				'roles'=>array(1,2,3,4,5),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} 
	public function actionCreate($id=null)
	{
		$model=new PriceListSetting; 
		$model->time = '8:00:00';  
		//$model-> = '8:00:00';  
		
		if($id) {
			$model->userId = $id;
			$model->email = User::model()->findByPk($id)->email;
		}
		if(isset($_POST['PriceListSetting']))
		{
			$model->attributes=$_POST['PriceListSetting'];
			if (!empty($_POST['PriceListSetting']['daysOfWeek']))
			 	$model->daysOfWeek = implode(',' , $_POST['PriceListSetting']['daysOfWeek']);
			if (!empty($_POST['PriceListSetting']['carmakes']) && isset($_POST['use-in-reg-mailing']))
			 	$model->carmakes = implode(',' , $_POST['PriceListSetting']['carmakes']);
			else 
				$model->carmakes ='';
				
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['PriceListSetting']))
		{
			$model->attributes=$_POST['PriceListSetting'];
		//	echo '$model->daysOfWeek = ', $model->daysOfWeek;
			if (!empty($_POST['PriceListSetting']['daysOfWeek']) ) 
			 	$model->daysOfWeek = implode(',' , $_POST['PriceListSetting']['daysOfWeek']);
		 	else 				
				$model->daysOfWeek = null;
			
		//	echo '<br>$model->daysOfWeek (after change) = ', $model->daysOfWeek; 
			
			if (!empty($_POST['PriceListSetting']['carmakes']) && isset($_POST['use-in-reg-mailing']))
			 	$model->carmakes = implode(',' , $_POST['PriceListSetting']['carmakes']);
			else 
				$model->carmakes ='';
			if($model->save()) //{}
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
 
	public function actionAdmin()
	{
 		// если это оптовый клиент то сразу переход на его личную настройку посылки прайса
		if (Yii::app()->user->role == User::ROLE_USER) 
		{
			$pls = PriceListSetting::model()->findByAttributes(array('userId'=>Yii::app()->user->id));$this->redirect($pls ? array('update', 'id'=> $pls->id) : array('create', 'id'=>Yii::app()->user->id) );  
		}
		$model=new PriceListSetting('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PriceListSetting']))
			$model->attributes=$_GET['PriceListSetting'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}	 
	public function loadModel($id)
	{
		$model=PriceListSetting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='price-list-setting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function parsedDays($data, $row)
	{
		if ($data->daysOfWeek[0]=='') 
			return '';
		foreach(explode(',', $data->daysOfWeek) as $dow) 
			$days[]= Yii::app()->locale->getWeekDayName($dow); 
		return implode(', ', $days);		
	}
	public function actionSendPrice()
	{
		echo 'day of week: ', getdate()['wday'], '<br>'; 
		$criteria=new CDbCriteria;
		$criteria->compare('daysOfWeek', getdate()['wday'] , true); // сравнение по вхождению текущего дня недели с теми днями что в модели PriceListSetting
	 
		$now = new CDbExpression("NOW()"); 
		$criteria->addCondition('time < '. $now);
	 	$criteria->addCondition('lastSentDate < "'. date('Y-m-d') . '" ' );// дата последней посылки должна быть меньше чем текущая дата
		
	/*	echo '<br>condition: ', $criteria->condition;
		echo '<br>params: '; print_r($criteria->params); 
	*/ 
		$i=1;
		echo '<br>Matched criteria<br>';
		foreach(PriceListSetting::model()->findAll($criteria) as $pls)
		{  
			//посылка прайса			
			echo '<br>user id = ', $pls->userId, '<br>';
			$result = $this->runPHPMailer(
				$pls->format, // формат файла
				array($pls->email, User::model()->findByPk($pls->userId)->username, $pls->userId, $pls->carmakes) // email, имя пользователя, id пользователя и марки машин
			);
			if($result) 
			{ 
				echo  date('H:i:s'),  ' Mail is sent to <b>',  $pls->email , '</b> with attached price list in ',  $pls->format , ' format<br>';
				$pls->lastSentDate= date('Y-m-d');
				$pls->save(false);
			}				
			else 
				{ echo 'Mail failed to '. $pls->email . ' with attached file: ' . $filename, '<br>'; }
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
		$msg=Yii::t('general', 'Price List is in Attachment');
		$mail->MsgHTML('<h4>'. $msg . '.</h4>');
		$mail->AddAddress($mailArr[0], $mailArr[1]);
		//$mail->AddAddress('igor.savinkin@gmail.com', 'from Igor Savinkin');
	
	//	$filename = 'temp.xls';
	//	$filepath = Yii::app()->basePath . '/../files/' . $filename;//	echo $filepath, '<br>';	
	//	$mail->AddAttachment( $filepath , 'TAREX price '. date('d-m-Y') . '.xls'); 
		
		if ('csv' == $extention) 
			$mail->AddStringAttachment( $this->getPricelistCSV($mailArr[2], $mailArr[3]) , 'TAREX price list '. date('d-m-Y') . '.' .  $extention); 
		if ('xls' == $extention) 
			$mail->AddStringAttachment( $this->getPricelist($mailArr[2], $mailArr[3]) , 'TAREX price list '. date('d-m-Y') . '.' .  $extention); 
		
		return ($mail->Send()) ? true : false;  
	}
	public function getPricelist($id=null, $makes=null)
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
	// 	$criteria->addInCondition("article2", array('BZ04020mcl', 'd5091m', '1el008369091'));
		$criteria->condition =   'measure_unit<>"" AND price>0';
		if ($makes) 
			$criteria->addInCondition('make', explode(',' , $makes));
		$counter=2;
		foreach( Assortment::model()->findAll($criteria  ) as $item)
		{
			if (isset($_GET['file'])) continue; 
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$counter, $item->article2);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$counter, $item->title);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$counter, $item->oem);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$counter, $item->make);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$counter, $item->manufacturer);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$counter, $item->getPrice(Yii::app()->user->id));  
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
	public function getPricelistCSV($userId=null,$makes=null) // sendFile
	{ 	
	// writing csv into string ...   
		$output="\xEF\xBB\xBF"; // мы ставим BOM в начале содержимого файла 
		$arr = array( Yii::t('general', 'Article'), Yii::t('general', 'Title'), 'OEM',Yii::t('general', 'Make') ,Yii::t('general', 'Price'),  Yii::t('general', 'Availability'));  
	    $output .= implode( ';' ,  $arr) . "\xA"; // добавляем здесь и конец строки
	 // начало итераций по записям
		
		$criteria = new CDbCriteria();
	//	$criteria->addInCondition("article2", array('BZ04020mcl', 'd5091m', '1el008369091'));
		$criteria->condition =   'measure_unit<>"" AND price>0';	
		if ($makes) 
			$criteria->addInCondition('make', explode(',' , $makes));
		foreach(Assortment::model()->findAll($criteria) as $d)
		{ 
			$output .= implode( ';' , array( $d->article2, $d->title, $d->oem,  $d->make,  $d->getPriceConsole($userId),  $d->availability)) . "\xA"; // разделитель - точка с запятой 
		}   
		return $output;
	}
}