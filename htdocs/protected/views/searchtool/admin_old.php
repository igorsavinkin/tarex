<?php 
/* @var $this AssortmentController */
/* @var $model Assortment */
?> 
<?php  
/********************************** start of the Dialog box ******************************/
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'cart',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>Yii::t('general','Add the assortment to a cart'),
        'autoOpen'=>false,
    ),
));
echo Yii::t('general', 'Enter the amount of this assortment item');?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assortment-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
	'htmlOptions' => array(
       // 'enctype' => 'multipart/form-data',
    ),
)); 
	echo $form->hiddenField($model,'id'); ?>
	<div class="row"> 
	<?php echo $form->labelEx($model, Yii::t('general','Amount'));  
		$data = array(); for($i=1; $i <= 100; $i++ ) { $data[$i] = $i; }		
		$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'amount',
				'data' => $data,
				'options'=> array(
					'allowClear'=>true, 
					'width' => '100', 
					'placeholder' => '',
					//'minimumInputLength' => 3
					),
			));	
	echo CHtml::submitButton(Yii::t('general', 'Add'), array('class'=>'red btn-medium btn-primary', 'style'=> 'float:right;')); ?>
	</div>
</div>
<?php $this->endWidget();  

$this->endWidget('zii.widgets.jui.CJuiDialog');
/******************************** end of the Dialog box *************************************/
 
?>  
<h1><?php  echo Yii::t('contact','Search tool'); ?></h1>
<div class="search-form" style="display:block"> 
<?php $this->renderPartial('_searchpanel',array('model'=>$model)); ?></div><!-- search-form -->
		
<?php		
if ($dataProvider->itemCount)   
{  
    echo '<br><h2>', Yii::t('general','Main Grid'), '</h2>'; 

	$this->widget('zii.widgets.grid.CGridView', array( 
		'id'=>'assortment-grid',
		'dataProvider'=>$dataProvider, //$model->search() 
        'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
		'pager' => array( 'cssFile' => Yii::app()->baseUrl . '/css/customPager.css', ),					
	//	'ajaxUrl'=>array('assortment/index'),
		'columns'=>array(
			'article',
			'subgroup', 
			'carType' =>array(
				'value'=>'$data->make',
				'header' => Yii::t('general', 'Car type'),
			),	
			'warehouse' =>array(
				'value'=>'$data->warehouse->name ? $data->warehouse->name : "Moscow" ',
				'header' => Yii::t('general', 'Warehouse'),
			),	
			'title', 
		/*	'model',
			'series.series2', */
			//'country',
			//'measure_unit',
			
			'oem',
			'manufacturer',
			array(
				'value'=>'$data->getPrice('')',
				'header' => Yii::t('general', 'Price'),
			),	
		/*	array(
				'value'=>'$data->quantityReserved()',
				'header' => Yii::t('general', 'Reserved'),
			),	 */
			'availability',  
			'specialDescription',
			'notes', 
			array( 
					'class'=>'ButtonColumn',
					'evaluateID'=>true,
					'template'=>'{' . Yii::t("general","add to cart") . '}', 
					'header'=>CHtml::dropDownList('pageSize', 
						$pageSize,
						array(' '=> Yii::t('general', 'items on page'), 20=>20, 50=>50, 100=>100),
						array('onchange'=>"window.location.href = document.URL + '&pageSize=' + $(this).val(); ",
						'options' => array('title'=>'Click me'),
						)), 
					'buttons'=>array(       
							Yii::t('general','add to cart') => array(
								'url'=>'"#"',
							   'imageUrl' => Yii::app()->baseUrl . '/img/cart.gif',
							   'options'=>array( 'id'=>'\'some-class-\'.$data->id', 'class'=>"to-cart"),
							   'visible'=>'$data->availability != 0', 
							),
					),
				),
		),
	)); 
}  else 
{ 
	echo '<div style="clear:both"></div>', Yii::t('general', 'There are no items corresponding to your request'), ' <b>', /*$_POST['findbyoem-value'],*/ '</b><hr><br><br>'; 
} 
?>
<!-- car-index  -->
<h2><?php echo CHtml::Link(Yii::t('general', 'Car index') , '' , array('id'=>'car-index', 'class'=>'btn-win', 'style'=>'float:left;')); ?></h2>
<div id="car-index-form" style="display:none"> 
	<?php $this->renderPartial('_carindex', array('model'=>$model, 'dataProviderCarIndex'=>$dataProviderCarIndex,   'arrayDataProviderCarIndex'=>$arrayDataProviderCarIndex)); ?>
</div><!-- car-index-form --> 

<!--  пользователи -->
<h2><?php echo CHtml::Link(Yii::t('general', 'Customers') , '' , array('id'=>'users-form-btn', 'class'=>'btn-win',  'style'=>'float:left;')); ?></h2>
<div id="users-form" style="display:none"> 
	<?php $this->renderPartial('_users', array('user'=>$user, 'dataProviderUser'=>$dataProviderUser)); ?>
</div><!-- users-form -->
<?php
//********************** script for the popup Dialog **********************//
Yii::app()->clientScript->registerScript('dialog', "
//$('#cart').hide(); 
$('.to-cart').click(function(data){		
	
	$('#cart').dialog('open');
	// we put the id value into the field
	var rx = /(\d+)$/;	
    var arr = rx.exec($(this).attr('id'));
	$('#Assortment_id').val(arr[1]);	

	return false;
});", CClientScript::POS_END);
?>