<?php  
class WarehouseController extends Controller {
	
	public function accessRules()
	{
		return array( 
			array('allow', 
				'actions'=>array('update','admin','index','create','delete'),
				'roles'=>array('1', '2', '4', '5'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public $layout = '//layouts/FrontendLayoutPavel';
	public function loadModel($id)
	{
		$model=Warehouse::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionAdmin()
	{
		$model=new Warehouse('search'); //!!! Только здесь меняем 
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Warehouse']))
			$model->attributes=$_GET['Warehouse'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 	
	
	public function actionIndex()
	{
		$model=new Warehouse('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Warehouse']))
			$model->attributes=$_GET['Warehouse'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 
	
	public function actionUpdate($id)
	{	
		if( $id == 'new' ){
			$model=new Warehouse;   
			// Присвоить ид и организацию 
			$model->id = Warehouse::model()->find(array('order'=>'id DESC'))->id + 1; 
			$model->organizationId = Yii::app()->user->organization; 
			$model->name = '';  
		
		} else { 
			$model = Warehouse::model()->findByPk($id);			
		} 

		if(isset($_POST['Warehouse']))
		{ 
			$model->attributes=$_POST['Warehouse'];  
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}	
}