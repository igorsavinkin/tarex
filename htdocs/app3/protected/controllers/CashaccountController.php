<?php  
class CashaccountController extends Controller {
	
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
		$model=Cashaccount::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionAdmin()
	{
		$model=new Cashaccount('search'); //!!! Только здесь меняем 
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashaccount']))
			$model->attributes=$_GET['Cashaccount'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 	
	
	public function actionIndex()
	{
		$model=new Cashaccount('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashaccount']))
			$model->attributes=$_GET['Cashaccount'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 
	
	public function actionUpdate($id)
	{	
		if( $id == 'new' )
		{
			$model=new Cashaccount;   
	// Присвоить ид  
		  // $model->id = Cashaccount::model()->find(array('order'=>'id DESC'))->id + 1; 
	// Присвоить организацию 
			$model->organizationId = Yii::app()->user->organization; 		
		} else { 
			$model = Cashaccount::model()->findByPk($id);			
		} 

		if(isset($_POST['Cashaccount']))
		{ 
			$model->attributes=$_POST['Cashaccount'];  
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
} ?>