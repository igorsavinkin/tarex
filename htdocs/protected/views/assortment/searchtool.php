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

/*if ($parent && !isset($_GET['country']) ) 
{    
	$this->breadcrumbs=array(  
		$make
	);
} */

?>  
<h1><?php  echo Yii::t('contact','Search tool'); ?></h1>
<div class="search-form" style="display:block"> 
<?php $this->renderPartial('_searchpanel',array('model'=>$model)); ?></div><!-- search-form -->
		
<?php		
if ($dataProvider->itemCount)  
{   
	//echo '<br ><br >$dataProvider->getData() = '; print_r($dataProvider->getData()); //print_r($dataProvider->getData()); 
	
	//echo '<h1>' , Yii::t('general','Search item') , '</h1>'; // search element
	if (isset($_POST['findbyoem-value'])) echo '<h1>' , Yii::t('general','Requested number') , '</h1>'; // search element

	$findbyoemvalue = $_GET['findbyoem-value'] ?  $_GET['findbyoem-value'] : $_GET['findbyoemvalue'];	// Yii::app()->request->getParam('findbyoem-value');
	$this->widget('zii.widgets.grid.CGridView', array( 
		'id'=>'assortment-grid',
		'dataProvider'=>$dataProvider, //$model->search() 
        'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',		
	//	'ajaxUrl'=>array('assortment/index'),
		'columns'=>array(
			'article',
			'subgroup',
			'warehouse' =>array(
				'value'=>'$data->warehouse->name',
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
			'availability',	     		
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
}  
if ($dataProviderAnalog->itemCount) 
{
	//echo 'analogs';
	/*
	$show_msg = Yii::t('general', 'Show analogs');// will be used in 
	$hide_msg = Yii::t('general', 'Hide analogs');
	echo '<h3>', CHtml::Link($show_msg, '' , array('id'=>'show-analogs', 'class'=>'btn-win', 'style'=>'float:right;')); 
*/
?> 
	<div class="analogs-form" style="display:block">
	<?php $this->renderPartial('_analogs',array('model'=>$model,  'dataProviderAnalog'=>$dataProviderAnalog )); 		
	?></div>
	<!--/div><!-- search-form -->
<?php 
}  
if (!$dataProviderAnalog->itemCount && !$dataProvider->itemCount ) { 
	echo '<br /><div style="clear:both"></div>', Yii::t('general', 'There are no items corresponding to your request'), ' <b>', $_POST['findbyoem-value'], '</b>'; 
}
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