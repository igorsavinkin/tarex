<?php
class UserGroupDiscountController extends Controller
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
			array('allow',  
				'actions'=>array('bulkSave'),
				'users'=>array('*'),
			), 
			array('allow', 
				'actions'=>array('index','view', 'create' ),
				'roles'=>array(1,2,3,4,5),
			),
			array('allow', 
				'actions'=>array( 'update'),
				'roles'=>array(1,2,3,4),
			),
			array('allow',  
				'actions'=>array('admin', 'delete'),
				'roles'=>array(1,2,3,4),
			),			
			array('deny',  
				'users'=>array('*'),
			),
		);
	}

 
	public function actionBulkSave()
	{
		//print_r($_POST); 
	}
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
 
	public function actionCreate()
	{
		$model=new UserGroupDiscount; 

		if(isset($_POST['UserGroupDiscount']))
		{
			// сначала мы пытаемся обновить существующую запись по userId и discountGroupId
			if (UserGroupDiscount::model()->updateAll(
				array('value'=>$_POST['UserGroupDiscount']['value']), // обновляемые атрибуты
				' `userId` = :userId  AND `discountGroupId`=:discountGroupId', // query condition
				array(':userId' => $_POST['UserGroupDiscount']['userId'],  ':discountGroupId' => $_POST['UserGroupDiscount']['discountGroupId'] ) // параметры
			)) 
			{	
				echo 'обновили<br>';
				$this->redirect(array('admin'));				
			}
		// если не обновили, тогда заносим значения и сохраняем новую
			else 
			{
				$model->attributes=$_POST['UserGroupDiscount'];
				if($model->save())
					$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
 
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id); 
		
		if(isset($_POST['UserGroupDiscount']))
		{ 
		// сначала мы пытаемся обновить существующую запись по userId и discountGroupId
			if (UserGroupDiscount::model()->updateAll(
				array('value' => $_POST['UserGroupDiscount']['value']), // обновляемые атрибуты
				' `userId` = :userId  AND `discountGroupId`=:discountGroupId', // query condition
				array(':userId' => $_POST['UserGroupDiscount']['userId'],  ':discountGroupId' => $_POST['UserGroupDiscount']['discountGroupId'] ) // параметры
			)) 
			{	
				//echo 'обновили<br>';
				//$model->delete(); // удаляем прежнюю
				$this->redirect(array('admin'));				
			}
		// если не обновили, тогда заносим значения и сохраняем новую
			else 
			{
				$model->attributes=$_POST['UserGroupDiscount'];
				if($model->save())
					$this->redirect(array('admin'));
			}
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
 
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('UserGroupDiscount');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
 
	public function actionAdmin()
	{
		$model=new UserGroupDiscount('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserGroupDiscount']))
			$model->attributes=$_GET['UserGroupDiscount'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	 
	public function loadModel($id)
	{
		//$model=UserGroupDiscount::model()->findByAttributes(array('id'=> $id));
		$model=UserGroupDiscount::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UserGroupDiscount $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-group-discount-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}