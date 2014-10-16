<?php
class ScopeOfActivityController extends Controller
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
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin', 'delete','create', 'update'),
				'users'=>array(1,2,4,5),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}  
 
	public function actionCreate()
	{
		$model=new ScopeOfActivity;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ScopeOfActivity']))
		{
			$model->attributes=$_POST['ScopeOfActivity'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
 
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id); 

		if(isset($_POST['ScopeOfActivity']))
		{
			$model->attributes=$_POST['ScopeOfActivity'];
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
 
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ScopeOfActivity');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
 
	public function actionAdmin()
	{
		$model=new ScopeOfActivity('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ScopeOfActivity']))
			$model->attributes=$_GET['ScopeOfActivity'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	 
	public function loadModel($id)
	{
		$model=ScopeOfActivity::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='scope-of-activity-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}