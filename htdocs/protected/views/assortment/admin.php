<?php 
/* @var $this AssortmentController */
/* @var $model Assortment */   
if (Yii::app()->controller->id == 'assortment' && Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
{
	echo CHtml::link(Yii::t('general','Create Assortment'), array('assortment/create'), array('class'=>'btn-win'));
   $selectionChanged = 'function(id){ location.href = "'.$this->createUrl('update').'/id/"+$.fn.yiiGridView.getSelection(id);}';
} 
else 
	$selectionChanged = ''; 
//$data = array(); for($i=1; $i <= 10; $i++ ) { $data[$i] = $i; }	

echo CHtml::form();
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assortment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
	'selectableRows'=>1,
	//'selectionChanged'=>$selectionChanged, 
	'columns'=>array(
		'title',
		'model',
		'make',
	//	'article',
		'article2',
		'oem',
		'manufacturer',
		'availability',
		array('header'=> CHtml::dropDownList('pageSize', 
				$pageSize,
				array( ' '=>  Yii::t('general', 'items on page'), 20=>20, 50=>50, 100=>100),
				array('onchange'=>"window.location.href = window.location.href + '&pageSize=' + $(this).val(); ",
				'options' => array('title'=>'Click me'),
				)),    //Yii::t("general",'Add to cart'),
		    'type'=>'raw',
			'value'=>array($this, 'amountToCart'),
			//	'htmlOptions'=>array('width'=>'90px'),
		), 		
		array(
				'class' => 'CCheckBoxColumn',
				'id' => 'Assortment[id]',	
				//'hidden'=>1,
			),    
		array(
			'class'=>'ButtonColumn', 
			'evaluateID'=>true,
			'visible'=>Yii::app()->user->checkAccess(User::ROLE_ADMIN),
			//'template'=>'{' . Yii::t("general","add to cart") . '}', 
			'template'=>'{' . Yii::t("general","update") . '}', 
			/*'header'=>CHtml::dropDownList('pageSize', 
				$pageSize,
				array( ' '=>  Yii::t('general', 'items on page'), 20=>20, 50=>50, 100=>100),
				array('onchange'=>"window.location.href = window.location.href + '&pageSize=' + $(this).val(); ",
				'options' => array('title'=>'Click me'),
				)), */
			'buttons'=>array(  				
				 Yii::t("general","update") => array(
					 //  'url'=>"Yii::app()->createUrl('update', array('id'=>$data->id))",  
					   'imageUrl' => '', 
					),
				/*Yii::t('general','add to cart') => array(
					   'url'=>'"#"',  
					   'imageUrl' => Yii::app()->baseUrl . '/img/cart.gif',
					   'options'=>array( 'id'=>'\'some-class-\'.$data->id', 'class'=>"to-cart"),
					   'visible'=>'$data->availability != 0',  
					),*/
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
)); ?>
		<?php echo $form->hiddenField($model,'id'); ?>
	<div class="row"> 
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php $data = array(); for($i=1; $i <= 100; $i++ ) { $data[$i] = $i; }		
		$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'amount',
				'data' => $data,
				'options'=> array(
					'allowClear'=>true, 
					'width' => '100', 
					'placeholder' => '',
					),
			));
		echo CHtml::submitButton(Yii::t('general', 'Add'), array('class'=>'btn btn-medium btn-primary', 'style'=> 'float:right;')); ?>
	</div>
</div>
<?php $this->endWidget();  

$this->endWidget('zii.widgets.jui.CJuiDialog');
/******************************** end of the Dialog box *************************************/
//********************** script for the popup Dialog **********************//
Yii::app()->clientScript->registerScript('dialog', "
$('.to-cart').click(function(data){		
	$('#cart').dialog('open');
	// we put the id value into the field
	var rx = /(\d+)$/;	
    var arr = rx.exec($(this).attr('id'));
	$('#Assortment_id').val(arr[1]);	
	return false;
});", CClientScript::POS_END);
?>