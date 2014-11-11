<?php
include('EventsController.php');

class ExchangeratesController extends EventsController {

	public function loadModel($id)
	{
		$model=Exchangerates::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionAdmin()
	{
		$model=new Exchangerates('search'); //!!! Только здесь меняем 
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Exchangerates']))
			$model->attributes=$_GET['Exchangerates'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 	
	
	public function actionIndex()
	{
		$model=new Exchangerates('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Exchangerates']))
			$model->attributes=$_GET['Exchangerates'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}  
	public function actionUpdate($id)
	{
	
		if($id=='new') {
			$model=new Exchangerates;			
			$model->id = Exchangerates::model()->Find(array('order'=>'id DESC'))->id+1;//Присвоить ид 
			
			$model->Begin = date('Y-m-d H-i-s');
			$date = date_create();
			date_modify($date, '+1 hour'); 
			
			$model->authorId=Yii::app()->user->id;
			if(Yii::app()->user->role>5) 				
				$model->contractorId=Yii::app()->user->id;
			
			$model->End = date_format($date, 'Y-m-d H:i:s');
			$model->organizationId = Yii::app()->user->organization; 
			$model->EventTypeId = Events::TYPE_EXCHANGE_RATE; //Тип события (установка курса валют)
			$model->StatusId = Events::STATUS_NEW; // статус новый 		
		}else{ 
			$model = Exchangerates::model()->findByPk($id); 
		}

		if(isset($_POST['Exchangerates']))
		{ 
			$model->attributes=$_POST['Exchangerates'];
			if($model->save()) 
				$this->redirect(array('admin'));
			else 
				{ echo 'save errrors'; print_r($model->getErrors()); }
		}
		if(isset($_POST['Events']))
		{ 
			$model->attributes=$_POST['Events'];
			if($model->save()) 
				$this->redirect(array('admin'));
			else 
				{ echo 'save errrors'; print_r($model->getErrors()); }
		}
		
		$this->render('update' ,array(
			'model'=>$model,
		));
	} 
}



