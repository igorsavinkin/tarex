<?php  
class EventtypeController extends Controller {

	public function accessRules()
	{
		return array( 
			array('allow', 
				'actions'=>array('update','admin','index','create','delete'),
				'roles'=>array(1),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public $layout = '//layouts/FrontendLayoutPavel';
	public function loadModel($id)
	{
		$model=Eventtype::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionAdmin()
	{
		$model=new Eventtype('search'); //!!! Только здесь меняем 
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Eventtype']))
			$model->attributes=$_GET['Eventtype'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 	
	
	public function actionIndex()
	{
		$model=new Eventtype('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Eventtype']))
			$model->attributes=$_GET['Eventtype'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 
	
	public function actionUpdate($id)
	{	
		if( $id == 'new' ) 
			$model = new Eventtype;     		
        else  
			$model = Eventtype::model()->findByPk($id);			

		if(isset($_POST['Eventtype']))
		{ 
			$model->attributes=$_POST['Eventtype'];  
			//print_r($_POST['Eventtype']);
			//print_r($model);
			// дополнительно сохраняем массив пришедших basesArray
			if ($_POST['Eventtype']['basesArray']) 
				$model->IsBasisFor = implode(',', $_POST['Eventtype']['basesArray']);
				
			if($model->save()) 
				$this->redirect(array('admin'));
		} 
				 
		// получаем массив в атрубут "basesArray" из строки атрибута "IsBasisFor"
		if (!empty($model->IsBasisFor)) $model->basesArray = explode(',',  $model->IsBasisFor);
		
		$this->render('update' ,array(
			'model'=>$model 
		));
	} 
	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete(); 
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}	
}