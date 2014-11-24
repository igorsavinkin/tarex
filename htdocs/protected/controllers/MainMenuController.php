<?php

class MainMenuController extends Controller
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
			array('allow', // allow authenticated user to perform  
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','update', 'delete','create'),
				'roles'=>array(User::ROLE_ADMIN), 
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} 
	public function actionCreate()
	{ 
		$model=new MainMenu;			 
		if ($model->save(false))  // переходим на действие update с только что сохранённой моделью		
			$this->redirect(array('update', 'id'=>$model->id));
	}	 
	public function actionUpdate($id)
	{
		$model = MainMenu::model()->findByPk($id);	

		if(isset($_POST['MainMenu']))
		{
			$model->attributes=$_POST['MainMenu'];
			if($model->save())
				$this->redirect(array('admin'));
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
		$model=new MainMenu('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MainMenu']))
			$model->attributes=$_GET['MainMenu'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function loadModel($id)
	{
		$model=MainMenu::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='main-menu-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
