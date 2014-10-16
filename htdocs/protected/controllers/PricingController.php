<?php
class PricingController extends Controller
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

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'roles'=>array('1', '2', '4', '5'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
 
	public function actionCreate()
	{
		$model=new Pricing; 
		$model->Date = date('Y-m-d');
		$model->isActive =1;
		
		if(isset($_POST['Pricing']))
		{ 
			$model->attributes=$_POST['Pricing']; 

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
		if(isset($_POST['Pricing']))
		{
			$model->attributes=$_POST['Pricing'];
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
		$model=new Pricing('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pricing']))
			$model->attributes=$_GET['Pricing'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionAdmin()
	{
		$model=new Pricing('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pricing']))
			$model->attributes=$_GET['Pricing'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Pricing::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pricing-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
