<?php

class MainMenuController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/FrontendLayoutPavel';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
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
				'actions'=>array('admin','update', 'delete'),
				'roles'=>array(User::ROLE_ADMIN), 
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} 
	 
	public function actionUpdate($id)
	{
		if( $id == 'new' ) 
			$model = new MainMenu;     		
        else  
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
