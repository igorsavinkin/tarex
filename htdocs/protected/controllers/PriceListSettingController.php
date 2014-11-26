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
		echo 'day of week: ', CTimestamp::getDayofWeek();// Yii::app()->timestamp->getDayofWeek();
		echo '<br>'; print_r(getdate()['wday']); echo '<br>'; 
		$criteria=new CDbCriteria;
		$criteria->compare('daysOfWeek', getdate()['wday'] , true); // сравнение по вхождению текущего дня недели с теми днями что в модели PriceListSetting
	 
		$now = new CDbExpression("NOW()");
		//$criteria->compare('isActive', 1); // должен быть активным
		$criteria->addCondition('time < '. $now);
		
	/*	echo '<br>condition: ', $criteria->condition;
		echo '<br>params: '; print_r($criteria->params);*/
		$plss = PriceListSetting::model()->findAll($criteria);
		$i=1;
		echo '<br>Matched criteria<br>';
		foreach(PriceListSetting::model()->findAll($criteria) as $pls)
		{
			echo $i++, '. ', $pls->id, '; cars: ' , $pls->carmakes, '<br>';
		}
	}
	public function actionSendPriceAttachment()
	{ 
		//define the receiver of the email 
		$to = 'igor.savinkin@gmail.com'; 
		//define the subject of the email 
		$subject = 'Test email with attachment'; 
		//create a boundary string. It must be unique 
		//so we use the MD5 algorithm to generate a random hash 
		$random_hash = md5(date('r', time())); 
		//define the headers we want passed. Note that they are separated with \r\n 
		$headers = "From: webmaster@example.com\r\nReply-To: webmaster@example.com"; 
		//add boundary string and mime type specification 
		$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
		//read the atachment file contents into a string,
		//encode it with MIME base64,
		//and split it into smaller chunks
		$attachment = chunk_split(base64_encode(file_get_contents(Yii::app()->basePath.'/files/tempSp.xlsx'))); 
		//define the body of the message. 
		ob_start(); //Turn on output buffering 
		?> 
		--PHP-mixed-<?php echo $random_hash; ?>  
		Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 

		--PHP-alt-<?php echo $random_hash; ?>  
		Content-Type: text/plain; charset="iso-8859-1" 
		Content-Transfer-Encoding: 7bit

		Hello World!!! 
		This is simple text email message. 

		--PHP-alt-<?php echo $random_hash; ?>  
		Content-Type: text/html; charset="iso-8859-1" 
		Content-Transfer-Encoding: 7bit

		<h2>Hello World!</h2> 
		<p>This is something with <b>HTML</b> formatting.</p> 

		--PHP-alt-<?php echo $random_hash; ?>-- 

		--PHP-mixed-<?php echo $random_hash; ?>  
		Content-Type: application/vnd.ms-excel; name="temp.xlsx"  
		Content-Transfer-Encoding: base64  
		Content-Disposition: attachment  

		<?php echo $attachment; ?> 
		--PHP-mixed-<?php echo $random_hash; ?>-- 

		<?php 
		//copy current buffer contents into $message variable and delete current output buffer 
		$message = ob_get_clean(); 
		//send the email 
		$mail_sent = @mail( $to, $subject, $message, $headers ); 
		//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
		echo $mail_sent ? "Mail sent" : "Mail failed";  
	}
	public function actionTestPHPMailer()
	{
		Yii::import('ext.phpmailer.JPhpMailer');
		$mail = new JPhpMailer;
		$mail->IsSMTP(); 
		$mail->Host = 'smtp.ht-systems.ru';
		$mail->SMTPAuth = true;
		$mail->Username = 'igor.savinkin@tarex.ru';
		$mail->Password = 'godmanig1';
		$mail->SetFrom('info@tarex.ru', 'Tarex.ru');
		$mail->Subject = 'The price list regular mailing'; // 'PHPMailer Test Subject via smtp, basic with authentication';
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		$mail->MsgHTML('<h3>See the Price List in Attachment !</h3>');
		$mail->AddAddress('igor.savinkin@gmail.com', 'from Igor Savinkin');
		$file_to_attach = Yii::app()->basePath.'/../files/tempSp.xlsx';
		echo $file_to_attach, '<br>';
		$mail->AddAttachment( $file_to_attach , 'tempSp.xlsx' ); 
		
		echo $mail->Send() ? "Mail sent with attachet file tempSp.xlsx" : "Mail failed"; 
	}
}