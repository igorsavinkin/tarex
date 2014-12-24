<?php
AssortmentFake::model()->deleteAll(); 		
$refined = $_POST['search-value'];    //echo 'refined:'.$refined;
$replaced =  str_replace("`", "", $refined); 
$replaced4oem =  str_replace(array('.', '-', ' '), "", $replaced); // заменяем точки, тире и пробелы на ничего ТОЛЬКО для поиска по OEM и Артикулу (например здесь 77.01.204.282) 
//echo '$replaced4oem = ', $replaced4oem;
//=============== 1) Сначала ищем по артикулу =========
$criteria = new CDbCriteria;
$criteria->condition = ( 'article = :article AND organizationId=' . Yii::app()->params['organization']); 
$criteria->params = array(':article' => "{$replaced4oem}" ); 
$dataProvider = new CActiveDataProvider('Assortment', array(
	'criteria'=>$criteria, 
)); 
if (!$dataProvider->itemCount) 
//===== 2) НЕ НАШЛИ  ПО Артикулу ищем по ОЕМ
{ 
	//echo 'НЕ НАШЛИ В НОМЕНКЛАТУРЕ ПО Артикулу';
	$criteria->condition = ( ' t.oem = :oem AND organizationId = ' . Yii::app()->params['organization'] ); 
	$criteria->params = array(':oem' => "{$replaced4oem}" ); 
	$dataProvider = new CActiveDataProvider('Assortment', array(
		'criteria'=>$criteria, 
	)); 
	if ($dataProvider->itemCount){ // ЕСЛИ НАШЛИ ПО ОЕМ ПРОВЕРИМ ПРОИЗВОДИТЕЛЯ
		$foundItem = Assortment::model()->find($criteria);
		if ($foundItem->make == $foundItem->manufacturer && $foundItem->manufacturer != '') { // найден по оem и выполнено условие что make = manufacturer тогда он - полностью оригинальная запчaпсть.	
			$mainAssotrmentItem = 1;  
		}	
		else 
		{ 
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
	
	}// конец if ($dataProvider->itemCount){ //по OEM // ЕСЛИ НАШЛИ ПО ОЕМ ПРОВЕРИМ ПРОИЗВОДИТЕЛЯ
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
							$fakeAssortment->organizationId = Yii::app()->params['organization'];
							$fakeAssortment->article = $r->oem;
							$fakeAssortment->oem = $r->oem;
							$fakeAssortment->title = $r->name;
							//$fakeAssortment->manufacturer = $foundItem->make;
							$fakeAssortment->fileUrl = mt_rand();
							 
							$fakeAssortment->agroup=$MainAssortment->agroup;
							$fakeAssortment->make=$MainAssortment->make;
							$fakeAssortment->save(false); 
							
							$CriteriaAnalog = new CDbCriteria;
							$CriteriaAnalog->condition = ( 'oem = :oem' ); 
							$CriteriaAnalog->params = array(':oem' => $MainAssortment->oem );  
							
							$founded=1;
							//echo 'MainAssortment' . $MainAssortment->id . '/' . $MainAssortment->make; 
							
							//$criteria->condition = ( 'oem = :oem AND organizationId=7' ); 
							//$criteria->params = array(':oem' => $MainAssortment->oem ); 
							break; 
						}   
					}
					if ($founded==1) break;
					$it++; 
				} 
			
			} //if(!empty($Recross)){ 
			
		}
		else
		{ // if (!$dataProvider->itemCount) { 
			$CriteriaAnalog=new CDbCriteria;
			$CriteriaAnalog->condition = ( ' oem = :oem AND organizationId=' . Yii::app()->params['organization']); 
			$CriteriaAnalog->params = array(':oem' => $FoundedAnalog->oem ); 
			//echo 'CriteriaAnalog '.$CriteriaAnalog->condition;
			
			$criteria->condition = ( ' article = :article ' ); 
			$criteria->params = array(':article' => $FoundedAnalog->code );  
			
			$f=AssortmentFake::model()->FindByAttributes(array('article'=>$replaced));

			if (empty($f)){
				$ff=Assortment::model()->findbyattributes(array('oem'=>$replaced));
				$fakeAssortment = new AssortmentFake;
				if (empty($ff)){ 
					$fakeAssortment->organizationId = Yii::app()->params['organization'];
					$fakeAssortment->article = $replaced; 
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
			$ArraySearchString=explode(' ', $refined); // $ArraySearchString=$this->FArraySearchString($refined);
			
		  //  $criteria= new CDbCriteria;
			$criteria->condition ='organizationId= ' . Yii::app()->params['organization'];
		 
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
} //if (!$dataProviderOEM->itemCount) // НЕ НАШЛИ В НОМЕНКЛАТУРЕ ПО Артикулу ищем по ОЕМ 
else
{
	//echo 'Нашли по артикулу<br>'; 
	$items = Assortment::model()->findAll( 'article = :article' , array(':article'=>$replaced4oem));
	//echo 'found items are: '; print_r($items); echo '<br><br>';
	$CriteriaAnalogsFromAssortment = new CDbCriteria; 
	foreach($items as $item)
	{// ищем для них соответствия в Аналогах  
		//echo '<br><br>item = ';print_r($item); 
		if( Assortment::model()->count('oem = "'. $item->oem . '"') <> '0') $CriteriaAnalogsFromAssortment->addCondition('oem = "'. $item->oem . '" ' , 'OR');
	}
	if(!empty($CriteriaAnalogsFromAssortment->condition)) $CriteriaAnalogsFromAssortment->addCondition('article != "' . $replaced4oem . '" ');
}
/*
echo '$_POST[search-value]: ', $_POST['search-value'];
echo '<br>criteria: <b>'; print_r($criteria->condition); echo '</b>';
echo ';  criteria params: <b>'; print_r($criteria->params); echo '</b>';
echo '<br>CriteriaAnalog: <b>'; print_r($CriteriaAnalog->condition); echo '</b>';
echo '<br>CriteriaAnalogsFromAssortment: <b>'; print_r($CriteriaAnalogsFromAssortment->condition); echo '</b>';
echo '<br><br>mainAssotrmentItem: ', $mainAssotrmentItem;
*/

// the beginning of the output based upon the criteria and DataProvider
	if (!empty($criteria) && !$dataProvider->itemCount  )	{ 
		//echo '<br>1st case <br>!empty($criteria) && !$dataProvider->itemCount'; 
		$dataProvider = new CActiveDataProvider('Assortment', array(
			'criteria'=>$criteria,
			 'pagination' => false, /* array(							
				'pageSize' =>isset($pagesize) ? $pagesize : Yii::app()->params['defaultPageSize'],
			 ),*/
		));		
	} 
	
	if(!empty($CriteriaAnalog) && $dataProvider->itemCount){
		 //echo '<br>2nd case <b>!empty($CriteriaAnalog) && $dataProvider->itemCount</b>'; 
		$dataProvider = new CActiveDataProvider('AssortmentFake', array(						'pagination' =>false,
		));		
		$dataProviderAnalog = new CActiveDataProvider('Assortment', array(
						'criteria'=>$CriteriaAnalog,
						'pagination' =>false, 
		));	
	}

	if (!empty($CriteriaAnalogsFromAssortment->condition)) 
	{  
	 // echo '<br>3-d case '; 
	  //</h4> $CriteriaAnalogsFromAssortment: ';	   print_r($CriteriaAnalogsFromAssortment);
	   $dataProviderAnalog = new CActiveDataProvider('Assortment', array(
						'criteria'=>$CriteriaAnalogsFromAssortment,
						'pagination' =>false, 
		));	
	}	


if ($dataProvider->itemCount)  
{   
	 
	// подгрузка css для вывода картинки с описанием
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/in.css');  

	?>
	<!-- Окно для вывода картинки с описанием -->
	<div id="info-popup"></div> 
	<?php // скрипт для вызова popup картинки с описанием: действие itemInfo вызывает через renderPartial представление 'popup'
	$ajaxUrl = $this->createUrl('assortment/itemInfo');
	Yii::app()->clientScript->registerScript('info-popup-script', "
	jQuery('.info-link').on('click', function(){ jQuery.ajax({'data':{id: this.id },'url':'{$ajaxUrl}','cache':false,'success':function(html){jQuery('#info-popup').html(html)}});return false;});
	", CClientScript::POS_END);  
 
	echo CHtml::Form();
	$this->widget('zii.widgets.grid.CGridView', array( 
		'id'=>'assortment-grid',
		'dataProvider'=>$dataProvider, 
      //  'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',		
		'ajaxUrl'=>array('assortment/index'), 
		'columns'=>array(
			//'id',
			'agroup',
			'groupCategory'=>array(
				'name'=>Yii::t('general', 'groupCategory') ,  
				'value'=>'Category::model()->findByPk($data->groupCategory)->name', 
			),
			//	'subgroup',
			//'depth',
			'title', 
		/*	'model',
			'series.series2', */ 
		    'article2'=>array(
				'name'=>'article2',
				'header'=>Yii::t('general','Article'),
			),
			'oem',
			'manufacturer',
			array(
				'value'=>'$data->getPrice()', 
			//	'value'=>'$data->getPrice('.Yii::app()->user->id.')',  
				'header' => Yii::t('general', 'Price'),
			),	 
			/*'availability'=>array(
				'name'=>'availability', 
			    'htmlOptions'=>array('style'=>'text-align:center'),
			  ), */	
		    'availability-reserved'=>array(
		       'header' =>Yii::t('general','Availability'),
		       'value'=>'$data->availability - $data->reservedAmount',
			   'htmlOptions'=>array('style'=>'text-align:center'),
		    ),
			'infoPopup'=>array(
				'header'=>Yii::t("general",'Info'),
				 'type'=>'html',
				'value'=>array($this, 'infoPopup'), 
			 ),	
	    	/*'info'=>array(
				'header'=>Yii::t("general",'Info'),
				'type'=>'html',
				'value'=>array($this, 'info'), 
			 	'visible'=>'$data->availability', 
			 ),	  */     
// new for getting into cart			
			array(
				'class'=>'ButtonColumn', 
				'evaluateID'=>true,
				'template'=>'{add}',
				'buttons' => array(    
					'add' => array( 
						 'label' => Yii::t('general','Add'), 
						 'options' => array('class'=>'custom-btn add-to-order', 'id'=>'\'item-\'.$data->id', 'max-amount'=>'\'amt-\'.$data->availability'),
						 'url'=>'', //'Yii::app()->controller->createUrl("#", array("id"=>$data[id]))',
						//  'visible'=>'Yii::app()->user->checkAccess(1)',
						  'visible'=>'/*Yii::app()->controller->id <> "assortment" && */ $data->availability <> 0 ',
						  'click'=>"function(){
											$('#cart').dialog('open');							
											// we put the id value into the field
											var rx = /(\d+)$/;	
											var arr = rx.exec($(this).attr('id'));
											$('#Assortment_id').val(arr[1] );	
											return false;					  
							}", 
						),
				   ), 
			),

	/*		array('header'=> CHtml::dropDownList('pageSize', 
				$pageSize,
				array( ' '=>  Yii::t('general', 'items on page'), 20=>20, 50=>50, 100=>100, 10000=>Yii::t('general', 'all items')),
				array('onchange'=>"window.location.href = window.location.href + '&pageSize=' + $(this).val(); ",
				'options' => array('title'=>'Click me'),
				)),   				
				'type'=>'raw',
				'value'=>array('AssortmentController', 'amountToCartAjax'), 
			), 		*/
			array(
				'class' => 'CCheckBoxColumn',
				'id' => 'Assortment[id]',	 
			), 	 
		),
	));  
	echo CHtml::endForm();
}  
if (isset($dataProviderAnalog) && !empty($dataProviderAnalog->itemCount) )
{
?> 
<div class="analogs-form" style="display:block">
<?php $this->renderPartial('_analogs',array('model'=>$model,  'dataProviderAnalog'=>$dataProviderAnalog )); 	 	
?></div><!-- analogs-form -->
<?php 
} 
?>