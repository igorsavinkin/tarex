<?php

class MaxDiscountController extends Controller
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
				'actions'=>array( ),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin', 'delete','create', 'update', 'index','view', 'setup'),
				'users'=>array(1,2,3,4,5),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/** SQL TO SET UP PREFIXES INTO ASSORTMENT
	
			UPDATE tarex_assortment AS a
			INNER JOIN tarex_max_discount AS maxd ON  a.manufacturer = maxd.manufacturer
			SET a.prefix = maxd.prefix 
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	public function actionView_old($id)
	{
		$this->render('view_old',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MaxDiscount;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaxDiscount']))
		{
			$model->attributes=$_POST['MaxDiscount'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	public function actionCreate_old()
	{
		$model=new MaxDiscount;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaxDiscount']))
		{
			$model->attributes=$_POST['MaxDiscount'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create_old',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaxDiscount']))
		{
			$model->attributes=$_POST['MaxDiscount'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionUpdate_old($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaxDiscount']))
		{
			$model->attributes=$_POST['MaxDiscount'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update_old',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MaxDiscount');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MaxDiscount('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaxDiscount']))
			$model->attributes=$_GET['MaxDiscount'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionAdmin_old()
	{
		$model=new MaxDiscount('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaxDiscount']))
			$model->attributes=$_GET['MaxDiscount'];

		$this->render('admin_old',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MaxDiscount the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MaxDiscount::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MaxDiscount $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='max-discount-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
