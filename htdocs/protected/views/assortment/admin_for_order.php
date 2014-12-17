<?php 
/* @var $this AssortmentController */
/* @var $model Assortment */
?> 

<?php  
	if (Yii::app()->controller->id == 'assortment' && Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
	{
		echo CHtml::link(Yii::t('general','Create Assortment'), array('assortment/create'), array('class'=>'btn-win'));
	   $selectionChanged = 'function(id){ location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);}';
	}
echo CHtml::form(array('action'=>'assortment/index'));

//echo 'contractorId'.$contractorId;


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assortment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
  //	'action'=>'assortment/admin',
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
/*	'selectableRows'=>1,
	'selectionChanged'=>$selectionChanged,*/
	'columns'=>array(
		'title',
		'model',
		'make',
	 	'article',
		'article2', 
		//'priceS',
		/*	'currentPrice'=>array(
				'name'=>'currentPrice', 
				'header' => Yii::t('general', 'Current Price'),
			),*/
		array(
				'value'=>'$data->getPrice2('.$contractorId.')',
				'header' => Yii::t('general', 'Price'),
		),	 
		'oem',
		'manufacturer',
	/*	'availability', 
		'reservedAmount',*/
		'availability-reserved'=>array(
		    'header' =>Yii::t('general','Availability'),
		    'value'=>'$data->availability - $data->reservedAmount',
		),
		array(
			'class'=>'ButtonColumn', 
			'evaluateID'=>true,
			'template'=>(Yii::app()->user->checkAccess(1) && Yii::app()->controller->id == 'assortment') ? '{delete}{add}' : '{add}',
			'header'=>CHtml::dropDownList('pageSize', 
				$this->pagesize,
				array( ' '=>  Yii::t('general', 'items on page'), 20=>20, 50=>50, 100=>100),
				array('onchange'=>"window.location.href = window.location.href + '&pageSize=' + $(this).val() ; ",
				'options' => array('title'=>'Click me'),
				)), 
			'buttons' => array(              
		   	    'delete' => array( 
					 'label' => Yii::t('general','Delete'), 
					 'options' => array('class'=>'custom-btn delete'),
					 'imageUrl'=>'',
					//  'url'=>'Yii::app()->controller->createUrl("delete", array("id"=>$data[id]))',
					 'visible'=>'Yii::app()->user->checkAccess(1)',
					), 
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
		)
	),
)); 
echo CHtml::endForm();


/********************************** start of the Dialog box ******************************/
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'cart',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>Yii::t('general','Add the assortment to this event'),
        'autoOpen'=>false,
    ),
));

    echo Yii::t('general', 'Enter the amount of this assortment item');?>

<div class="form" style='padding-top:15px;'>
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assortment-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
	'action'=>array('update', 'id'=>$eventId),
	'htmlOptions' => array(
       // 'enctype' => 'multipart/form-data',
    ),
)); ?>
		<?php 
		// добавляем скрытое поле для id номенклатуры 
		echo $form->hiddenField($model, 'id'); ?> 
	<div class="row"> 
		<?php //echo $form->labelEx($model,'amount'); ?>
		<?php $data = array(); for($i=1; $i <= 100 ; $i++ ) { $data[$i] = $i; }	
		$model->amount = 1;	
		$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'amount',
				'data' => $data, 
				'options'=> array('allowClear'=>true, 
					'width' => '100', 
					),
			));	 ?>
	<!--/div>
   	
	<div class="buttons"-->
		<?php echo CHtml::submitButton(Yii::t('general', 'Add'), array('class'=>'btn btn-medium btn-primary', 'style'=> 'float:right;', 'name'=> 'add-to-event')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>	
	
<?php	
$this->endWidget('zii.widgets.jui.CJuiDialog');
/******************************** end of the Dialog box *************************************/
//********************** script for the popup Dialog **********************//

Yii::app()->clientScript->registerScript('dialog', "
 /*
$('.add-to-order').click(function(data){	
	//alert('smth');	
	$('#cart').dialog('open');	
	// we put the id value into the field
	var rx = /(\d+)$/;	
    var arr = rx.exec($(this).attr('id'));
	$('#Assortment_id').val(arr[1]);	
	return false;
});
*/
", CClientScript::POS_END);


?>