<?php

class EventContentController extends Controller
{
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view' ,'admin' , 'bulkActions', 'updateEventContent'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'update' ),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(  'delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	public function actionBulkActions($name = null)
	{ 
		if ($_GET['name'] == 'delete') {
			EventContent::model()->deleteByPk($_POST['eventContentId']); 
		} 
	}
	public function actionUpdateEventContent()
	{
		if ($_GET['name'] && ('savePrice' == $_GET['name']) ) // сохранение изменённой цены
		{ 
			foreach($_POST['EventContent']['price'] as $key => $price)
			{
				$content = EventContent::model()->findByPk($key);
				$content->price = $price;
				$content->cost = $content->assortmentAmount * $content->price;
				$content->save(); 
			}
		} elseif ($_GET['name'] && ('saveDiscount' == $_GET['name']) ) // сохранение изменённой скидки и пересчёт цены
		{ 
			foreach($_POST['EventContent']['discount'] as $key => $discount)
			{
				$content = EventContent::model()->findByPk($key);
				$content->price = round((1 + $discount/100) * $content->assortment->getCurrentPrice(), 2); 
				$content->cost = $content->assortmentAmount * $content->price;
				$content->save(); 
			}
		} 
		else 	
		{ 
			$id = $_POST['eventContentId'][0];
			$content = EventContent::model()->findByPk($id); 
			$content->assortmentAmount = $_POST['EventContent']['assortmentAmount'][$id];
		}
		$content->cost = $content->assortmentAmount * $content->price;

		$content->save();
		//echo 'rows updated = ' , EventContent::model()->updateByPk($id, array('assortmentAmount'=>$_POST['EventContent']['assortmentAmount'][$id]));
		
		// вычисляем и обновляем полную сумму события
		 $sum = EventContent::getTotalSumByEvent($content->eventId);
		 Events::model()->updateByPk(array($content->eventId), array('totalSum'=>$sum) ); 
	}
 
	public function actionCreate()
	{
		$model=new EventContent;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EventContent']))
		{
			$model->attributes=$_POST['EventContent'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
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

		if(isset($_POST['EventContent']))
		{
			$model->attributes=$_POST['EventContent'];
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

		if(isset($_POST['EventContent']))
		{
			$model->attributes=$_POST['EventContent'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update_old',array(
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('EventContent');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new EventContent('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EventContent']))
			$model->attributes=$_GET['EventContent'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	 
	public function loadModel($id)
	{
		$model=EventContent::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-content-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
