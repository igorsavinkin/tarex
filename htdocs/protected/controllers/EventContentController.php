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
 
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view' ,'admin' , 'bulkActions', 'updateEventContent', 'setModel', 'renew'),
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

	public function actionRenew($id)
	{   
		// контрагент заказа
		//$contractor=Events::model()->findByPk($id)->contractorId;
		// содержимое заказа
		$contents = EventContent::model()->findAllByAttributes(array('eventId'=>$id));
		$count=0;
		foreach($contents as $c)
		{
			// найдем элемент номенклатуры из заказа
			$item=Assortment::model()->findByAttributes(array('article2'=>$c->assortmentArticle));
			$c->basePrice=$item->getCurrentPrice(); // цена в долларах * на стоимость в долларах
			$c->RecommendedPrice=$item->getPriceOptMax(); 	// мин цена при максимальной скидке по группе
			$c->price = round($c->basePrice * (1 +$c->discount/100), 2); 
			$c->cost = $c->price * $c->assortmentAmount;
			
			if($c->save(false)) { $count++; }		
		}
		echo $count , ' ' , Yii::t('general','items in the order have been renewed');	 
	}
	public function actionSetModel()
	{
		 $contents = EventContent::model()->findAll();
		 $count=0;
		 foreach($contents as $c)
		 {
			$item=Assortment::model()->findByPk($c->assortmentId);
			if(isset($item)) {
				$c->assortmentArticle=$item->article2; 			
				$c->basePrice=$item->getCurrentPrice();
				$c->RecommendedPrice=$item->getPriceOptMax(); 	
			 
			// скидкa исходя из скидок по группам.
				$contractor = Events::model()->findByPk($c->eventId)->contractorId;
				$discGroupId = DiscountGroup::getDiscountGroup($item->article2);
				if(!$discGroupId) 
					$c->discount = 0; 
				else {
					$ugd = UserGroupDiscount::model()->findByAttributes(array('userId'=>$contractor, 'discountGroupId'=>$discGroupId));  
					$c->discount = (isset($ugd)) ? $ugd->value : 0 ;  
				}
				if($c->save(false)) { $count++;}
			}			
		 }
		 echo $count, ' models have been changed';
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
		    $ecs = EventContent::model()->findAllByPk($_POST['eventContentId']);  // несколько так как $_POST['eventContentId'] - массив
			foreach($ecs as $ec)
			{
				$item = Assortment::model()->findByPk($ec->assortmentId);						
				if($item)
				{
					$item->reservedAmount -= $ec->assortmentAmount;
					$item->save(false);
				}  
			}	
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
				$content->discount = round(($price - $content->basePrice) *100 / $content->basePrice, 2); 			
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
		} elseif ($_GET['name'] && ('saveDiscountNew' == $_GET['name']) ) // сохранение изменённой скидки и пересчёт цены
		{ 
			foreach($_POST['EventContent']['discount'] as $key => $discount)
			{				
				$content = EventContent::model()->findByPk($key); 
				$content->discount = $discount; 
				$content->price = round((1 + $content->discount/100) * $content->basePrice, 2); 
				$content->cost = $content->assortmentAmount * $content->price;
				$content->save(); 
			}
		} 
		else 	// при изменении количества
		{ 
			$id = $_POST['eventContentId'][0];
			$content = EventContent::model()->findByPk($id); 
			$deltaAmount =  $_POST['EventContent']['assortmentAmount'][$id] - $content->assortmentAmount; // save difference amount
			$content->assortmentAmount = $_POST['EventContent']['assortmentAmount'][$id]; // chage for the new content
			$item = Assortment::model()->findByPk($content->assortmentId);						
			if($item) 
				$item->reserve($deltaAmount); 
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
	public function actionAdmin_old()
	{
		$model=new EventContent('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EventContent']))
			$model->attributes=$_GET['EventContent'];

		$this->render('admin_old',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EventContent the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EventContent::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EventContent $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-content-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
