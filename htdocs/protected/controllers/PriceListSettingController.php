<?php
class PriceListSettingController extends Controller
{ 
	public $formats = array('csv'=>'csv', 'xls'=>'xls', 'xlsx'=>'xlsx');
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
		
		if($id) {
			$model->userId = $id;
			$model->email = User::model()->findByPk($id)->email;
		}
		if(isset($_POST['PriceListSetting']))
		{
			$model->attributes=$_POST['PriceListSetting'];
			if (!empty($_POST['PriceListSetting']['daysOfWeek']))
			 	$model->daysOfWeek = implode(',' , $_POST['PriceListSetting']['daysOfWeek']);
			if (!empty($_POST['PriceListSetting']['carmakes']))
			 	$model->carmakes = implode(',' , $_POST['PriceListSetting']['carmakes']);
				
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
			
			if (!empty($_POST['PriceListSetting']['carmakes']))
			 	$model->carmakes = implode(',' , $_POST['PriceListSetting']['carmakes']);
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
		//$plss = PriceListSetting::model()->findAll($criteria);
		$i=1;
		echo '<br>Matched criteria<br>';
		foreach(PriceListSetting::model()->findAll($criteria) as $pls)
		{
			echo $i++, '. ', $pls->id, '; cars: ' , $pls->carmakes, '. ';
			//посылка прайса
			$filename = 'temp.xls';
			
		// надо сформировать прайс
			
			$result = $this->runPHPMailer($filename);
			if($result) 
			{ 
				echo 'Mail is sent to '. $pls->email . ' with attached file: ' . $filename, '<br>';
				$pls->lastSentDate= date('Y-m-d');
				$pls->save(false);
			}				
			else 
				{ echo 'Mail failed to '. $pls->email . ' with attached file: ' . $filename, '<br>'; }
		}
	} 
	public function runPHPMailer($filename=null)
	{ 
		Yii::import('ext.phpmailer.JPhpMailer');
		$mail = new JPhpMailer;
		$mail->IsSMTP(); 
		$mail->Host = 'smtp.ht-systems.ru';
		$mail->SMTPAuth = true;
		$mail->Username = 'igor.savinkin@tarex.ru';
		$mail->Password = 'godmanig1';
		$mail->SetFrom('info@tarex.ru', 'TAREX.RU');
		$mail->Subject = 'Tarex price list; regular mailing'; 
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		$mail->MsgHTML('<h3>See the Price List in Attachment !</h3>');
		$mail->AddAddress('igor.savinkin@gmail.com', 'from Igor Savinkin');
	//	$filename = 'temp.xls';
		$filepath = Yii::app()->basePath . '/../files/' . $filename;//	echo $filepath, '<br>';
	
	//	$mail->AddAttachment( $filepath , 'TAREX price '. date('d-m-Y') . '.xls'); 
		$mail->AddStringAttachment( $this->getPricelist() , 'TAREX price "on the fly" '. date('d-m-Y') . '.xls'); 
		
		return ($mail->Send()) ? true : false;  
	}
	public function getPricelist($id=null)
	{   		
		// PHPExcel    
		include Yii::getPathOfAlias('ext'). '/PHPExcel.php';
		include Yii::getPathOfAlias('ext').  '/PHPExcel/Writer/Excel2007.php';

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
	//		$criteria->addInCondition("article2", array('BZ04020mcl', 'd5091m', '1el008369091'));
		$criteria->condition =   'measure_unit<>"" AND price>0';
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
	
}