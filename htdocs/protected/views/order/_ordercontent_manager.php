<?php
/* @var $this EventcontentController */
/* @var $content Eventcontent */
/* @var $form CActiveForm */
?>
<h2><?php echo Yii::t('general', 'Order\'s content'); ?></h2>
<div class='print' >  
<?php // сетка с номенклатурой для данного заказа
//echo 'contractor id = ', $model->contractorId;
//echo '<br>contractor role = ', User::model()->findByPk($model->contractorId)->role;
$contractorIsOpt = User::model()->findByPk($model->contractorId)->role == User::ROLE_USER;
$dataProvider=new CActiveDataProvider('EventContent', array(    
        'criteria' => array(
        'condition'=>'eventId = '. $eventId, 'order'=>'id DESC'), // $eventId передан из view 'update' 
		'pagination'=>array(
			'pageSize'=>100,
		),
	));
// добавим тег открытия формы
 //echo CHtml::form();

 $form=$this->beginWidget('CActiveForm',array(
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
 )); 

$this->widget( 'zii.widgets.grid.CGridView', array(
        'id' => 'orderscontent',
	//	'itemsCssClass' => 'table-bordered items',
		'selectableRows' => 2, 
		'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
		// выводим сумму по таблице и подсчитываем всю сумму и заносим это в атрибут 'totalSum' модели Events ---> $this->countSumTotal($eventId). Это происходит каждый раз при пересчёте/обновлении таблицы
	    'summaryText' => '<h3>' . Yii::t('general','Total with discount' ) . ' <em id="grid-total-sum">'. EventContent::getTotalSumByEvent($eventId) . '</em> ' . Yii::t('general','RUB')  . '</h3>' . 'Результат {start} - {end} из {count}',
		'dataProvider' => $dataProvider,   	 
        'columns' => array( 
			'id',
			'assortment.article2', 
		 	array(  
				'name'=>'assortmentTitle',
			), 
			array(  
				'type'=>'raw',
				'name'=>'assortmentAmount',
				'value' => array($this, 'amountDataField'),
			),	
			'minPrice'=>array(  
				'type'=>'raw',
				'name'=>Yii::t('general','Min Price') . ' (согласно оптовой максимальной скидке)', 
				'value' => '$data->assortment->getPriceOptMax()',
				'visible'=>$contractorIsOpt,
			),  
			'basePrice'=>array(  
			 	'type'=>'raw',
				'name'=>Yii::t('general','Base Price'). ' (цена до всех скидок)',				
				'value' =>  '$data->assortment->getCurrentPrice()',
			),
			'currentOptDiscount'=>array(         
				'type'=>'raw',
				'name'=>Yii::t('general','Opt Discount' ) , 
				'value' => '$data->assortment->getDiscountOpt('. $model->contractorId . ')',
				'visible'=>$contractorIsOpt, 
			),
			'discount'=>array(  
			 	'type'=>'raw', 
				'name'=>Yii::t('general','Current discount') . ', %',
				'value' => array($this, 'discountDataField'),				
			),  
		/*	'currentDiscount'=>array(  
				'type'=>'raw',
				'name'=>Yii::t('general','Current discount') . ', %', 
				'value' => 'round(($data->price - $data->assortment->getCurrentPrice())/$data->assortment->getCurrentPrice()*100, 2)',
			),*/
			'price'=>array(  
			 	'type'=>'raw',
				'name'=>'price',
				'value' => array($this, 'priceDataField'),				
			),   					
		 /*   'RecommendedPrice'=>array(
				'name'=>'RecommendedPrice',
				'header'=>Yii::t('general','Recommended Price') . ' (цена с учётом скидки в Ценоообразовании)', 
				'cssClassExpression'=>'$data->priceCssClass',   
			), */
			'cost'=>array(
				'name'=>'cost',
				'cssClassExpression'=>'$data->priceCssClass()',   
			), 			
			array(
				'class' => 'CCheckBoxColumn',
				'id' => 'eventContentId',	
			),     
		),  
    ));   
	
echo CHtml::ajaxSubmitButton(Yii::t('general', 'Delete selection') /* 'Удалить несколько'*/,  array('eventContent/bulkActions', 'name' => 'delete'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent", 
        {   complete: function(jqXHR, status) {
				if (status=="success"){
					//console.log(jqXHR, status);
					//alert("#grid-total-sum.value = " + $("#grid-total-sum").text() );
					// заносим новую сумму в поле где сумма заказа в основной закладке копируя её из поля в новой сетке
					$("#total-sum").text( $("#grid-total-sum").text() );
				}
			}
		});  }'), array('style'=>'float:right;')); 
echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 
$this->endWidget();?>	
	
<br><br><h3> 
<?php	
	echo Yii::t('general', 'Load assortment from file'), '</h3>';
	$form=$this->beginWidget('CActiveForm', array(  
	'id'=>'doc-event-content-file',
	'enableAjaxValidation'=>false,
	'action'=> array('order/loadContent'),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		),	
	));
	 
	$this->widget('ext.select2.ESelect2',array(
			'model' => $loadDataSetting,
			 'attribute' => 'id', 
			'options'=> array('allowClear'=>true,
					'width' => '200'),  
			'data'=>CHtml::listData(LoadDataSettings::model()->findAll(), 'id', 'TemplateName'),
	));			
	echo '&nbsp;' ,CHtml::link(Yii::t('general','Edit loading settings'), array('LoadDataSettings/admin')); 		
			
	$this->widget('CMultiFileUpload', array( 		
		'name'=>'FileUpload1',
	));
	  
	echo CHtml::submitButton(Yii::t('general', 'Load assortment from file'));
?>

<div class="hidden">
	<?php echo $form->textField($model,'id'); ?>
</div>
	
<?php	$this->endWidget();?>	
</div>
<style>  
.difference { background-color: yellow; } 
.green {background-color: #33CC33;} 
.lime {background-color:  lime;} 
.blue { background-color: #3399FF;} 
.redbgcolor { background-color: #FF717E;} 
</style>

