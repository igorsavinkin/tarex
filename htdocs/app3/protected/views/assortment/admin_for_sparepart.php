<?php 
/* @var $this AssortmentController */
/* @var $model Assortment */ 
  //print_r(Yii::app()->getParams());
 //echo '<br>return = ',  intval($_GET['return']);
 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assortment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model, 
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){ 		
		location.href = "' . $this->createUrl('update') .'/id/"+$.fn.yiiGridView.getSelection(id);	
	}', 
	'columns'=>array(
		'title',
		'model',
		'make',
	//	'article',
		'article2',
		'oem',
		'manufacturer',
		'availability',
		array(
			'class'=>'ButtonColumn', 
			'evaluateID'=>true,
			'template'=>'{' . Yii::t("general","add to spare part") . '}', 
			'header'=>CHtml::dropDownList('pageSize', 
				$pageSize,
				array( ' '=>  Yii::t('general', 'items on page'), 20=>20, 50=>50, 100=>100),
				array('onchange'=>"window.location.href = window.location.href + '&pageSize=' + $(this).val(); ",
				'options' => array('title'=>'Click me'),
				)), 
			'buttons'=>array(        
					Yii::t('general','add to spare part') => array( 
					   'url' =>' Yii::app()->createUrl( (intval($_GET["return"]) == 0) ? "specialOffer/create" : "specialOffer/update", array("assortmentId"=>$data->id, "id"=>intval($_GET["returnSparePart"])))  ',  
					 //  'url' => '$returnUrl . \'assortmentId=\' . $data->id' ,  
					 //  'options'=>array( 'id'=>'\'some-class-\'.$data->id', 'class'=>"specialOffer"),
					),
			), 
		)
	),
));  
//********************** script for the specialOffer **********************//
//$index= intval($_GET['return']);
//$returnUrl = ($index > 0) ? $this->createUrl(array('specialOffer/update', 'id'=>$index)) : $this->createUrl('specialOffer/create');
Yii::app()->clientScript->registerScript('dialog', "
 $('.specialOffer').click(function(data){		
	var rx = /(\d+)$/;
    var arr = rx.exec($(this).attr('id')); 
	window.location.href = '" . $returnUrl  /*Yii::app()->params['returnUrl']   Yii::app()->request->urlReferrer*/ . "&assortmentId=' + arr[1];
 	return false;
});", CClientScript::POS_END);?>