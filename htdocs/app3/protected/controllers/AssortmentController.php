<?php
 
class AssortmentController extends Controller
{ 	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			 array(
                'COutputCache',
                'duration'=>1000,
                'varyByParam'=>array('id'),
            ),
			
		);
	} 
	public function accessRules()  
	{     
		return array(     
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array( 'removefromcart', 'view', 'admin', 'admin2', 'index', 'addToCart','addToCartAjax', 'cart', 'checkout', 'clearcart',  'checkoutretail' , 'searchbyvin', 'autocomplete', 'fob', 'test', 'itemInfo',   'SpecialOffer'), 
				'users'=>array('*'),  
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(  'search1'), 
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array( 'load', 'loadSpecialOffer', 'create', 'delete' , 'searchtool', 'update' , 'update2' , 'generateSchneiderNb',  'generateSchneiderNb2', 'fillInSchneiderGr', 'adminbulk' ),
				'roles'=>array(1, 2, 4, 5), 
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}  
	public function actionItemInfo()
	{ 
		$this->renderPartial('popup', array('data'=>$_REQUEST['id']), false,true);
	}
	public function actionSpecialOffer()
	{
		//print_r($_POST);
		if ($_POST['bulk-remome-special-offer'] && $_POST['Assortment']['id'])
		{ 
			$model = new Assortment;
			$model->updateByPk($_POST['Assortment']['id'], array('isSpecialOffer'=>0));
		}
		
		$this->render('specialOffer',array(
			'model'=>new Assortment,
		));
	} 
	public function actionLoadSpecialOffer()
	{
		if(isset($_POST))
		{	
			$upfile = CUploadedFile::getInstance('FileUpload1', 0);
		 	if ($upfile) 			
			{   
			 //	echo '$upfile->name = "', $upfile->name, '"<br>';
			 	if (strstr($upfile->name, 'xlsx'))
				{
					$upfile->saveAs('files/tempSpO.xlsx');
					$file='files/tempSp.xlsx';
					$type='Excel2007';
					// echo 'upfile is saved as .xlsx';					
				} else {
					$upfile->saveAs('files/tempSpO.xls');
					$type='Excel5';	
					$file='files/tempSpO.xls';
					// echo 'upfile is saved as .xls';
				} 
				
				require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';		 
				$objReader = PHPExcel_IOFactory::createReader($type);
				$objPHPExcel = $objReader->load($file); 
				//$as = $objPHPExcel->setActiveSheetIndex(0);	
				$as = $objPHPExcel->getActiveSheet();
				
				$highestRow = $as->getHighestRow(); 				
				$criteria = new CDbCriteria;
				for ($row = 1 + $_POST['firstRow']; $row <= $highestRow; $row++) 
				{ 		 
				  	$value = $as->getCell('A' . $row)->getValue();
				 // echo '<br>', $row, '. row - ', $value ;
					if ('' == $value ) 
					 	continue;
				// накапливаем условие и параметр		
					$criteria->addCondition('article2 = :param'. $row , 'OR');
					$criteria->params += array(':param' . $row =>  $value );
				} 	 
			    // echo 'condition = '; print_r($criteria->condition);
				//echo '<br>params = '; print_r($criteria->params);
				$updated = Assortment::model()->updateAll(array('isSpecialOffer' => 1), $criteria);
				  
				if ($updated) 
					Yii::app()->user->setFlash('success', $updated . ' ' . Yii::t('general', 'rows in Assortment have been set as Special offer') . '.' ); 
				else 	
					Yii::app()->user->setFlash('error', Yii::t('general', "No changes were made in Special Offer"));
				$this->redirect(array($this->route));	
			 } 
		}		
		$this->render('loadSpecialOffer');	
	}
	public function actionLoad()
	{    
		$ShablonId = User::model()->findbypk(Yii::app()->user->id)->ShablonId;
		$loadDataSetting = !empty($ShablonId) ? LoadDataSettings::model()->findByPk($ShablonId) : new LoadDataSettings; 
	// экземпляр номенклатуры для задания начальных склада и организации	
		$assortment = new Assortment;
		$assortment->organizationId = Yii::app()->params['defaultOrganization'];
		$assortment->warehouseId = 8; // склад "Москва 2" 
				
		if(isset($_POST) && isset($_POST['LoadDataSettings']['id']) && isset($_POST['Assortment']))
		{			
			$loadDataSetting = LoadDataSettings::model()->findByPk($_POST['LoadDataSettings']['id']);
			
			$ListNumber = $loadDataSetting->ListNumber;		
			$ColumnNumber = $loadDataSetting->ColumnNumber;  				
			$AmountColumnNumber = $loadDataSetting->AmountColumnNumber;
			$TitleColumnNumber = $loadDataSetting->TitleColumnNumber;
			$PriceColumnNumber = $loadDataSetting->PriceColumnNumber;
		
			$upfile = CUploadedFile::getInstance('FileUpload1', 0);
			if ($upfile) 			
			{   
				echo '$upfile->name = ', $upfile->name, '<br>';
				if (strstr($upfile->name, 'xlsx')){
					$upfile->saveAs('files/temp.xlsx');
					$file='files/temp.xlsx';
					$type='Excel2007';
					//echo 'upfile is saved as .xlsx';					
				}else{
					$upfile->saveAs('files/temp.xls');
					$type='Excel5';	
					$file='files/temp.xls';
					//echo 'upfile is saved as .xls';
				} 
				require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';		 
				$objReader = PHPExcel_IOFactory::createReader($type);
				$objPHPExcel = $objReader->load($file); 
				$as = $objPHPExcel->setActiveSheetIndex( $ListNumber - 1 );	
				$highestRow = $as->getHighestRow();
				$error = '';
				for ($row = 1 + $_POST['firstRow'], $failureCounter=0; $row <= $highestRow; $row++) 
				{ 		 					
				// Создаём новую номенклатуру в складе warehouseId и organizationId 
					$assortment=new Assortment;
					if ($TitleColumnNumber)
						$assortment->title = $as->getCell($TitleColumnNumber . $row)->getValue();		
					$assortment->availability = $as->getCell($AmountColumnNumber . $row)->getValue();
					$assortment->priceS = $as->getCell($PriceColumnNumber . $row)->getValue(); 
					$assortment->article2 = $as->getCell($ColumnNumber . $row)->getValue(); // артикул 
					$assortment->article = substr(array('.', '-', ' '), '', $assortment->article2);
					
				// общая информация	
					$assortment->userId = Yii::app()->user->id; 
					$assortment->date = date('Y-m-d H:i:s'); 
					$assortment->depth = 5; // нормальная глубина для показа в сетке простой позиции 				
				//  $assortment->parentId =  ??; // остаётся вопрос с иерархией родитель-ребёнок
					$assortment->organizationId = $_POST['Assortment']['organizationId']; //  организация
					$assortment->warehouseId = $_POST['Assortment']['warehouseId']; //  склад					
					
					if (!$assortment->save(false)) { 
						$error .= Yii::t('general', 'Failure saving assortment item located at row #') . $row . '<br />'; // конец создания новой номенклатуры
						$failureCounter++;
					}
				} // end 'for' circle
				if (!empty($error)) { 
					Yii::app()->user->setFlash('error', Yii::t('general', "Some rows from the file have not been saved into assortment") . ": <br />" . $error );
				} else { $rows = $highestRow - $_POST['firstRow'] - $failureCounter ;  Yii::app()->user->setFlash('success', $rows . ' ' . Yii::t('general', "rows from the file have been saved into assortment") . '.' ); 	} 				 
				 	
				 
			}  // end if(upfile)
			else  
				Yii::app()->user->setFlash('error', Yii::t('general',  'No file has been loaded...'));
				//echo Yii::t('general', 'No file has been loaded...'); //throw new CHttpException(
	 		
			$this->redirect(array('load')); // переход на GET	
		}// end if(isset($_POST))
		
		$this->render('load', array( 
			'loadDataSetting' => $loadDataSetting, 
			'assortment' => $assortment
		));
	} 	
	
    public function actionView($id)
	{
		$model= $this->loadModel($id);
		if(!$model->Misc)
		{	// формируем тег ALT "на лету" если он пустой
			$model->Misc = $model->title .' - ' .$model->make . ' - ' . $model->model;
			$model->save(false);
		}
		$this->render('view_adv',array(
			'model'=>$model,
		));
	} 
	public function actionAddToCart($id, $amount=null)
	{ 
		// если это запрос в корзину
		if(isset($_GET['id']))
		{
			$item = Assortment::model()->findByPk($_GET['id']);
			Yii::app()->shoppingCart->put($item, $amount ? $amount : 1); 
			$this->redirect(Yii::app()->request->urlReferrer);
		}	 
	}
	public function actionAddToCartAjax()
	{ 
		// если это запрос в корзину
		if(isset($_POST['id']) && isset($_POST['amount']))
		{
			$item = Assortment::model()->findByPk($_POST['id']);
			Yii::app()->shoppingCart->put($item, $_POST['amount']); 
			$cartContent =  Yii::t('general', 'BASKET') . '<br />' . Yii::app()->shoppingCart->getItemsCount() .' ' . Yii::t('general', 'item(s)');
			$cost = Yii::t('general', 'for') . ' ' . Yii::app()->shoppingCart->getCost() . ' '.  Yii::t('general','RUB'); 
			
			echo json_encode( array('cartMsg'=>$cartContent . '<br>'. $cost , 'amount'=>$_POST['amount']  ));
			//echo $cartContent , '<br>', $cost; 
		//	echo 'success';
			//Yii::app()->end();
			//$this->redirect(Yii::app()->request->urlReferrer);
		}	 
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
			/*$arr[$i]['value'][0] =  $item->$field . ', ' . $item->make. ' ' . $item->title; 
			$arr[$i]['value'][1] =  $item->id; */
			}
		return $arr;	
	}
 
	public function actionSearchtool()
	{ 
		$model=new Assortment('search');
		$model->unsetAttributes();  // clear any default values
		 
		if(isset($_GET['Assortment']))
			$model->attributes=$_GET['Assortment'];
			 
		$model->itemSearch = explode(',' , $_GET['Assortment']['itemSearch'])[0];	
		$model->modelMake = explode(',' , $_GET['Assortment']['modelMake'])[0];	
		//echo $model->itemSearch;
		
		$dataProvider = $model->stool();   
 
	  
		$this->render('searchtool',array(
			'model'=>$model, 'dataProvider'=>$dataProvider
		));
	} 
	 
	 
	public function actionCreate()
	{
		$model=new Assortment; 
		if(isset($_POST['Assortment']))
		{
			$model->attributes=$_POST['Assortment'];
			$model->organizationId = Yii::app()->user->organization;
			$model->date = date('Y-m-d H:i:s');
			$uploadedFile=CUploadedFile::getInstance($model, 'imageUrl');
			if ($uploadedFile == null) 
				echo '<br>Failue (or No uploaded) to upload photo'; 
			else 
			{  
				//$model->imageUrl = $uploadedFile->name;  
				if (empty($model->article2)) 
					$model->article2 = $_POST['Assortment']['article'];
				echo 'uploadedFile name = ', $model->article2 .'.jpg'; 
				if ($uploadedFile->saveAs( Yii::app()->basePath .'/../img/foto/'. $model->article2 .'.jpg'))
				{
					echo '<br>photo successfully saved';					
				}
				else 
					echo '<br>failure to save photo';
			}
			
			if($model->save()) 
				//$this->redirect(array('update', 'id'=>$model->id));
				$this->redirect(array('admin'));
		} 
		$this->render('create',array(
			'model'=>$model,  'Subsystem'=>$_GET['Subsystem'], 'Reference'=>$_GET['Reference']
		));
	}  
	
	public function actionUpdate($id)
	{ 
		$model=$this->loadModel($id);

		if(isset($_POST['Assortment']))
		{			 
			$model->attributes=$_POST['Assortment'];
			
			$uploadedFile=CUploadedFile::getInstance($model, 'imageUrl');
			if ($uploadedFile == null)  {}
				//echo '<br>Failue to upload photo(or No uploaded file)'; 
			else 
			{  
				//$model->imageUrl = $uploadedFile->name;  
				//if (empty($model->article)) $model->article = str_replace(array(' ','-','.'), '', $model->article2);
				//echo 'uploadedFile name = ', $model->article2 .'.jpg'; 
				if ($uploadedFile->saveAs( Yii::app()->basePath .'/../img/foto/'. $model->article2 .'.jpg'))
				{
					echo '<br>photo successfully saved';					
				}
				else 
					echo '<br>failure to save photo';
			}
			
			if($model->save()) {}
				$this->redirect(array('admin','id'=>$model->id));
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
	public function findInAssortment($oem)
	{
		$criteria=new CDbCriteria; 
		$criteria->condition = 'oem = '. $oem ; 		//echo 'criteria: '; print_r($criteria); echo '<br>';
		$dataProvider = new CActiveDataProvider('Assortment', array('criteria'=>$criteria));
		//echo ',<b>Assortment by OEM are: </b>'; print_r($dataProvider->getData());	 echo '<br><br>';
		return !empty($dataProvider);
	}
	public function FArraySearchString($str){
		//$Strlen=strlen($str);
		//echo 'str '.$str;
		// $j=0;
		//$ss=mb_substr($str,intval(j),1,'UTF-8');
		//echo $ss;
		$symb=''; $word='';
		for ($j=0; $j<= strlen($str); $j++){
			 //echo 'test'.mb_substr($str,intval(j),1,'UTF-8').'<br>';
			 $symb = substr($str,intval($j),1);
			 //echo $symb;
			 if($symb==' '){
				$Arr[]=$word;
				$word='';
			 }else{
				$word .= $symb;
			 }
		
		}
		$Arr[]=$word;
		
		//print_r($Arr);
		return $Arr;
	
	}

	// главный справочник номенклатуры
	public function actionIndex($id = null, $assort=null, $subgroup=null, $category=null, $groupCategory=null) 	
	{ 		
	 //echo 'beginning groupCategory = ', $_GET['groupCategory'];
	
		$model=new Assortment('search');
		$model->unsetAttributes();  // clear any default values
		if($subgroup) 
		{
			$model->subgroup = $subgroup;
		} 
		
		// page size for the gridview
        try {
			if (Yii::app()->user->isGuest) $pagesize = Yii::app()->params['defaultPageSize'];
		}  catch(Exception $e)  { }  
		//echo '$_GET[pageSize] = ' ,  $_GET['pageSize'];	
        if (isset($_GET['pageSize'])) { 
			//$_GET['pageSize']
            $pagesize = $_GET['pageSize']; 
		//	echo 'pagesize = ' , $pagesize;
            if (!Yii::app()->user->isGuest) Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']); 
        }	 	 
		 		
		// если это запрос в корзину
		if(isset($_POST['Assortment']['id']) && isset($_POST['Assortment']['amount']))
		{ 
			//$identificator = $_POST['Assortment']['id'][0]; когда это массив
			//$identificator = $_POST['Assortment']['id'];
			$identificator = (is_array($_POST['Assortment']['id'])) ? $_POST['Assortment']['id'][0] : $_POST['Assortment']['id']; 
			if (is_scalar($identificator)) 
				$item = Assortment::model()->findByPk($identificator); 
			//echo '$identificator = ', $identificator , '<br>';	
			if ($item && (''!=$item) && $identificator) 
			{
				Yii::app()->shoppingCart->put($item, $_POST['Assortment']['amount'][$identificator]); 
				Yii::app()->user->setFlash('success',  $_POST['Assortment']['amount'][$identificator] . ' ' . Yii::t('general', 'item(s) have been added to cart') . '.');
			} else 
				Yii::app()->user->setFlash('error', Yii::t('general','Failure to add item(s) to the cart')  . '.'); 
		} 
 
		// если поиск по 'findbyoem-value' - из большой формы  	
	       if(isset($_GET['findbyoem-value']) OR isset($_GET['findbyoemvalue']) )
		   {  
			unset($id); // отмена id если $_POST['findbyoem-value']
			AssortmentFake::model()->deleteAll(); 
			//$o_array = array('o', 'O', 'О','о'); // заменить букву О на 0 используя массив букв 'o' на русском и английском
 			//$ref  = str_replace($o_array, '0', trim($_POST['findbyoem-value'])); 
			
			
 			$refined = $_GET['findbyoem-value'] ?  $_GET['findbyoem-value'] : $_GET['findbyoemvalue'];    
			$replaced =  str_replace("`", "", $refined); 
			$replaced4oem =  str_replace(array('.', '-', ' '), "", $replaced); // заменяем точки, тире и пробелы на ничего ТОЛЬКО для поиска по OEM и Артикулу (например здесь 77.01.204.282) 
			//echo '$replaced4oem = ', $replaced4oem;
		    //=============== 1) Сначала ищем по артикулу =========
			$criteria = new CDbCriteria;
			$criteria->condition = ( 'article = :article AND organizationId=7' ); 
			$criteria->params = array(':article' => "{$replaced4oem}" ); 
			$dataProvider = new CActiveDataProvider('Assortment', array(
				'criteria'=>$criteria, 
			)); 
			
			//echo 'test'.$refined;
			
			if (!$dataProvider->itemCount) 
			//===== 2) НЕ НАШЛИ  ПО Артикулу ищем по ОЕМ
			{
				//echo $replaced;
				//echo 'НЕ НАШЛИ В НОМЕНКЛАТУРЕ ПО Артикулу';
				$criteria->condition = ( ' t.oem = :oem AND organizationId = 7' ); 
				$criteria->params = array(':oem' => "{$replaced4oem}" ); 
				$dataProvider = new CActiveDataProvider('Assortment', array(
					'criteria'=>$criteria, 
				)); 
				if ($dataProvider->itemCount){ // ЕСЛИ НАШЛИ ПО ОЕМ ПРОВЕРИМ ПРОИЗВОДИТЕЛЯ
					$foundItem = Assortment::model()->find($criteria);
					if ($foundItem->make == $foundItem->manufacturer && $foundItem->manufacturer != '') { // найден по оem и выполнено условие что make = manufacturer тогда он - полностью оригинальная запчaпсть.	
						$mainAssotrmentItem = 1;  
					}	
				   else { 
					$dataProviderAnalog=new CActiveDataProvider('Assortment', array(
						'criteria'=>$criteria, 
					)); 
					$CriteriaAnalog=$criteria;  

					$f=AssortmentFake::model()->findByAttributes(array('article'=>$foundItem->oem));

						if (empty($f)){
							$fakeAssortment = new AssortmentFake;
							$fakeAssortment->agroup = $foundItem->agroup;
							$fakeAssortment->organizationId = $foundItem->organizationId;
							$fakeAssortment->article = $foundItem->oem;
							$fakeAssortment->oem = $foundItem->oem;
							$fakeAssortment->title = $foundItem->title;
							$fakeAssortment->manufacturer = $foundItem->make;
							$fakeAssortment->fileUrl = mt_rand();
							//$fakeAssortment->save(false);
							try { // мы так ловим исключение чтобы не вставлять дубликат записи 
								   // мы сделали поле oem - уникальное в AssortmentFake
								$fakeAssortment->save(false);
							} catch(Exception $e) { // doing nothing!!!!	 echo $e->getMessage(); 
							}
						}
					
						$mainAssotrmentItem = 0; 
					}
					//echo 'НАШЛИ ПО ОЕМ ПРОВЕРИМ ПРОИЗВОДИТЕЛЯ '.$mainAssotrmentItem;
				
				}// конец if ($dataProviderOEM->itemCount){ // ЕСЛИ НАШЛИ ПО ОЕМ ПРОВЕРИМ ПРОИЗВОДИТЕЛЯ
				else{
					//echo 'Ищем в аналогах';
					//=== 3) Ищем в аналогах ===
					$criteria->condition = ( ' code = :code ' ); 
					$criteria->params = array(':code' => "{$replaced}" ); // $replaced - где только апострофы заменены
					$dataProvider = new CActiveDataProvider('Analogi', array(
						'criteria'=>$criteria, 
					));  
					$FoundedAnalog=Analogi::model()->find($criteria); // ищем только один в Аналогах
					
					//echo ''.$replaced;
					$founded=0;
					if (!$dataProvider->itemCount) {
						//===== 3.1 РЕКРОСС ======
						$criteria = new CDbCriteria;
						$criteria->condition = ( 'oem = :oem' ); 
						$criteria->order = ' "reliability" DESC' ;  // reliability  
						$criteria->params = array(':oem' => "{$replaced}" );   					
						
						$Recross=Analogi::model()->findall($criteria);
						if(!empty($Recross)){
							$it=1; $founded=0;
							foreach ($Recross as $r){
							
								//Проведём отбор кроссов которые есть по нашему номеру
								$Recross2=Analogi::model()->FindAllByAttributes(array('code'=>$r->code));
								foreach ($Recross2 as $r2){
									$MainAssortment=Assortment::model()->FindByAttributes(array('oem'=>$r2->oem));
									if (!empty($MainAssortment)){
										$fakeAssortment = new AssortmentFake;
										//$fakeAssortment->agroup = $foundItem->agroup;
										$fakeAssortment->organizationId = 7;
										$fakeAssortment->article = $r->oem;
										$fakeAssortment->oem = $r->oem;
										$fakeAssortment->title = $r->name;
										//$fakeAssortment->manufacturer = $foundItem->make;
										$fakeAssortment->fileUrl = mt_rand();
										 
										$fakeAssortment->agroup=$MainAssortment->agroup;
										$fakeAssortment->make=$MainAssortment->make;
										$fakeAssortment->save(false);
										
										//$CriteriaAnalog=$criteria;
										$CriteriaAnalog = new CDbCriteria;
										$CriteriaAnalog->condition = ( 'oem = :oem' ); 
										$CriteriaAnalog->params = array(':oem' => $MainAssortment->oem ); 
										
										
										
										$founded=1;
										//echo '1 '.$MainAssortment->id.'/'.$MainAssortment->make;
										
										
										//$criteria->condition = ( 'oem = :oem AND organizationId=7' ); 
										//$criteria->params = array(':oem' => $MainAssortment->oem ); 
										break;
										
									}   
								}
								if ($founded==1) break;
								$it++;
								
							}
								
						
						} //if(!empty($Recross)){
						
					
					}else{ //if (!$dataProvider->itemCount) {
						
					
						
							$CriteriaAnalog=new CDbCriteria;
							$CriteriaAnalog->condition = ( ' oem = :oem AND organizationId=7' ); 
							$CriteriaAnalog->params = array(':oem' => $FoundedAnalog->oem ); 
							//echo 'CriteriaAnalog'.$CriteriaAnalog->condition;
							
							$criteria->condition = ( ' article = :article ' ); 
							$criteria->params = array(':article' => $FoundedAnalog->code ); 
							
							
							$f=AssortmentFake::model()->FindByAttributes(array('article'=>$replaced));

							if (empty($f)){
								$ff=Assortment::model()->findbyattributes(array('oem'=>$replaced));
								$fakeAssortment = new AssortmentFake;
								if (empty($ff)){
								
									//$fakeAssortment->agroup = $foundItem->agroup;
									$fakeAssortment->organizationId = 7;
									$fakeAssortment->article = $replaced;
									//$fakeAssortment->oem = $FoundedAnalog->oem;
									$fakeAssortment->title = $FoundedAnalog->name;
									$fakeAssortment->manufacturer = $FoundedAnalog->brand;
									$fakeAssortment->fileUrl = mt_rand();
								
								}else{
									
									$fakeAssortment->agroup = $ff->agroup;
									$fakeAssortment->organizationId = $ff->organizationId;
									$fakeAssortment->article = $replaced;
									//$fakeAssortment->oem = $FoundedAnalog->oem;
									$fakeAssortment->title = $ff->title;
									$fakeAssortment->manufacturer = $FoundedAnalog->brand;
									$fakeAssortment->fileUrl = mt_rand();

								
								}
							
								try { // мы так ловим исключение чтобы не вставлять дубликат записи 
									   // мы сделали поле oem - уникальное в AssortmentFake
									$fakeAssortment->save(false);
								} catch(Exception $e) { // doing nothing!!!!	 echo $e->getMessage(); 
								}
							}
							
					
					}
					
					//=== 4) Если не нашли ищем по наименованию ===
					if (  $founded==0  ) {  
					
						$ArraySearchString=$this->FArraySearchString($refined);
					  //  $criteria= new CDbCriteria;
						$criteria->condition ='organizationId=7 ';
						//$criteria->params =''; 
						
						foreach ($ArraySearchString as $r){
							
							$Make=Assortment::model()->findbyattributes(array('make'=>$r));
							if (!empty($Make)){
								$criteria->condition .= ( " AND make = '{$Make->make}' "); 
							}else{
								$r = addcslashes($r, '%_"');
								$criteria->condition .= ( " AND title LIKE \"%{$r}%\" "); 
							} 
							//$criteria->params = array (':r'=> "%{$r}%") ; 
						//echo 'Ищем по наименованию';
						}
						//echo $criteria->condition ;
						
						
						// $dataProvider = new CActiveDataProvider('Assortment', array(
							// 'criteria'=>$criteria, 
						// )); 

						
					}else{
						//5) === НИЧЕГО НЕ НАШЛИ ===
						
						
					}
					
				
				
				
				}
				
	
			} //if (!$dataProviderOEM->itemCount) //НЕ НАШЛИ В НОМЕНКЛАТУРЕ ПО Артикулу ищем по ОЕМ
			else{
				//echo 'Нашли по артикулу<br>'; 
				$items = Assortment::model()->findAll( 'article = :article' , array(':article'=>$replaced4oem));
				//echo 'found items are: '; print_r($items); echo '<br><br>';
				$CriteriaAnalogsFromAssortment = new CDbCriteria; 
				foreach($items as $item)
				{// ищем для них соответствия в Аналогах 
					//$CriteriaAnalogsFromAssortment = $CriteriaAnalogsFromAssortment->mergeWith($this->findInAssortment($item->oem)) ;
					if ($this->findInAssortment($item->oem))
						$CriteriaAnalogsFromAssortment->addCondition('oem = "'. $item->oem . '" ' , 'OR');
				}
				if(!empty($CriteriaAnalogsFromAssortment->condition)) $CriteriaAnalogsFromAssortment->addCondition('article != "' . $replaced4oem . '" ');
		 
				//echo '$CriteriaAnalogsFromAssortment:  '; print_r($CriteriaAnalogsFromAssortment ); echo '<br>';
			
			}
	
		} //if(  isset($_POST['findbyoem-value'])  )
		// кладём товар в корзину
		if (Yii::app()->getRequest()->getParam('assort')) 
		{
			$item = $this->loadModel(Yii::app()->getRequest()->getParam('assort'));
			Yii::app()->shoppingCart->put($item);		
			unset($assort);
		}	
// **************** выбор источника данных для таблицы ****************
		if( (!empty($_GET['Assortment']) OR !empty($_GET['groupCategory']) ) && !isset($_GET['findbyoem-value']) && ( !empty($_GET['Assortment']['title'])  OR !empty($_GET['Assortment']['oem'])  OR !empty($_GET['Assortment']['article']) OR !empty($_GET['Assortment']['subgroup']) OR !empty($_GET['Assortment']['groupCategory']) OR !empty($_GET['groupCategory']) OR !empty($_GET['Assortment']['model']) ) && !isset($_GET['id'])   ) 
		{  
		// установление атрибутов модели из входного массива  
			$model->groupCategory = $_GET['groupCategory'];  // если установлен $_GET['Assortment']['groupCategory'] то он перепишет $model->groupCategory в следующей строчке
			$model->attributes=$_GET['Assortment'];
			//echo '<br>inside groupCategory = ', $_GET['groupCategory'];
			//print_r($model);
		//	echo 'attributes: '; print_r($model->attributes);
			// добавляем фильтрацию по марке
			if (isset($_GET['id']))
				$model->make = Assortment::model()->findByPk($_GET['id'])->title; 
			$dataProvider = $model->search();
		//	 echo "\$_GET['Assortment']['groupCategory'] = " ,  $_GET['Assortment']['groupCategory'];
	      // echo '<br> DProvider = '; print_r($dataProvider->criteria);
			//echo 'choose by user input with $_GET["Assortment"]: '; print_r($_GET['Assortment']);
		} 
		
		elseif (!empty($id)) 
		{
			$criteria = new CDbCriteria;
		 
			// выборка по вхождению значения $_GET['Body'] в "title" 	
			if (!empty($_GET['Body']) OR !empty($_GET['Series']) ) 
			{ // если есть уже выбранные кузова, тогда детали   
			  
				if (!empty($_GET['Body'])) {					
					//echo '$_GET[Body] = '; print_r($_GET['Body']); echo '<br>';
					foreach($_GET['Body'] as $body => $series  )
					{
						if ($series != '0') 	$bodies[] = $body;
					} 
				}
				if (!empty($_GET['Series'])) {
					//echo '$_GET[Series] = '; print_r($_GET['Series']); echo '<br>';
					$bodyseries = array_unique($_GET['Body']);				 
					foreach($_GET['Series'] as $seriesid=>$series_name)
					{
						if (in_array($seriesid,  $bodyseries)) continue; // пропускаем этот seriesid
						$bodymodels = Assortment::model()->findAllByAttributes(array('parent_id'=> $seriesid));
						foreach($bodymodels as $bodymodel)
							$bodies[] = $bodymodel->title;
					}
				//	echo '$bodies = '; print_r($bodies); echo '<br>';
					// а если $_GET['Body'] пустой, то тогда мы должны получить все $body для него
					//$GET['Series']
					// проверим есть ли для этой серии соответствующие $_GET['Body']
				}
				if (!empty($bodies)) {
					foreach($bodies as  $value)
					{
					 	//echo 'key = ',  $key , ' value = ',  $value, '<br>'; 
						$criteria->addCondition('title LIKE "%'.   $value  . '%" ', 'OR'); // $key - без пробелов в нём str_replace(' ', '', $key)
						$criteria->addCondition('agroup LIKE "%'.   $value  . '%" ', 'OR'); // $value - c  пробелами в нём 						
					}
					//echo 'criteria = '; print_r($criteria);
				}
				//$criteria->compare('make', Assortment::model()->findByPk($id)->make); 
				$criteria->compare('make', Assortment::model()->findByPk($id)->title); 
				//echo 'choose by $_GET["Body"]: ', print_r($_GET['Body']);
				//echo 'condition <br>'.$criteria->condition;
				
			}
			// вариант выборки всех деталей с той же маркой машины: (поле "make", которое предварительно индексировано, проставлено) - работает намного быстрее чем поиск в рекурсии.
			else { 
			    //$criteria->compare('make', Assortment::model()->findByPk($id)->make); 
				$criteria->compare('make', Assortment::model()->findByPk($id)->title); 
				//print_r($criteria); echo  '<br>';
				//echo 'choose by $id and its make';
			}
	// добавляем условие что единица измерения - не пуста		
        	$criteria->addCondition('`measure_unit` <> "" ');
	// добавляем условие по категории товара (если задано)			
			if ( !empty($_GET['Assortment']['groupCategory']) OR !empty($_GET['groupCategory']) )  
			{			
				$model->groupCategory = isset($_GET['Assortment']['groupCategory']) ? $_GET['Assortment']['groupCategory']  : $_GET['groupCategory'];	 
				$criteria->addCondition('groupCategory = '.  $model->groupCategory);
				//echo '<br>inside $model->groupCategory = ', $model->groupCategory; 				
			}
			
			$dataProvider = new CActiveDataProvider('Assortment', array(
				'criteria'=>$criteria,
				'pagination' => array( 
					'pageSize' => $this->pagesize ? $this->pagesize : Yii::app()->user->pageSize,
				),
			)); 			
			// echo '<br />Data Provider (Find) = '; print_r($dataProvider->criteria);
			//echo '<br />count Data Provider = '; echo count($dataProvider);
			
		} 
		
		elseif (!isset($_GET['findbyoem-value']) && empty($id) ) { 		    
			// $model is new (empty)
			//echo 'model is new (empty)';
			$dataProvider = $model->search();
			// echo '<br> DProvider 2 = '; print_r($dataProvider->criteria);
		}
		
		// if (!$dataProviderOEM->itemCount && !$dataProviderAnalogs1->itemCount && !$DPAnalog->itemCount && !empty($_POST['findbyoem-value']))
		// { 
			//echo 'saving in SearchTerm';	
			// $this->saveInSearchTerm($_POST['findbyoem-value']);				
		// }
	/*	print_r(array(  
				'criteria' => $criteria, 
				'CriteriaAnalog' => $CriteriaAnalog,  	
		));*/
		
		$this->render('index', array(
				'model'=>$model,  
				'parent' => isset($id) ? $id : '', 
				'criteria' => isset($criteria) ? $criteria : '', 
				'CriteriaAnalog' =>  isset($CriteriaAnalog) ? $CriteriaAnalog : '', 
				'CriteriaAnalogsFromAssortment' =>  !empty($CriteriaAnalogsFromAssortment->condition) ? $CriteriaAnalogsFromAssortment : array(), 
				'mainAssotrmentItem' => isset($mainAssotrmentItem) ? $mainAssotrmentItem : '',
			//	'ids'=> $ids , 	
				'bodies'=> isset($bodies) ? $bodies : '',
				'make'=> isset($make) ? $make : '', 		
				'pageSize' => isset($pagesize) ? $pagesize : 33,
				'dataProvider' => $dataProvider, // $DPAnalog, //
				'dataProviderAnalog' => isset($dataProviderAnalog) ? $dataProviderAnalog : '',		
		));
	}
	public function actionAdminbulk()
	{ 
		// если это изменение категории
		if( isset($_POST['category']) && isset($_POST['id']) ) 
	    {
			Assortment::model()->updateByPk($_POST['id'], array('groupCategory'=>$_POST['category']));	
			Yii::app()->end();
		}
		
		$model=new Assortment();  
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Assortment']))
			$model->attributes=$_GET['Assortment'];  
		
		$this->render('adminBulk', array(
			'model'=>$model,  
		)); 		
	}
    public function actionAdmin()
	{
		// перенаправление на действие index
		if (!isset($_GET['return']) && !isset($_GET['returnSparePart'])) 
			$this->redirect(array('index')); 
		
		$model=new Assortment();  
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Assortment']))
			$model->attributes=$_GET['Assortment'];
		
		// если это запрос в корзину
		if(isset($_POST['Assortment']['id']) && isset($_POST['Assortment']['amount']))
		{
			$id = $_POST['Assortment']['id'][0];
			$item = Assortment::model()->findByPk($id);
			Yii::app()->shoppingCart->put($item, $_POST['Assortment']['amount'][$id]); 
		 //	Yii::app()->shoppingCart->put($item, $_POST['Assortment']['amount']);  
		}	
	
        if (isset($_GET['pageSize'])) {
            $pageSize = $_GET['pageSize'];
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        } else 		
			$pageSize = Yii::app()->user->getState('pageSize') ? Yii::app()->user->getState('pageSize') : Yii::app()->params['defaultPageSize'];	 
		
		
		//return;
		if (isset($_GET['returnSparePart'])) 
			$this->render('admin_for_sparepart', array(
				'model'=>$model,  'pageSize'=>$pageSize // ,'returnUrl'=> $returnUrl,
			)); 
		else
			$this->render(isset($_GET['return']) ? 'admin_for_specialoffer' :  'admin', array(
				'model'=>$model,  'pageSize'=>$pageSize // ,'returnUrl'=> $returnUrl,
			)); 	
		
		
	} 
	public function actionCart($id=null)  
	{ 
		$this->render('cart');
	}

	public function actionSearchbyvin($vin)  
	{ 
		$this->render('searchbyvin', array('vin'=>$vin)); 
	}

	public function actionRemovefromcart($id)
	{
		Yii::app()->shoppingCart->remove($id); 
		$this->redirect(array('cart')); 
	} 

	public function actionCheckout($id=null, $statusId=null)  
	{ 
		// оформление заказа для залогиненного пользователя
	 	if (Yii::app()->user->checkAccess(User::ROLE_USER) && !Yii::app()->shoppingCart->isEmpty()) //если роль пользователя клиент оптовый (залогинен) и корзина не пуста  
		{
		// сохраняем корзину как заказ и содержимое заказа (для обработки менеджером)
			$model = new Events;  
			$model->EventTypeId = Events::TYPE_ORDER; // заказ
			$model->organizationId = Yii::app()->user->organization;
			$model->authorId = Yii::app()->user->id;			
			$model->contractorId = Yii::app()->user->id;			
			$model->Begin = date("Y-m-d H:i:s");
			
			$user = User::model()->findByPk( Yii::app()->user->id );
			$model->StatusId = $statusId ? $statusId : Events::STATUS_NEW; // новый 
			$model->Place = /* $address ? $address : */ $user->address; // заносим адрес для заказа
			$model->PaymentType = /* $paymentType ? $paymentType : */ $user->PaymentMethod; // заносим тип оплаты для заказа
			
			if ($model->save(false)) //пустой заказ пока сохраняем, тогда ему присваивается id
			{	
				Yii::app()->params['shopOrder'] = $model->id;// сохраняем id заказа чтобы потом к нему обратиться			
		// cоздаём содержимое этого заказа
				// обращаемся к корзине
				$positions = Yii::app()->shoppingCart->getPositions();
				$totalCost = 0;
				foreach($positions as $position)
				{ 
					$content=new EventContent('simple');
					$content->eventId = $model->id; // только что сохранённого заказа
					$assortment = Assortment::model()->findByPk($position->getId());
					$content->assortmentTitle = $assortment->title; // заносим title номенклатуры из корзины 						
					$content->assortmentArticle = $assortment->article2; // заносим article номенклатуры из корзины 						
					$content->assortmentId = $assortment->id; // заносим id номенклатуры из корзины 						
					$content->price = $position->getPrice();		
					$content->basePrice=$assortment->getCurrentPrice(); // цена в долларах * на стоимость в долларах
					$content->RecommendedPrice=$assortment->getPriceOptMax(); 	// мин цена при максимальной скидке по группе
					$content->assortmentAmount = $position->getQuantity();// заносим количество наименования номенклатуры из корзины 	
					$content->discount = round(($content->price - $content->basePrice) * 100 / $content->basePrice, 2);
					$content->cost = $content->price * $content->assortmentAmount; // заносим cost
					$totalCost += $content->cost;
					if(!$content->save())  
						{ 
							echo 'content saving errors';  
							print_r($content->errors); 
						}						
				}
				$model->totalSum = $totalCost; // занесение общей стоимости заказа на основе стоимости со скидкой
				$model->save(false);  
				
				$orderlink = CHtml::Link(Yii::t('general', 'Order') , CController::createAbsoluteUrl('order/update', array('id'=>$model->id)));	
				
				$from = 'Компания ТАРЕКС <' . Yii::app()->params['adminEmail'] . '>' ;
				$from = '=?UTF-8?B?'.base64_encode($from).'?=';
				
				$subject = Yii::t('general','Created order #') . $model->id ;
				$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
				
				mail($user->email, $subject , Yii::t('general','You have created a new') . ' ' . $orderlink ,   "From: {$from}\r\nContent-type: text/html;\r\n charset=UTF-8\r\nMime-Version: 1.0\r\n");
				
				Yii::app()->shoppingCart->clear(); // Очищаем корзину
				//$model->totalSum = EventContent::getTotalSumByEvent($model->id); // занесение общей стоимости заказа на основе содержимого заказа	- не работает	 
				
		 
				$managerEmail = User::model()->findByPk($user->parentId)->email;				
				mail( $managerEmail, 
					"Пользователь {$user->username} создал новый заказ № {$model->id}", 
					"Посмотреть и оформить его заказ Вы можете по этой ссылке: " . $orderlink ,   
					"From: {$from}\r\nContent-type: text/html;\r\n charset=UTF-8\r\nMime-Version: 1.0\r\n"); 
				
				//echo 'mail is sent to manager ', $managerEmail;
			} else 
			{
				Yii::app()->user->setFlash('error', Yii::t('general', 'Failure to form and save an order'));
			}	  
			//$this->redirect(array('order/update', 'id'=>$model->id));	
		}   
 
		$this->render('checkout',array(
			'user'=>$user, 'orderId' =>Yii::app()->params['shopOrder'], // 'dataProvider'=>$dataProvider,
		));
	} // end of checkout action
	
	public function actionCheckoutretail($id = null)
	{ 
		// определяем пользователя
		if (Yii::app()->user->isGuest)   
			{
				$user = new User('retail');
			    $user->role = User::ROLE_USER_RETAIL;
				$user->organization = Yii::app()->params['organization']; 
			}
		else  
		{   // существующий пользователь
			$user = User::model()->findByPk(Yii::app()->user->id);
			$user->scenario = 'retail';
		}
		
		if(isset($_POST['User'])) // если переданы  данные пользователя (регистрация)
		{
			$user->attributes=$_POST['User'];			
			if ($user->isNewRecord) 
			{
			   $user->created = date("Y-m-d H:i:s");			   
			   $user->isCustomer = 1; // это клиент	
			   $user->password = $user->username; // пароль тот же что и имя пользователя
			   //echo 'new user<br>';
			   $newuser = true;
			} else 
			   $newuser = false;
				
			if ($user->isLegalEntity == 0 && $user->isNewRecord) 
			{
				$user->role = User::ROLE_USER_RETAIL; //echo 'retail user';
			}
			else 
			{
				$user->role = User::ROLE_USER;
				if($newuser) $user->isActive = 0; //  он не активен, так как новый и юр. лицо
				//echo 'legal user<br>gross user<br>not active';
			}
			if ($user->role == User::ROLE_USER_RETAIL && $user->isNewRecord)
			{
				$user->isActive = 1; //  он активен
				$user->Group = 3; // присваиваем ему группу 'розничные'  
			}

			if ($user->save())  // сохранение пользователя
			{ 
// сохраняем корзину как заказ и содержимое заказа (для обработки менеджером)
				$model = new Order; 
				$model->EventTypeId = Events::TYPE_ORDER; // заказ
				$model->Begin= date("Y-m-d H:i:s");
				$model->authorId= $user->id; // заносим идентификатор автора заказа
				$model->contractorId= $user->id; // заносим идентификатор контрагента
				$model->organizationId = Yii::app()->params['organization']; // берём номер организации из конфига системы, так как пока не знаем к какой организаии будет принадлежать новый пользователь и его заказ
				if($user->ShippingMethod == '1') // если самовывоз
					$model->StatusId	= Events::STATUS_REQUEST_TO_RESERVE;
				else // если достaвка или доставка в регионы России через транспортные компании
					$model->StatusId	= Events::STATUS_REQUEST_TO_DELIVERY; 
				//$model->StatusId = $statusId ? $statusId : Events::STATUS_NEW; // новый 
				$model->Place = $user->address; // заносим адрес для заказа
		 		$model->PaymentType =  $user->PaymentMethod ; // заносим тип оплаты для заказа
				
				if ($model->save()) //пустой заказ пока сохраняем, тогда ему присваивается Id
				{		
					Yii::app()->params['shopOrder'] = $model->id;// сохраняем id заказа чтобы потом к нему обратиться		
			// cоздаём содержимое этого заказа
					// обращаемся к корзине
					$positions = Yii::app()->shoppingCart->getPositions();
					$totalCost = 0;
					foreach($positions as $position)
					{
						$content=new EventContent('simple');
						$content->eventId = $model->id; // только что сохранённого заказа
						$assortment = Assortment::model()->findByPk($position->getId());
						$content->assortmentId = $assortment->id; // заносим id номенклатуры из корзины 
						$content->assortmentTitle = $assortment->title; // заносим title номенклатуры из корзины 
						$content->assortmentArticle = $assortment->article2; // заносим article2 номенклатуры из корзины 
						$content->price = $position->getPrice();	
			// добавлено
			/********************************************/
				 		$content->basePrice=$assortment->getCurrentPrice(); // цена в долларах * на стоимость в долларах
						$content->RecommendedPrice=$assortment->getPriceOptMax(); 	// мин цена при максимальной скидке по группе
						$content->assortmentAmount = $position->getQuantity();// заносим количество наименования номенклатуры из корзины 	
						$content->discount = 
						//round(($content->price - $content->basePrice) * 100 / $content->basePrice, 2);	
			/********************************************/		 		
						 
						$content->assortmentAmount = $position->getQuantity();// заносим количество наименования номенклатуры из корзины 	
						$content->cost = $content->price * $content->assortmentAmount; // заносим cost
						$totalCost += $content->cost; 
						if(!$content->save())  
							{ 
								echo 'content saving errors: ';  
								print_r($content->errors); 
							}					
					}					
					$model->totalSum = $totalCost;  
					$model->save();
					Yii::app()->shoppingCart->clear(); // Очищаем корзину			
				}	// end if($model->save()) - конец создания заказа и его содержимого		
			
		  // абсолютные ссылки на профиль и заказ пользователя
					$userprofile = CHtml::Link(Yii::t('general', 'Profile') , CController::createAbsoluteUrl('user/update' , array('id'=>$user->id))); 
					$orderlink = CHtml::Link(Yii::t('general', 'Order') , CController::createAbsoluteUrl('order/update' , array('id'=> $model->id)));	
					if (Yii::app()->user->isGuest) 
						$org = Yii::app()->params['organization'];
					else 
						$org = Yii::app()->user->organization; 
			// массив email'ов старших менеджеров для отправки им писем			
					$srManagerEmails = CHtml::listData(User::model()->findAllByAttributes(array('role'=>User::ROLE_SENIOR_MANAGER, 'organization'=> $org)), 'id', 'email');
				 	//print_r($srManagerEmails);
					$from = '=?UTF-8?B?' . base64_encode('Компания ТАРЕКС <' . Yii::app()->params['adminEmail'] . '>') . '?=' ;
					$subject =  '=?UTF-8?B?' . base64_encode("Регистрация нового клиента '{$user->username}' и новый заказ № {$model->id}") . '?=';
					
					$headers = "From: {$from}\r\nContent-type: text/html;\r\n charset=UTF-8\r\nMime-Version: 1.0\r\n"; 
			// различие между новым и существующим пользователем
					if ($newuser && $user->isLegalEntity)
					{
						 $mailContent = "Вы зарегистрировались в на сайте ТАРЕКС как юридическое лицо и создали заказ. <br>Заявка на регистрацию принята. Ваш заказ принят к проверке. В течение получаса менеджер свяжется с вами и вышлет Вам данные для входа на сайт. <br>По всем вопросам Вы можете позвонить на многоканальный телефон: +7 495 785-88-50."; 
			// письмо и flash клиенту
					 	mail($user->email, "=?UTF-8?B?" . base64_encode('Регистрация на сайте TAREX.ru') . " ?=", $mailContent, $headers );		 
						//echo '<br>mail is sent to ', $user->email , ' (isLegalEntity)<br>';	
						Yii::app()->user->setFlash('success', $mailContent);		
			// письма генеральным (старшим) менеджерам						 
						foreach ($srManagerEmails as $email) 
						{ 	
							//if ('igor.savinkin@gmail.com' != $email) continue;
							mail( $email, $subject, 
							"Уважаемый генеральный менеджер, </br> новый пользователь '<em>{$user->username}</em>' (тел.: {$user->phone}) зарегистрировался на сайте как юр. лицо и создал новый заказ № {$model->id} на сумму {$model->totalSum} рублей. </br>Просим связаться с ним и проставить группу цен и менеджера в его профиле. Посмотреть профиль этого пользователя Вы можете по этой ссылке: {$userprofile}. <br>Там же вам нужно активировать этого нового пользователя чтобы он мог залогиниться в системе.<br>Посмотреть его заказ Вы можете по этой ссылке: {$orderlink}.", 
							$headers);  
						//	echo '<br>mail is sent to ', $email , ' (sr manager)<br>';						
						}							
					}
					elseif ($newuser && !$user->isLegalEntity) 
					{
						$link = CHtml::Link(Yii::t('general', 'Enter') , Yii::app()->createAbsoluteUrl('site/login', array( /*  'email'=>$user->email, 'p'=>$user->password, 'returnUrl'=>CController::createAbsoluteUrl('order/update&id='.  $model->id)*/ )), array('target'=>'_blank')); 
						$mailContent = "Вы только что зарегистрировались как розничный клиент <b>{$user->username}</b>.<br>Ваш логин: <b>{$user->email}</b><br>Ваш пароль: <b>{$user->username}</b><br><br> Вы можете зайти в систему по этой ссылке {$link} и посмотреть Ваш новый заказ: {$orderlink} (после входа). <br>По всем вопросам звонитe на многоканальный телефон: +7 495 785-88-50."; 
				 // письмо  самому клиенту (розница)		 
						mail( $user->email, "=?UTF-8?B?" . base64_encode('Регистрация на сайте TAREX.ru') . " ?=", $mailContent, $headers);
						Yii::app()->user->setFlash('success', $mailContent); 
					   // echo '<br>mail is sent to ', $user->email , ' (is not LegalEntity)<br>';
				// письма генеральным (старшим) менеджерам	
					    foreach ($srManagerEmails as $email) 
						{ 	
							//if ('igor.savinkin@gmail.com' != $email) continue;
							mail( $email, $subject,
							"Уважаемый генеральный менеджер, </br> новый пользователь '<em>{$user->username}</em>' (тел.: {$user->phone}) зарегистрировался на сайте как розничный клиент и создал новый заказ № {$model->id} на сумму {$model->totalSum} рублей. </br>Просим связаться с ним и проставить группу цен и менеджера в его профиле. Посмотреть профиль этого пользователя Вы можете по этой ссылке: {$userprofile}. <br>Также вам нужно активировать этого нового пользователя чтобы он мог залогиниться в системе.<br>Посмотреть его заказ Вы можете по этой ссылке: {$orderlink}.", 
							$headers);  
					 	// echo '<br>mail is sent to ', $email , ' (sr manager)<br>';						
						}
					}	
		// конец посылки писем и flash сообщений для новых пользователей
					elseif (!$newuser) // если этот пользователь - розничный но не новый
					{
						$flashContent = "Ваш {$orderlink} сформирован из содержимого корзины.<br> Дождитесь его обработки.";
						Yii::app()->user->setFlash('success', $flashContent); 
					// розничному клиенту		
						mail( $user->email, "=?UTF-8?B?" . base64_encode('Новый заказ на сайте TAREX.ru') . " ?=", $flashContent, $headers);
					//echo 'msg is sent to retail client on email ', $user->email , '<br>';
					// его менеджеру или админу
					    $managerEmail = (User::model()->findByPk($user->parentId)->email) ? User::model()->findByPk($user->parentId)->email : Yii::app()->params['adminEmail'];
						$subject = 'Новый заказ на сайте TAREX.ru';
						$subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
						$from = '=?UTF-8?B?' . base64_encode('Компания ТАРЕКС <' . Yii::app()->params['adminEmail'] . '>') . '?=' ;
						$headers = "From: {$from}\r\nContent-type: text/html;\r\n charset=UTF-8\r\nMime-Version: 1.0\r\n"; 
						
						mail($managerEmail , $subject , "Пользователь {$user->username} сформировал новый {$orderlink}.", $headers);
						//echo 'mail is sent to ', $managerEmail, '<br>';
					} 
	   // конец flash для существующего пользователя
				} 			
			} // end if($user->save()) 
			 
		
		$this->render('checkoutretail',array(
			'user'=>$user, 'orderId' =>Yii::app()->params['shopOrder'], // 'dataProvider'=>$dataProvider,
		));	
	} 
	 
 	public function actionFob($id=8398) 
	{ 
		$item = $this->loadModel($id);
		//$fob = $item->fob('', date('Y-m-d'), '', '', 1); // only log sql query		
		$fob = $item->fob('', date('Y-m-d')); 		
		echo '<br>result on the assortment item #', $id , '; its total FOB cost = ',  $fob; 
	}   
	 
	public function actionGenerateSchneiderNb()	
	{
		$SchneiderGroup = isset($_GET['old']) ? 'oldSchneiderGroup' : 'newSchneiderGroup';
		
		// найдём последний для данной марки и подгруппы.
		$lastSchNb = $this->findLastSchneiderNb($_POST['Assortment']['make'] , $_POST['Assortment']['subgroup'], $_GET['old']);
		if ($lastSchNb) { 
			$arr =  explode('.' , $lastSchNb);
			$arr[1]++;
			$SchneiderN = implode('.' , $arr);			
		}
		else {
			$schNgroup = SchneiderNgroup::model()->findByAttributes(array('make'=>$_POST['Assortment']['make'], 'subgroup'=>$_POST['Assortment']['subgroup']));			
			$SchneiderN = $schNgroup->$SchneiderGroup .  '.' . '1'; // oldSchneiderGroup  
		}
		echo $SchneiderN;	
	}	
	public function actionTest()
	{
		$schn = $this->findLastSchneiderNb($_GET['make']);
		echo 'The Last Schneider Nb = ', $schn;
	}
	
	public function actionFillInSchneiderGr($make=null)
	{
		$criteria = new CDbCriteria;
		$criteria->distinct = true;
		$criteria->order = 'subgroup ASC';
		$criteria->select = array('subgroup');
		//$criteria->condition =  'subgroup <> "" ';
		$subs = Assortment::model()->findAll($criteria); 
		foreach($subs as $sub)
		{ 
			$subgroups[] =  $sub->subgroup;
		}
		print_r($subgroups);
		
		$criteria2 = new CDbCriteria;
		$criteria2->distinct = true;
		$criteria2->order = 'make ASC';
		$criteria2->select = array('make');
		$criteria2->condition =  'make <> "" ';
		$assortment = Assortment::model()->findAll($criteria2); 
	//	print_r($assortment);
		$id=1;
		foreach($assortment as $assrt)
		{  
			$i=1;
			foreach($subgroups as $subgroup)
			{
				$schNgroup = new SchneiderNgroup;
				$schNgroup->subgroup = $subgroup;
				$schNgroup->make = $assrt->make;
				$schNgroup->oldSchneiderGroup = strtolower(substr ( $schNgroup->make, 0, 4)) . $i;				
				//$schNgroup->save(false);	
				$schNgroup->newSchneiderGroup = $id;		
				$schNgroup->save();
				$id++;				
				echo '<br><br><b>' , $i++ , '.</b> ' ; print_r($schNgroup);
			}			
		}
		
	}
	
	public function actionClearcart()
	{
		Yii::app()->shoppingCart->clear(); // Очищаем корзину	
		$this->redirect(array('cart'));
	}
 	public function loadModel($id)
	{
		$model=Assortment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 
	public function findLastSchneiderNb($make, $subgroup='', $old=0)
	{
		$scheider = ($old==1) ? 'SchneiderOldN' : 'SchneiderN'; // выбор между новым и старым номерами
		$criteria = new CDbCriteria;
		$criteria->order = $scheider . ' DESC';
		$criteria->select= $scheider; // 'SchneiderN';
		$criteria->condition = 'subgroup = "' . $subgroup . '" '; // ставим условие даже ести подгруппа пустая
		$criteria->compare('make', $make);	
		
		$model=Assortment::model()->find($criteria);		
		if($model===null)
			return false;
		return $model->$scheider;
	}
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='assortment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function sendLetter($model, $address = null) // $address - массив  адресов куда посылаем то же письмо. 
	{
		// теперь посылаем письма с подтверждением cоздания события 
			if (!empty($address)) 
				$to = implode(',' , $address); //  посылаем на все адреса указанные в массиве $address
			else 
			{
				$user = User::model()->findByPk(Yii::app()->user->id);
				$to = $user->email; // посылаем на адрес того, кто сейчас залогинен
			}
			$from = Yii::app()->params['adminEmail'];
			//$eventName = EventTypes::model()->findByPk($model->EventTypeId)->Name;
			$subject = 'Подтверждение cоздания заказа № ' . $model->id; 
			$eventLink = CHtml::link('нажмите' , $this->createAbsoluteUrl('events/update', array('id'=>$model->id, '#' => 'tab2')));
			
			//if (!Yii::app()->user->isGuest) 
			//	$cabinet = 'Ваш личный кабинет доступен по данной ссылке: ' . CHtml::link('Профиль' , $this->createAbsoluteUrl('user/settings', array('id'=>Yii::app()->user->id))) . '.'; 
				
		//begin of HTML message 
			$message = <<<EOF
	<html> 
		  <body style='bgcolor:#DCEEFC'> 
				<h4>Здравствуйте <em>{$user->username}</em> <br />
				<font color="red"><b>Вы только что cоздали новый заказ № {$model->id} на общую сумму {$model->totalSum} рублей.</b></font>
				</br>
				Посмотреть ваш заказ Вы можете по данной ссылке - {$eventLink}.</b></h4>
				{$cabinet}
			  <br><br>Искренне Ваша компания "TAREX" <br />
Наш адрес: <b><a href='http://goo.gl/maps/1Chft'>г. Москва, ул. Складочная д. 1, стр., 10</a><br />
Тел: +7 (495) 785-88-50 (многоканальный). <br />
Для региональных клиентов: +7 (495) 785-88-50 ICQ 612-135-517</b><br />

<font color="blue">
E-mail: <a href="mailto:region@tarex.ru">region@tarex.ru</a><br />
E-mail: <a href="mailto:info@tarex.ru">info@tarex.ru</a>
</font>  			  
		  </body>
		</html> 
EOF;
//end of message 
			//$headers  = "From: {$from}\r\n"; 
			//$headers .= "Content-type: text/html\r\n"; 
			$headers = "From: {$from}\r\n Content-type: text/html;\r\n charset=UTF-8\r\nMime-Version: 1.0\r\n";
			$subject =  '=?UTF-8?B?'.base64_encode($subject).'?=';
			
			mail($to, $subject, $message, $headers); 	
			//Yii::app()->user->setFlash('registration', 'Пользователь');
			//$this->redirect(array('site/index','id'=>$model->id));
	}
	public function getCategoryById($data, $row)
	{
		if ($data->groupCategory) 
			//$name = ;
			return Yii::t('general', Category::model()->findByPk($data->groupCategory)->name);
		else 
			return '';
	}
	public function getImage($data, $row)
	{
		$src= Yii::app()->baseUrl . '/img/foto/' . $data->article2 . '.jpg';
		/*try {
			//$image = getimagesize(Yii::app()->basePath . "/../img/foto/" . $data->article2 . ".jpg");
		}  catch(Exception $e)  { } */
		if (getimagesize(  Yii::app()->basePath . "/../img/foto/" . $data->article2 . ".jpg" /**/) !== false)
			return "<a class='test-popup-link' href='{$src}'>". CHtml::tag("img", array("src" =>$src, "height"=>40, "width"=>40)) . '</a>';		
			else  
				return Yii::t('general','no image'); 
	}
	protected function amountToCart($data,$row)
    {  
		//$button = CHtml::imageButton('/img/cart.gif', array('width'=>'23px', 'style'=>'vertical-align:top;', 'id'=>'x-button', 'value'=>$data->id,  'name'=>'Assortment[id]'));		
	    $button = CHtml::submitButton(Yii::t('general','Add to Cart'), array('class'=>'btn btn-xs btn-primary' , 'name'=>$data->id ) ); 
		
		// $data ... the current row data   
        // $row ... the row index 
	   $dataArr = array(); for($i=1; $i <= $data->availability; $i++ ) { $dataArr[$i] = $i; }
	   $dd = CHtml::dropDownList('Assortment[amount][' . $data->id .']', 1, $dataArr, array('style'=>'width:40px'));
		
		//$textField =  CHtml::textField('Assortment[amount][' . $data->id .']', 1, array('size'=>3));
		return /*$textField*/ $dd  . '&nbsp;' . $button; 		
    }
	protected function amountToCartAjax($data,$row)
    {   
		if (!$data->availability) return '';
		//CHml::Link('Make a request to manager', 'searchTerm/create');
		
		$msg = Yii::t('general','item(s) have been added to cart');
		$buttonAjax = CHtml::ajaxSubmitButton(Yii::t('general', 'Add to Cart'), array('addToCartAjax'), array( 'data'=>'js:{id: this.name, amount: jQuery(this).siblings().val(), "' . Yii::app()->request->csrfTokenName . '": "' . Yii::app()->request->csrfToken . '" }'/*, 'update'=>'#cart-content'*/ , 'success'=>'js:/*var amt = jQuery(this).siblings().val(); console.log(amt); */ function(data){var obj=JSON && JSON.parse(data) || $.parseJSON(data); $("#cart-content").html(obj.cartMsg); alert( obj.amount + " '. $msg. '"); }'), array('class'=>'btn btn-xs btn-primary', 'name' =>  $data->id ));  
		
		// $data ... the current row data   
        // $row ... the row index 
	   $dataArr = array(); for($i=1; $i <= $data->availability; $i++ ) { $dataArr[$i] = $i; }
	   $dd = CHtml::dropDownList('Assortment[amount][' . $data->id .']', 1, $dataArr, array('style'=>'width:40px;'));
	    $textField = CHtml::textField('Assortment[amount][' . $data->id .']' , 1,  array('style'=>'width:40px;')); 
		return $textField  . '&nbsp;' . $buttonAjax; 		
    }	
	public function info($data, $row)
	{ 
		$info = CHtml::tag("img", array("src" =>   Yii::app()->baseUrl . "/images/infoblue.png" ));
		$infofoto = CHtml::tag("img", array("src" =>   Yii::app()->baseUrl . "/images/camerainfoblue.png" ));
		$action = Yii::app()->user->checkAccess(User::ROLE_SENIOR_MANAGER) ?'update' : 'view';
		/*try {
			//$image = getimagesize(Yii::app()->basePath . "/../img/foto/" . $data->article2 . ".jpg");
		}  catch(Exception $e)  { } */
		if (getimagesize(Yii::app()->basePath . "/../img/foto/" . $data->article2 . ".jpg" ) !== false)
			echo CHtml::Link($infofoto, array($action, 'id'=>$data->id),  array('target'=>'_blank')); 	 
		else  
            echo CHtml::Link($info, array($action, 'id'=>$data->id),  array('target'=>'_blank')); 
	}
	public function infoPopup($data, $row)
	{ 
		$info = CHtml::tag("img", array("src" =>   Yii::app()->baseUrl . "/images/infoblue.png" ));
		$infofoto = CHtml::tag("img", array("src" => Yii::app()->baseUrl . "/images/camerainfoblue.png" )); 
		if (getimagesize(Yii::app()->basePath . "/../img/foto/" . $data->article2 . ".jpg" ) !== false)
			echo CHtml::Link($infofoto, '',  array('class'=>'info-link', 'id' => 'image-' . $data->id)); 	 	 
		else  
            echo CHtml::Link($info, '',  array('class'=>'info-link', 'id' => 'item-' . $data->id)); 
	}
}
?> 