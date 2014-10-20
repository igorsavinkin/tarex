<?php

class SpecialOfferController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin' ,'delete'),
				'roles'=>array(1,2,4,5),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionCreate()
	{
		$model=new SpecialOffer('insert'); 
		
		if(isset($_GET['assortmentId']))
		{
			$model->assortmentId = $_GET['assortmentId'];
			$item = Assortment::model()->findByPk($_GET['assortmentId']);
			$model->description = $item->title;
			$model->make = $item->make;
		// копируем изображение
			$model->photo = $item->article2 . '.jpg';
			 
			$model->price = $item->getPrice();
			if($model->save()) 
			    $this->redirect( array('update', 'id'=>$model->id,
				));			
		} 
		
		if(isset($_POST['SpecialOffer']))
		{ 
			$model->attributes=$_POST['SpecialOffer'];
		 
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			if ($uploadedFile == null) 
				echo '<br>Failue to upload photo'; 
			else 
			{  
				$model->photo = $uploadedFile->name;  
				echo '<br>uploadedFile name = ', $model->photo; 
				if ($uploadedFile->saveAs( Yii::app()->basePath .'/../img/foto/'. $uploadedFile->name))
				{
					//echo '<br>photo successfully saved';					
				}
				else 
					echo '<br>failure to save photo';
			}
			
			if($model->save())
				$this->redirect(array('update', 'id'=>$model->id));				
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
  
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id); 
		$model->scenario='update'; 
		// если это переход из assortmentId
		if(isset($_GET['assortmentId']))
		{
			$model->assortmentId = $_GET['assortmentId'];
			$item = Assortment::model()->findByPk($_GET['assortmentId']);
			$model->description = $item->title; 
			$model->make = $item->make; 
		
		// копируем изображение
			$model->photo = $item->article2 . '.jpg';
 
			$model->price = $item->getPrice();	
			$model->save();			
		}
	 
		if(isset($_POST['SpecialOffer']))
		{
			$_POST['SpecialOffer']['photo'] = $model->photo;
			//echo "\$_POST['SpecialOffer']['photo'] = ", $_POST['SpecialOffer']['photo'] ;
			$model->attributes=$_POST['SpecialOffer'];
			 
			$uploadedFile=CUploadedFile::getInstance($model,'photo'); 
			// если 
		    if ( !empty($uploadedFile->name) && !empty($uploadedFile) ) 
				$model->photo = $uploadedFile->name;
			//echo '<br>$model->photo = ', $model->photo;	
			if($model->save())
			{
				if(!empty($uploadedFile))  // check if uploaded file is set or not
                { // сохраняем новый файл со старым именем из $model->photo			
					if($uploadedFile->saveAs(Yii::app()->basePath . '/../img/foto/' . $model->photo))
					{
					//echo '<br>Uploaded file is saved! path is:  ', Yii::app()->basePath . '/../images/' . $model->photo; 
					} 
					else
						echo '<br>Failure saving uploaded file; the path to save is ', Yii::app()->basePath . '/../img/foto/' . $model->photo;
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
 
  
	public function actionAdmin()
	{
		$model=new SpecialOffer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SpecialOffer']))
			$model->attributes=$_GET['SpecialOffer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 
	
	
	public function loadModel($id)
	{
		$model=SpecialOffer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='special-offer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}