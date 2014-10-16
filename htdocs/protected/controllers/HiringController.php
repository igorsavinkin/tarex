<?php
include('EventsController.php'); 
	
class BankinController extends EventsController {
	 	
	public function loadModel($id)
	{
		$model=Events::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionAdmin()
	{
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 	
	
	public function actionIndex()
	{
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}  
	
	public function actionUpdate($id)
	{
		if($id=='new')
		{
			$model=new Events;
			$model->Begin = date('Y-m-d H-i-s');
			$date = date_create();
			date_modify($date, '+1 hour');
			$model->End = date_format($date, 'Y-m-d H:i:s');
			
			//Присвоить ид 
			$model->id = Events::model()->Find(array('order'=>'id DESC'))->id + 1;
			
			$model->authorId=Yii::app()->user->id;				
			$model->organizationId = Yii::app()->user->organization; 
			$model->EventTypeId = Events::TYPE_INFLOW_CASHLESS_MONEY; // Тип события - поступление безналичных денежных средств 
			$model->StatusId = Events::STATUS_NEW;  ; //   статус новый
			
		} else {
			$model=$this->loadModel($id);				
		}  
		
		if(isset($_POST['Events']))
		{
			$model->attributes=$_POST['Events'];		 
			if($model->save()) 
			{	  
				if ($_POST['ok']) 
					$this->redirect(array('admin', 'Subsystem'=>'Money Management' , 'Reference'=>Eventtype::model()->findByPk($model->EventTypeId)->Reference));
				else       
					$this->redirect(array('update', 'id'=>$model->id, 'Subsystem'=>'Money Management' , 'Reference'=>Eventtype::model()->findByPk($model->EventTypeId)->Reference));
			}      
		} 
			
		$this->render('update', array(
			'model'=>$model,
		));
	}  
}