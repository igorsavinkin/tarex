<?php
class NewsController extends Controller
{ 
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
			array('allow',  // allow all users to perform  
				'actions'=>array(),
				'users'=>array('*'),
			), 
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create', 'admin','update', 'delete'),
				'roles'=>array(1,2,4,5), 
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} 
	public function actionCreate()
	{
		$model=new News('insert');  
		$model->newsDate = date('Y-m-d H:i');  
		$model->isActive = 1;  
		
		if(isset($_POST['News']))
		{ 
			$model->attributes=$_POST['News'];
		 
			$uploadedFile=CUploadedFile::getInstance($model,'imageUrl');
			if ($uploadedFile == null) 
				echo '<br>Failue to upload photo'; 
			else 
			{  
				$model->imageUrl =  $uploadedFile->name;  
				//echo '<br>uploadedFile name = ', $model->imageUrl; 
				if ($uploadedFile->saveAs( Yii::app()->basePath .'/../images/'. $uploadedFile->name))
				{
					//echo '<br>photo successfully saved';					
				}
				else 
					echo '<br>failure to save photo';
			}			
			if($model->save())
				$this->redirect(array('admin'));	
				//$this->redirect(array('update', 'id'=>$model->id));				
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
  
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id); 
		$model->scenario='update';  
	 
		if(isset($_POST['News']))
		{
			$_POST['News']['imageUrl'] = $model->imageUrl;
			
			$model->attributes=$_POST['News'];
			 
			$uploadedFile=CUploadedFile::getInstance($model,'imageUrl'); 
			// если старое имя пустое, тогда мы в него кладём то что из загружаемого файла
			if (empty($model->imageUrl)) 
				$model->imageUrl = $uploadedFile->name;
				
			if($model->save())
			{
				if(!empty($uploadedFile))  // check if uploaded file is set or not
                { // сохраняем новый файл со старым(или новым) именем из $model->imageUrl			
					if($uploadedFile->saveAs(Yii::app()->basePath . '/../images/' . $model->imageUrl))
					{
				//	 echo '<br>Uploaded file is saved! path is:  ', Yii::app()->basePath . '/../images/' . $model->imageUrl; 
					} 
					else
						echo '<br>Failure saving uploaded file; the path to save is ', Yii::app()->basePath . '/../images/' . $model->imageUrl;
                } else 
				{ 
					echo '<br>Uploaded file is empty!';
				}
				$this->redirect(array('admin'));				
			}
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
		$model=new News('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['News']))
			$model->attributes=$_GET['News'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}  
	
	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	} 
}