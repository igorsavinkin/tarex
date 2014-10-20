<?php  
class CategoryController extends Controller {
	
	public function accessRules()
	{
		return array( 
			array('allow', 
				'actions'=>array('update','admin','index','create','delete', 'setCategory'),
				'roles'=>array(1, 2, 4, 5),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionCreate()
	{
		$model=new Category('insert');    
		$model->isActive = 1;  
		
		if(isset($_POST['Category']))
		{ 
			$model->attributes=$_POST['Category'];
		 
			$uploadedFile=CUploadedFile::getInstance($model,'image');
			if ($uploadedFile == null) 
				echo '<br>Failue to Upload photo'; 
			else 
			{  
				$model->image =  $uploadedFile->name;  
				//echo '<br>uploadedFile name = ', $model->image; 
				if ($uploadedFile->saveAs( Yii::app()->basePath .'/../images/subgroups'. $uploadedFile->name))
				{
					//echo '<br>photo successfully saved';					
				}
				else 
					echo '<br>Failure to Save photo';
			}			
			if($model->save())
				//$this->redirect(array('admin'));	
				$this->redirect(array('update', 'id'=>$model->id));				
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionAdmin()
	{
		$model=new Category('search'); //!!! Только здесь меняем 
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 	
	
	public function actionIndex()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 
	
	public function actionUpdate($id)
	{	
		$model = Category::model()->findByPk($id);			

		if(isset($_POST['Category']))
		{ 
			$_POST['Category']['image'] = $model->image;// сохраняем предыдущее имя загруженного файла
			
			$model->attributes=$_POST['Category'];  
			$uploadedFile=CUploadedFile::getInstance($model,'image'); 
			// если старое имя пустое, тогда мы в него кладём то что из загружаемого файла
			if (empty($model->image)) 
				$model->image = $uploadedFile->name;
				
			if($model->save())
			{
				if(!empty($uploadedFile))  // check if uploaded file is set or not
                { // сохраняем новый файл со старым(или новым) именем из $model->image			
					if($uploadedFile->saveAs(Yii::app()->basePath . '/../images/subgroups/' . $model->image))
					{
				//	 echo '<br>Uploaded file is saved! path is:  ', Yii::app()->basePath . '/../images/subgroups/' . $model->image; 
					} 
					else
						echo '<br>Failure saving uploaded file; the path to save is ', Yii::app()->basePath . '/../images/subgroups/' . $model->image;
                } else 
				{ 
					echo '<br>Uploaded file is empty!';
				}
				$this->redirect(array('admin'));				
			} 
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
	public function translated($data, $row)
	{
		return Yii::t('general', $data->name);
	}
	public function getCategoryById($data, $row)
	{
		$name = Category::model()->findByPk($data->id)->name;
		return Yii::t('general', $name);
	}
	
	public function actionSetCategory()
	{
		$categories = Category::model()->findAll();
		/* теперь перевод берём из файла локализации: 
		app3\protected\messages\ru\general.php
		$cats=array( ''=>'',
							'OPTICS'=>'ОПТИКА',  
							'BRAKES'=>'ТОРМОЗНАЯ СИСТЕМА',  
							'ELECTRICS'=>'ЭЛЕКТРИКА',  
							'CAR BODY'=>'ДЕТАЛИ КУЗОВА',   
							'COOLING SYSTEM'=>'СИСТЕМА ОХЛАЖДЕНИЯ',    
							'CHASSIS SYSTEM'=>'ХОДОВАЯ СИСТЕМА',  
							'SUSPENSION SYSTEM'=>'СИСТЕМА ПОДВЕСКИ',  
							'HYDRAULIC SYSTEM'=>'ГИДРАВЛИЧЕСКАЯ СИСТЕМА');	 
							*/
		$i=1;
		$couter=0;
		echo '<h2>Скрипт по проставлению id категории в "groupCategory" для различных подгрупп из поля "subgroup". </h2><h4>Количество обновлённых записей по подгруппам:</h4>'; 
		foreach($categories as $category)
		{			
			//$nameInRussian = $cats[$category->name];
			$nameInRussian = Yii::t('general', $category->name);
			echo $i++, '. ' , $nameInRussian, ': '; 
			$updatedrows[$nameInRussian] = Assortment::model()->updateAll(array('groupCategory'=>$category->id) , "subgroup = '{$nameInRussian}' ");	
			$couter += $updatedrows[$nameInRussian];
			if (0 !=  $updatedrows[$nameInRussian]) 
				echo '<b>', $updatedrows[$nameInRussian]  , ' записей обновлено.</b><br>';
			else 
				echo $updatedrows[$nameInRussian]  , ' записей обновлено.<br>';
		}  
		// пустые подгруппы - для них ставим "groupCategory = 0"
		echo $i++, '. ' ,   '<пустая подгруппа>: '; 
		$updatedrows[''] = Assortment::model()->updateAll(array('groupCategory'=>0) , "subgroup = '' "); 
		echo $updatedrows[''] , ' записей обновлено';
		$couter += $updatedrows[''];
		echo '<br>Всего <b>', $couter  ,  '</b> записей обновлено';
		//print_r($updatedrows);
	}	
}