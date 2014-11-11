<?php  
class WarehouseController extends Controller {
	
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
	public function loadModel($id)
	{
		$model=Warehouse::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionAdmin()
	{
		$model=new Warehouse('search'); //!!! “олько здесь мен€ем 
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Warehouse']))
			$model->attributes=$_GET['Warehouse'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 	
	
	public function actionIndex()
	{
		$model=new Warehouse('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Warehouse']))
			$model->attributes=$_GET['Warehouse'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 
	
	public function actionUpdate($id)
	{	
		if( $id == 'new' ){
			$model=new Warehouse;   
		// ѕрисвоить ид и организацию 
			$model->id = Warehouse::model()->find(array('order'=>'id DESC'))->id + 1; 
			$model->organizationId = Yii::app()->user->organization; 
			$model->name = '';  
		
		} else { 
			$model = Warehouse::model()->findByPk($id);			
		} 

		if(isset($_POST['Warehouse']))
		{ 
			$model->attributes=$_POST['Warehouse'];  
			if($model->save()) 
			{
				if ($_POST['save&close'])
					$this->redirect(array('admin'));
			} //
		}
		
	// получение шаблона загрузки номенклатуры согласно настройкам пользовател€	
		$ShablonId = User::model()->findByPk(Yii::app()->user->id)->ShablonId;
		//echo '$ShablonId =', $ShablonId;
		$loadDataSetting = !empty($ShablonId) ? LoadDataSettings::model()->findByPk($ShablonId) : new LoadDataSettings; 
		//echo 'load data settings = ' ; print_r($loadDataSetting);
	// обработка загружаемого файла
		if (isset($_POST['load-btn']) && isset($_POST['LoadDataSettings']['id'])) 
		{ 
			$upfile = CUploadedFile::getInstance('FileUpload1', 0);
			if ($upfile) 			
			{   
				$loadDataSetting = LoadDataSettings::model()->findByPk($_POST['LoadDataSettings']['id']);	
				$ListNumber = $loadDataSetting->ListNumber;		
				$ColumnNumber = $loadDataSetting->ColumnNumber;  				
				$AmountColumnNumber = $loadDataSetting->AmountColumnNumber;
				$TitleColumnNumber = $loadDataSetting->TitleColumnNumber;
				$PriceColumnNumber = $loadDataSetting->PriceColumnNumber;
				echo '$upfile->name = ', $upfile->name, '<br>';
				if (strstr($upfile->name, 'xlsx')){
					$upfile->saveAs('files/temp.xlsx');
					$file='files/temp.xlsx';
					$type='Excel2007';
					echo 'upfile is saved as .xlsx';					
				}else{
					$upfile->saveAs('files/temp.xls');
					$type='Excel5';	
					$file='files/temp.xls';
					echo 'upfile is saved as .xls';
				} 
			}
			require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';		 
			$objReader = PHPExcel_IOFactory::createReader($type);
			$objPHPExcel = $objReader->load($file); 
			$as = $objPHPExcel->setActiveSheetIndex( $ListNumber - 1 );	
			$highestRow = $as->getHighestRow();
			$error = '';
			for ($row = 1 + $_POST['firstRow'], $failureCounter=0; $row <= $highestRow; $row++) 
			{ 		 					
			// —оздаЄм новую номенклатуру в складе warehouseId и organizationId 
				$assortment=new Assortment;
				if ($TitleColumnNumber)
					$assortment->title = $as->getCell($TitleColumnNumber . $row)->getValue();		
				$assortment->availability = $as->getCell($AmountColumnNumber . $row)->getValue();
				$assortment->priceS = $as->getCell($PriceColumnNumber . $row)->getValue(); 
				$assortment->article2 = $as->getCell($ColumnNumber . $row)->getValue(); // артикул 
				$assortment->article = substr(array('.', '-', ' '), '', $assortment->article2);
				
			// обща€ информаци€	
				$assortment->userId = Yii::app()->user->id; 
				$assortment->date = date('Y-m-d H:i:s'); 
				$assortment->depth = 5; // нормальна€ глубина дл€ показа в сетке простой позиции 				
			//  $assortment->parentId =  ??; // остаЄтс€ вопрос с иерархией родитель-ребЄнок
				$assortment->organizationId = $model->organizationId; //  организаци€, беретс€ из модели склада
				$assortment->warehouseId = $model->id; //  id складa беретс€ из модели склада			
				
				if (!$assortment->save(false)) { 
					$error .= Yii::t('general', 'Failure saving assortment item located at row #') . $row . '<br />'; // конец создани€ новой номенклатуры
					$failureCounter++;
				}
			} // end 'for' circle
			if (!empty($error)) { 
				Yii::app()->user->setFlash('error', Yii::t('general', "Some rows from the file have not been saved into assortment") . ": <br />" . $error );
			} else { $rows = $highestRow - $_POST['firstRow'] - $failureCounter ;  Yii::app()->user->setFlash('success', $rows . ' ' . Yii::t('general', "rows from the file have been saved into assortment") . '.' ); 	} 	
			
			
	    } // конец обработки загружаемого файла		

		
		$this->render('update' , array(
			'model'=>$model,
			'loadDataSetting'=>$loadDataSetting,
		));
	} 
	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete(); 
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}	
}