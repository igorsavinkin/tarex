<?php
ob_start();
class SiteController extends Controller
{ 
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','index2', 'contact', 'login','login2', 'logout' , 'frontendpavel'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('backend','backendpavel','backendpavel2'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
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
	public function actionIndex($page=null, $id=null)
	{		 
		$this->render($page ? $page : 'index');  
	}
	public function actionIndex2($id = null) // без рекламы
	{			
		if(!Yii::app()->user->isGuest) 
			$this->redirect(array('/myFrontend/admin')); 
		$this->layout = '//layouts/index_no_ad';
		$this->render('empty');  
	}	 
	
	public function actionBackend()
	{
		$this->layout='//layouts/BackendLayout'; 
		$this->render('BackendView'); 
	}		 
	
	public function actionFrontendPavel()
	{
		$this->layout='//layouts/FrontendLayoutPavel3'; 
		$this->render('FrontendViewPavel'); 
	}	 

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: {$name} <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	 
	public function actionLogin()
	{ 
		$model=new LoginForm;
		$mySecret = "моё имя Игорь Савинкин";
		if (isset($_GET['token'])) 
		{		
			//echo '$_GET[expiry] = ', $_GET['expiry'];
			//echo '<br> strtotime("now") = ', strtotime("now");
		// проверка не истекла ли ссылка	
			if(isset($_GET['expiry']) && strtotime("now") > $_GET['expiry']) {  
				echo Yii::t('general', "Your link has expired!"), '<br>Your link has expired!';
				Yii::app()->end(); 
			}
			if (isset($_GET['token']) && $_GET['token'] == md5($_GET['userId'] . $_GET['expiry'] . $mySecret )  )  
			{
				$user = User::model()->findByPk($_GET['userId']);
				$model->email = $user->email;
				$model->username = $user->username;
				$model->password = $user->password;
				$model->rememberMe = 1;
				if($model->validate() && $model->login())
				{							
					if (!empty($_GET['url']) ) 
						$this->redirect($_GET['url']);
					if (isset($_GET['redirect'])) 
						$this->redirect(array($_GET['redirect'], 'id'=>$_GET['id']));
					$this->redirect(isset($_GET['returnUrl']) ? $_GET['returnUrl'] : Yii::app()->user->returnUrl);  
				}
				
			} else { 
				echo Yii::t('general', "You've supplied wrong data for logging in!"), "<br/>You've supplied wrong data for logging in!"; Yii::app()->end(); 
			}
		}
		
		if ( ( isset($_GET['email']) OR isset($_GET['name']) ) && isset($_GET['p'])) 
		{
			if (isset($_GET['name'])) $model->username = $_GET['name'];
			if (isset($_GET['email']))  $model->email = $_GET['email'];
			$model->password = $_GET['p'];
			$model->rememberMe = 1;
			if($model->validate() && $model->login())
				{							
					if (!empty($_GET['url']) ) 
						$this->redirect($_GET['url']);
					if (isset($_GET['redirect'])) 
						$this->redirect(array($_GET['redirect'], 'id'=>$_GET['id']));
					$this->redirect(isset($_GET['returnUrl']) ? $_GET['returnUrl'] : Yii::app()->user->returnUrl); 
					//$this->redirect(Yii::app()->request->requestUri); 
				}
		}
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

	// для чего это ? 
		if(isset($_POST['email']))
		{			 
			// check 'email' and 'email2' fields
			$user = User::model()->find('`email` = :email', array(':email'=>$_POST['email']));
			
			if (empty($user)) $user = User::model()->find('`email2`  = :email', array(':email'=>$_POST['email']));
			if (empty($user)) {
				Yii::app()->user->setFlash('error', Yii::t('general',"There is no user associated with the email you've entered"). ': ' . $_POST['email']);
			} else { 				
				// sending mail
				if (mail($_POST['email'], Yii::t('general', 'Password recovery for') . ' ' . $user->username, 
				Yii::t('general', 'Your login(email) and password in TAREX.ru are' ) . ":\nemail: {$user->email}\npassword: {$user->password}\n". Yii::t('general', 'Click to login') . ': ' .  $this->createAbsoluteUrl("site/login", array( 'p'=>$user->password, 'email'=>$user->email)) ) )  
					Yii::app()->user->setFlash('success', Yii::t('general',"Credentials are sent on this email"). ': ' . $_POST['email']);
				else Yii::app()->user->setFlash('error', Yii::t('general',"Failure to send recovery message to the email"). ': ' . $_POST['email']); 		
			}
		}				
		
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];  
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{ 
				/*if(isset($_POST['loginMobile']))
				{
					echo 'return url: ', Yii::app()->user->returnUrl;
					if(isset(Yii::app()->user->returnUrl)) 
						$this->redirect(Yii::app()->user->returnUrl); 
					else 
						$this->redirect(array('MyFrontend/index'));   
				}*/
				if(isset($_POST['login']))   
				{ 
					if (isset($_GET['redirect'])) 
						$this->redirect(array($_GET['redirect'].'23')); 
					$this->redirect(array('index'));
				} 
			}
		}
		// display the login form
		$this->render('login', array('model'=>$model));
	} 
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}