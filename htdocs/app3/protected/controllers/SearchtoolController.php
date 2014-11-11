<?php
class SearchtoolController extends Controller
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
				'actions'=>array( 'admin','admin2', 'autocomplete'), 
				'users'=>array('@'),  
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}  
   
	public function actionAutocomplete($term)
	{  
	    $searchFields=array('oem', 'article');
	    $searchModelFields=array('make', 'model');
		$arr = array();
		$fields =  $_GET['type']  ? $searchModelFields : $searchFields;
		foreach($fields as $field)
			$arr += $this->getByTerm($term, $field);
			
		echo json_encode($arr); 
	}    
	public function getByTerm($term, $field = 'oem')
	{
	    $criteria = new CDbCriteria;
		//$criteria->distinct = true;
		$criteria->order = $field .' ASC';
		$criteria->select = array($field . ', title, id, make'); 
		$criteria->compare('organizationId', Yii::app()->user->organization);
		$criteria->addCondition('article <> "" '); // исключаем так все не запчасти
		$criteria->compare( $field, $term, true);
	 	$arr = array();    
		$i=0;
		foreach(Assortment::model()->findAll($criteria) as $item) {
			$arr[$item->id] =  $item->$field . ', ' . $item->make. ' ' . $item->title; 
			}
		return $arr;	
	}
 
	public function actionAdmin()
	{
	
		$this->layout = '//layouts/FrontendLayoutPavel'; 
		/*
		$this->layout = '//layouts/FrontendLayoutPavel'; 
		$model=new Assortment('search');
		$model->unsetAttributes();  // clear any default values
	 	$user=new User();		
		$user->unsetAttributes();  // clear any default values
		$searchTerm=new SearchTerm();		
		$searchTerm->unsetAttributes();  // clear any default values
	
	// номенклатура	 
		if(isset($_GET['Assortment']))
			$model->attributes=$_GET['Assortment'];
		$model->itemSearch = explode(',' , $_GET['Assortment']['itemSearch'])[0];	
		$model->modelMake = explode(',' , $_GET['Assortment']['modelMake'])[0];			
		$dataProvider = $model->stool();  
		if (!$dataProvider->itemCount)	// заносим в searchTerm ненайденные данные
		{
			if($model->itemSearch != '') 
				Controller::saveInSearchTerm($model->itemSearch); 
			if($model->modelMake != '') 
				Controller::saveInSearchTerm($model->modelMake); 
		} 
	// пользователи	
	    if(isset($_GET['User']))
			$user->attributes=$_GET['User']; 
		$dataProviderUser = $user->stool();
		
	// запрос на новую позицию
		if(isset($_GET['searchTerm']))
			Controller::saveInSearchTerm($_GET['searchTerm'], $_GET['marketPrice'], $_GET['relatedClientId']);  
	  
	// если это запрос в корзину
		if(isset($_POST['Assortment']['id']) && isset($_POST['Assortment']['amount']))
		{
			$item = Assortment::model()->findByPk($_POST['Assortment']['id']);
			Yii::app()->shoppingCart->put($item, $_POST['Assortment']['amount']); 
			$this->redirect(array('admin'));
		}
	
	// Car Index (by engine and other parameters)	
		$criteria = new CDbCriteria();
		$criteria->distinct=true;     
		$criteria->select = 't.model';		 	
		if ($model->model) 
			$criteria->compare('model', $model->model, true);
		$distinctModels = Assortment::model()->findAll($criteria); 
		$cararray=array();
		$i=0;
		foreach ($distinctModels as $dm)
		{			
			if(!empty($dm->model)) 
			{
				$cararray[$i]['model']=$dm->model;
				$a = Assortment::model()->find("model ='{$dm->model}' ");
				$cararray[$i]['make']=$a->make;
				$cararray[$i++]['country']=$a->country; 
			}
		}  
		//print_r($cararray); exit;     
		 
		$arrayDataProviderCarIndex = new CArrayDataProvider( $cararray, array(
			//'model'=>'model',
			'sort'=>array( 
               'attributes'=>array( 
                   'model', 'make', 
               ), 
           ),
		));  
		$dataProviderCarIndex = new CActiveDataProvider( Assortment, array(
			'criteria'=>$criteria,
		));   
		*/
		
		$this->render('admin',array(
			'user'=>$user,
			'model'=>$model,
			'searchTerm'=>$searchTerm,
			'dataProvider'=>$dataProvider, 
		    'dataProviderUser'=>$dataProviderUser,
		    'dataProviderCarIndex'=>$dataProviderCarIndex,
		    'arrayDataProviderCarIndex'=>$arrayDataProviderCarIndex,
		));
	} 
	
	public function actionAdmin2()
	{
		//$this->layout = '//layouts/simple'; 
		$model=new Assortment('search');
		$model->unsetAttributes();  // clear any default values
	 	$user=new User();		
		$user->unsetAttributes();  // clear any default values
		$searchTerm=new SearchTerm();		
		$searchTerm->unsetAttributes();  // clear any default values
	
	// номенклатура	 
		if(isset($_GET['Assortment']))
			$model->attributes=$_GET['Assortment'];
		$model->itemSearch = explode(',' , $_GET['Assortment']['itemSearch'])[0];	
		$model->modelMake = explode(',' , $_GET['Assortment']['modelMake'])[0];			
		$dataProvider = $model->stool();  
		if (!$dataProvider->itemCount)	// заносим в searchTerm ненайденные данные
		{
			if($model->itemSearch != '') 
				Controller::saveInSearchTerm($model->itemSearch); 
			if($model->modelMake != '') 
				Controller::saveInSearchTerm($model->modelMake); 
		} 
	// пользователи	
	    if(isset($_GET['User']))
			$user->attributes=$_GET['User']; 
		$dataProviderUser = $user->stool();
		
	// запрос на новую позицию
		if(isset($_GET['searchTerm']))
			Controller::saveInSearchTerm($_GET['searchTerm'], $_GET['marketPrice'], $_GET['relatedClientId']);  
	  
	// если это запрос в корзину
		if(isset($_POST['Assortment']['id']) && isset($_POST['Assortment']['amount']))
		{
			$item = Assortment::model()->findByPk($_POST['Assortment']['id']);
			Yii::app()->shoppingCart->put($item, $_POST['Assortment']['amount']); 
			$this->redirect(array('admin'));
		}
	
	// Car Index (by engine and other parameters)	
		$criteria = new CDbCriteria();
		$criteria->distinct=true;     
		$criteria->select = 't.model';		 	
		if ($model->model) 
			$criteria->compare('model', $model->model, true);
		$distinctModels = Assortment::model()->findAll($criteria); 
		$cararray=array();
		$i=0;
		foreach ($distinctModels as $dm)
		{			
			if(!empty($dm->model)) 
			{
				$cararray[$i]['model']=$dm->model;
				$a = Assortment::model()->find("model ='{$dm->model}' ");
				$cararray[$i]['make']=$a->make;
				$cararray[$i++]['country']=$a->country; 
			}
		}  
		//print_r($cararray); exit;     
		 
		$arrayDataProviderCarIndex = new CArrayDataProvider( $cararray, array(
			//'model'=>'model',
			'sort'=>array( 
               'attributes'=>array( 
                   'model', 'make', 
               ), 
           ),
		));  
		$dataProviderCarIndex = new CActiveDataProvider( Assortment, array(
			'criteria'=>$criteria,
		));  
		
		
		$this->render('admin2',array(
			'user'=>$user,
			'model'=>$model,
			'searchTerm'=>$searchTerm,
			'dataProvider'=>$dataProvider, 
		    'dataProviderUser'=>$dataProviderUser,
		    'dataProviderCarIndex'=>$dataProviderCarIndex,
		    'arrayDataProviderCarIndex'=>$arrayDataProviderCarIndex,
		));
	} 
}