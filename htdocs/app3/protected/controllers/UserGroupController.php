<?php 
class UserGroupController extends Controller {
	
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
			array('allow', 
				'actions'=>array('update','admin','index','create','delete'),
				'roles'=>array('1', '2', '4', 5),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	 
	public $layout = '//layouts/FrontendLayoutPavel';
	public function loadModel($id)
	{
		$model=UserGroup::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionAdmin()
	{
		$model=new UserGroup('search'); //!!! Только здесь меняем 
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserGroup']))
			$model->attributes=$_GET['UserGroup'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 	
	
	public function actionIndex()
	{
		$model=new UserGroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserGroup']))
			$model->attributes=$_GET['UserGroup'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 
	
	public function actionUpdate($id)
	{	
		if( $id == 'new' ){
			$model=new UserGroup;   
			// Присвоить ид и организацию
			//$GroupFinal=UserGroup::model()->find(array('order'=>'id DESC'))->id;
			$model->id = UserGroup::model()->find(array('order'=>'id DESC'))->id + 1; 
			$model->organizationId = Yii::app()->user->organization; 
			$model->name = '';  
		
		} else { 
			$model = UserGroup::model()->findByPk($id);			
		} 

		if(isset($_POST['UserGroup']))
		{ 
			$model->attributes=$_POST['UserGroup'];  
			if($model->save()) 
				$this->redirect(array('admin'));
		} 
		
		$this->render('update' ,array(
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
}