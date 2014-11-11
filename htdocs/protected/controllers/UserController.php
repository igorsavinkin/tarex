<?php

class UserController extends Controller
{
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFF2F2F,
			),
		);
	}	 
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
				'actions'=>array('register', 'captcha', 'returnUsername' ,'ReturnShablonIdPaymentMethod' , 'test1' , 'test2', 'operationcondition'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'update' actions
				'actions'=>array('update', 'print'), 
				//'users'=>array('@'),
				'expression'=>array($this, 'UpdateUser'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create',  'admin', 'sendinvitation',  'sendinvitation2', 'adminPersonal'), 
				'roles'=>array(1, 2, 3, 4, 5),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'roles'=>array(1,2,3),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionPrint($id)
	{ 
		$user = User::model()->findByPk($id);
		
		$message = "<h1>Клиент ТАРЕКС <em>{$user->username}</em><br>
					<table border=1> 
					<tr><td><h3>Телефон</td><td><h3><em>{$user->phone}</td></tr>
					<tr><td><h3>Email</td><td><h3><em>{$user->email}</td></tr> 
					<tr><td><h3>Заметки</td><td><h3><em>{$user->notes}</td></tr>
					</table>";
		echo "<html><head></head><body onload='window.print()' >{$message}</body></html>"; 
	}
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	} 
 
	public function actionCreate()
	{
		$model=new User('insert');
		$model->organization = 7;
		$model->isCustomer = 1;
		$model->parentId = Yii::app()->user->id;
		$model->created = date("Y-m-d");
		$model->PaymentMethod = 2;// самовывоз 
		$model->ban = 0;
		$model->isActive = 1; // 0 - статус того, что этот 		 

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			// работа с городом для пользователя (если новый город - заносим его в модель )
			if (!empty($_POST['User']['city_new'])) 
			{
				$model->city = $_POST['User']['city_new'] ; /// $model->city_new;
			// добавление нового города в модель Cityes
				$newcity = new Cityes;
				$newcity->Name = $_POST['User']['city_new']; // $model->city_new;
				$newcity->save(false);
				//echo 'city saved: ', $_POST['User']['city_new']; //$model->city_new;
			} else 
			{ // присваивание существующего города модели User  
				$model->city = $_POST['Cityes']['Name']; 
			}
			if (!$model->role)
				$model->role = User::ROLE_USER_RETAIL; // it might be taken from settings model/table	
		
		// ставим им разный договор в зависимости от типа пользователя		
			if ($model->isLegalEntity==1) 
				$model->operationCondition='Договор для юридического лица'; 
			else 
				$model->operationCondition='Договор для физического лица'; 	
				
			if($model->save())
				if (Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
					if ($model->role > User::ROLE_MANAGER) 
						$this->redirect(array('admin'));
					else 
						$this->redirect(array('adminPersonal'));
				else 
					$this->redirect(array('site/index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
		
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->scenario = 'insert';	
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User']; 			
			$model->carMakes = implode(',', $_POST['User']['carMakes']);//echo '$model->carMakes = ', $model->carMakes, '<br>';
			
		/*	if ($model->isEmployee==1) 
				$model->role=5; // роль может не только 5 а и другие: 1-4	
		*/		
			
			if($model->save()) 
			 	if (Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
					if ($model->role > User::ROLE_MANAGER) 
						$this->redirect(array('admin'));
					else 
						$this->redirect(array('adminPersonal'));
				else 
					$this->redirect(array('site/index'));
		}
	
    	// мы формируем массив машин для вывода в мульти выпадающем списке
		$model->carMakes = ($model->carMakes) ? explode(',', $model->carMakes) : array();
		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionRegister() 
	{  
		/*$logo = Yii::app()->basePath . '/images/tar_top_logo.png'; 	
		echo 'logo link = ', $logo, '<br>';*/
		$model=new User('register');
		$model->organization = 7;
		$model->isCustomer = 1;
		//$model->parentId = Yii::app()->user->id;
		$model->operationCondition='Договор для физического лица/Договор для физического лица'; 

		if(isset($_POST['User']) )
		{			
			$model->attributes=$_POST['User'];
			$model->created = date("Y-m-d");
			$model->role = User::ROLE_USER_RETAIL; // it might be taken from settings model/table			
			$model->ban = 0;
			$model->isActive = 1; 		 
			if ($model->isEmployee==1) 
				$model->role=5; 
			if ($model->isLegalEntity==1) 
				$model->operationCondition='Договор для юридического лица'; 
			else 
				$model->operationCondition='Договор для физического лица'; 
				
			if($model->save()) { 				
			// письмо зарегистрировашемуся клиенту
				$to =   $model->username . ' <'. $model->email . '>';
				$from = 'Компания ТАРЕКС <'. Yii::app()->params['adminEmail'] . '>' ; // Yii::app()->params['generalManagerEmail'];
				$subject = Yii::t('general', 'Registration notification on Tarex.ru');//'Подтверждение регистрации на сайте TAREX.ru'; 
				$orderlink = CHtml::link( Yii::t('general', 'Click'), $this->createAbsoluteUrl('site/login', array('email'=>$model->email, 'p' => $model->password )));
			//begin of HTML message
			//	$logo = $this->createAbsoluteUrl('images/tar_top_logo.png'); 	
			    $message = <<<EOF
	<html> 
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
		  <body style='bgcolor:#DCEEFC'> 
			<!--center--> 
				<!--img src="{$logo}" /-->
				<h3><b>Вы зарегистрировались на сайте как пользователь <em>{$model->username}</em>. <br>
				
				Ваш email: <em>{$model->email} </em></b><br> 
				Ваш пароль: <em>{$model->password} </em></b><br>
				
				<font color="green">Для входа в систему перейдите по ссылке: </font> {$orderlink}
			<!--/center--> 
			  <br /><br />Искренне Ваша компания "TAREX" <br />
Наш адрес: <a href='http://goo.gl/maps/1Chft'>г. Москва, ул. Складочная д. 1, стр., 10</a><br />
Тел: +7 (495) 785-88-50 (многоканальный). <br />
Для региональных клиентов: +7 (495) 785-88-50 ICQ 612-135-517<br />

<font color="blue">
E-mail: region@tarex.ru <br />
E-mail: info@tarex.ru		
</font>  
		  </body>
		</html> 
EOF;
//end of message 
			
			//$to = '=?UTF-8?B?'.base64_encode($to).'?='; // не надо
			$from = '=?UTF-8?B?'.base64_encode($from).'?=';
			$subject =  '=?UTF-8?B?'.base64_encode($subject).'?=';
			
			$headers  = "From: {$from}\r\n"; 
			$headers .= "Content-type: text/html;charset=UTF-8\r\n";
			$headers .= "Mime-Version: 1.0\r\n"; 
		// посылаем скрытую копию главному менеджеру
			$headers .= 'Bcc: '.  Yii::app()->params['generalManagerEmail'] . "\r\n";
			 
			
			
			mail($to, $subject, $message, $headers); 	
			Yii::app()->user->setFlash('success', 'Пользователь <b>' . $model->email . '</b> создан. Вам выслано письмо - уведомление о регистрации. Перейдите по ссылке указанной в письме для входа в систему.'); 
			//$this->redirect(array('site/index'));
			}// end "if ($model->save())" - statement	
		} 
 
		$this->render('registration',array(
			'model'=>$model,
		));	
	} 
	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionSendinvitation($id, $filename = null) // sendInvitation
	{
		$client = $this->loadModel($id);
		$manager = $this->loadModel(Yii::app()->user->id); 
		$from = '=?UTF-8?B?'.base64_encode($manager->username . ' <'. $manager->email . '>').'?=';
		
		$profilelink = CHtml::Link('ссылке', $this->createAbsoluteUrl('update', array( 'id'=> $id)));
		$contract = CHtml::Link('этой ссылке', $this->createAbsoluteUrl('update', array( 'id'=> $id, '#'=>'tab2')));
		$directLink = CHtml::LInk(Yii::t('general', 'Click to login') ,  $this->createAbsoluteUrl("site/login", array( 'p'=>$client->password, 'email'=>$client->email, 'redirect'=>'assortment/admin')));
		
		$message = "Уважаемый <b>{$client->username}</b>,<br /> 
			Мы рады пригласить Вас на наш сайт для совместного сотрудничества. Ваш профиль уже создан.<!--Перейдите на него по этой {$profilelink}.<br/>
			Посмотрите условия договора по {$contract}.<br />			-->
			Для входа в систему используйте cледующие данные:<br /> 
		Email: <b>{$client->email}</b><br />
		Пароль: <b>{$client->password}</b><br />
		{$directLink}.
		<br /><br />
		С уважением, Ваш менеджер <em>{$manager->username}</em> {$manager->phone}"; 
	    $subject = '=?UTF-8?B?'.base64_encode('Приглашение на сайт автозапчастей TAREX.ru').'?=';
		if (mail(  $client->email , $subject  , $message , "From: {$from}\r\nContent-type: text/html; charset=UTF-8\r\nMime-Version: 1.0\r\n")) {
			Yii::app()->user->setFlash('success', 'Клиенту выслано письмо с его данными для входа и ссылкой на договор.'); 
			}
		$this->redirect(array('update','id'=>$client->id));
	}
	
	public function actionSendinvitation2($id) // sendInvitation
	{
		$client = $this->loadModel($id);
		if (isset($_POST['url']) OR isset($_POST['Manufacturer']['id']) )
		{	 			
			$manager = $this->loadModel(Yii::app()->user->id); 
			$from = '=?UTF-8?B?'.base64_encode($manager->username . ' <'. $manager->email . '>').'?=';
			
			$profilelink = CHtml::Link('ссылке', $this->createAbsoluteUrl('update', array( 'id'=> $id)));
			$contract = CHtml::Link('этой ссылке', $this->createAbsoluteUrl('update', array( 'id'=> $id, '#'=>'tab2')));
			
	// мы формируем token (жетон) для клиента чтобы войти в систему.	
		// When should this token expire?
			$expiryTimestamp = strtotime("+3 hours");
			$mySecret = "моё имя Игорь Савинкин";
			$token = md5($id . $expiryTimestamp . $mySecret);
		// Put parameters together into a link  -  безопасная ссылка
			$link = CHtml::Link(Yii::t('general', 'Click to login (secure)'),  $this->createAbsoluteUrl("site/login", array( 
				'token'  => $token, 
				'userId' => $id, 
				'expiry' => $expiryTimestamp,
				 'redirect'=>'assortment/index', 
				 'id'=>$_POST['Manufacturer']['id'],
				 'url'=>$_POST['url'], )
			)); 
		
		// небезопасная ссылка		
			$directLink = CHtml::Link(Yii::t('general', 'Click to login') ,  $this->createAbsoluteUrl("site/login", array( 'p'=>$client->password, 'email'=>$client->email, 'redirect'=>'assortment/index', 'url'=>$_POST['url'], 'id'=>$_POST['Manufacturer']['id'])));
			//	{$directLink}.
			$message = "Уважаемый <b>{$client->username}</b>,<br /> 
				Мы рады пригласить Вас на наш сайт для совместного сотрудничества. Ваш профиль уже создан.<!--Перейдите на него по этой {$profilelink}.<br/>
				Посмотрите условия договора по {$contract}.<br />		
				Для входа в систему используйте cледующие данные:<br /> 
			Email: <b>{$client->email}</b><br />
			Пароль: <b>{$client->password}</b><br />	-->
			Для входа в систему используйте ссылку ниже:<br /> 
			{$link}. Действие ссылки истекает через 3 часа. 
			<br /><br />
			С уважением, Ваш менеджер <em>{$manager->username}</em> {$manager->phone}"; 
			$subject = '=?UTF-8?B?'.base64_encode('Приглашение на сайт автозапчастей TAREX.ru').'?=';
			if (mail(  $client->email , $subject  , $message , "From: {$from}\r\nContent-type: text/html; charset=UTF-8\r\nMime-Version: 1.0\r\n")) {
				Yii::app()->user->setFlash('success', 'Клиенту выслано письмо с его данными для входа и ссылкой на договор.'); 
				}
			$this->redirect(array('update','id'=>$client->id));
		}
		// формируем массив марок для выбора в eSelect2
    	$criteria = new CDbCriteria;
		$criteria->compare('depth', 2);	
		$criteria->order = 'title ASC';			
		$criteria->select = array('title', 'id');			
		$manufacturers = Assortment::model()->findAll($criteria);
		
		/*$makesAll=array();												
		foreach($manufacturers as $m)
		{ 
			// все данные
			$Parent=Assortment::model()->findByPk($m->parent_id);
			if($Parent->title=='ГРУЗОВИКИ')
				$makesgrAll[$m->id] =  $m->title; 
			else 
				$makesAll[$m->id] =  $m->title; 
*/
		
		$this->render('invitation',array(
			'manufacturers'=>$manufacturers,
			'model'=>new Assortment,
			'client'=>$client,
		));	
	}

	public function actionAdmin()
	{// переход на действие с персоналом если есть $_GET['Subsystem']
		if (isset($_GET['Subsystem']) && $_GET['Subsystem'] == 'Staff & Salary tools')
		    $this->redirect(array('adminPersonal'));
			
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))			
			$model->attributes=$_GET['User'];
			
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionAdminPersonal()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))			
			$model->attributes=$_GET['User'];
			
		$this->render('adminPersonal',array(
			'model'=>$model,
		));
	}
		
	public function  actionOperationcondition(){	
		$this->render('operationcondition');
	}
	public function  actiontest1(){	
		$this->layout='//layouts/test'; 
		$this->render('test');
	}  
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	} 
	public function actionReturnUsername($id)
	{    
		echo $this->loadModel($id)->username;
	}
	public function actionReturnShablonIdPaymentMethod($id)
	{    
		$model = $this->loadModel($id); 
		// кодируем данные в json и выдаём их
		echo "{ \"shablon\": \"{$model->ShablonId}\", \"paymentmethod\": \"{$model->PaymentMethod}\" }";
		//echo "{shablon: {$model->ShablonId}, paymentmethod: {$model->PaymentMethod}}";
	} 

	//==== ФУНКЦИЯ ОПРЕДЕЛЕНИЕ ГОРОДА ПО IP  ======
	function Foccurrence($ip='', $to = 'windows-1251')
	{ 
		$ip = ($ip) ? $ip : $_SERVER['REMOTE_ADDR'] ; 
		try {
			$xml =  simplexml_load_file('http://ipgeobase.ru:7020/geo?ip='.$ip); //213.87.131.124 
		}  
		catch (Exception $e) {
			//echo 'Поймано исключение: ',  $e->getMessage(), "\n"; 
			return 'Москва';
		}
		if($xml->ip->city)
		{
			return iconv( "UTF-8", 'UTF-8', $xml->ip->city);
		} 			
	}
	//==== КОНЕЦ ФУНКЦИИ ОПРЕДЕЛЕНИЕ ГОРОДА ПО IP  ======
	public function getAllChildren($parent)
	{
		$children = (array)$parent;
		//print_r($children); echo '<br>';
		$ch = User::model()->findAll('parentId IN ('. implode(',', (array)$parent). ')');
		if ($ch) 
		{
			foreach ($ch as $c)
			{
				//$children[] = $c->id;
				$children = array_unique(array_merge( (array)$this->getAllChildren($c->id) , $children));				
			}
			//echo '<br>children count is ', count($children), '<br>';
			//print_r($children); 
		} else return $children;
		return $children;
	}
	public function UpdateUser($user, $rule) 
	{ 
	// если это суперадмин или старше менеджера или если id текущего пользователя равно $_GET['id'] - тогда позволено смотреть/редактировать
		if ($user->checkAccess(User::ROLE_SENIOR_MANAGER) OR $user->id == $_GET['id']) return true; 
	
	// если это менеджер и он - родитель этого клиента - тогда можно смотреть/редактировать	
		if( $user->checkAccess(User::ROLE_MANAGER) && User::model()->findByPk($_GET['id'])->parentId == $user->id) return true; 
	  
		return false;
	}
	
}
