<?php
class PriceListSettingController extends Controller
{ 
	public $formats = array('csv'=>'csv', 'xls'=>'xls', 'xlsx'=>'xlsx');
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
				'actions'=>array('create', 'update' ),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin',  'delete'),
				'roles'=>array(1,2,3,4,5),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} 
	public function actionCreate($id=null)
	{
		$model=new PriceListSetting; 
		$model->time = '8:00:00';  
		
		if($id) {
			$model->userId = $id;
			$model->email = User::model()->findByPk($id)->email;
		}
		if(isset($_POST['PriceListSetting']))
		{
			$model->attributes=$_POST['PriceListSetting'];
			if (!empty($_POST['PriceListSetting']['daysOfWeek']))
			 	$model->daysOfWeek = implode(',' , $_POST['PriceListSetting']['daysOfWeek']);		
		 
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['PriceListSetting']))
		{
			$model->attributes=$_POST['PriceListSetting'];
			if (!empty($_POST['PriceListSetting']['daysOfWeek']))
			 	$model->daysOfWeek = implode(',' , $_POST['PriceListSetting']['daysOfWeek']);
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
 
	public function actionAdmin()
	{
		$model=new PriceListSetting('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PriceListSetting']))
			$model->attributes=$_GET['PriceListSetting'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}	 
	public function loadModel($id)
	{
		$model=PriceListSetting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='price-list-setting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function parsedDays($data, $row)
	{
		foreach(explode(',', $data->daysOfWeek) as $dow) 
			$days[]= Yii::app()->locale->getWeekDayName($dow); 
		return implode(', ', $days);		
	}
}