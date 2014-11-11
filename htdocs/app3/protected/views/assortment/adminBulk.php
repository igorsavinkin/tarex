<?php 
/* @var $this AssortmentController */
/* @var $model Assortment */    
?>
<h1><?php echo Yii::t('general','Change assortment bulk'); ?></h1><br> 
<?php
echo CHtml::form();
echo "<div style='float:right;'>"; 
echo '<b>', Yii::t('general','Set other category for selected items'), '</b><br>';
$arrCategory=array();  
foreach(Category::model()->findAll() as $category)
    $arrCategory[$category->id] = Yii::t('general', $category->name); 
$this->widget('ext.select2.ESelect2', array(
					'name'=>'category', 
					'data' => $arrCategory, // CHtml::listData(Category::model()->findAll(), 'id', function($c) { return Yii::t('general', $c->name) ; }), // works starting from 1.1.13
					'options'=> array(
						'allowClear'=>true, 
						'width' => '200', 
						'placeholder' => Yii::t('general', 'Category'), 
						//'htmlOptions'=>array('style'=>'float:right;'),
						),
				));	
echo CHtml::ajaxSubmitButton(Yii::t('general', 'Change category'),  '', array('success'  => 'js:function() { $.fn.yiiGridView.update("assortment-grid");  }'), array('style'=>'float:right;', 'name' => 'change-category-bulk'));
//echo "<div class='hidden'>" , CHtml::submitButton(Yii::t('general', 'Change category 2')) , '</div>';
echo '</div>';
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assortment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
	'selectableRows'=>2, 
	'columns'=>array(
		'category'=>array(
			'type'=>'raw',
			'header'=>Yii::t("general", 'Category'),
			'value'=>'Yii::t("general", Category::model()->findByPk($data->groupCategory)->name)',
		), 
		'title',
		'model',
		'make',
		'article2',
		'oem',
		'manufacturer',
		//'availability',	 
		array(
			'header'=> CHtml::dropDownList('pageSize', 
				$this->pagesize,
				array( ' '=>  Yii::t('general', 'items on page'), 20=>20, 50=>50, 100=>100),
				array('onchange'=>"window.location.href = window.location.href + '&pageSize=' + $(this).val(); ",
				'options' => array('title'=>'Click me'),
			)),
			'class' => 'CCheckBoxColumn',
			'id' => 'id',	
		),   
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