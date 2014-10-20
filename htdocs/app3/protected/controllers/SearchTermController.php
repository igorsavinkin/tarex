<?php
class SearchTermController extends Controller
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
				'actions'=>array('create'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin', 'delete'),
				'roles'=>array(1),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
 
 

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SearchTerm;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SearchTerm']))
		{
			$model->attributes=$_POST['SearchTerm'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
 
 
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SearchTerm']))
		{
			$model->attributes=$_POST['SearchTerm'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
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
 
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SearchTerm');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

 
	public function actionAdmin()
	{
		$model=new SearchTerm('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SearchTerm']))
			$model->attributes=$_GET['SearchTerm'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	 
	public function loadModel($id)
	{
		$model=SearchTerm::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SearchTerm $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='search-term-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
