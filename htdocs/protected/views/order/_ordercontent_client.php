
<?php // echo 'here client';
/* @var $this EventcontentController */
/* @var $content Eventcontent */
/* @var $form CActiveForm */
?>
<h2><?php echo Yii::t('general', 'Order\'s content');  ?></h2>
 
<div class='print' >

<h4 class='print' style='font-color:grey;'><?php// echo Yii::t('general','Order\'s Assortment'); //Номенклатура заказа: ?></h4>
<?php // сетка с номенклатурой для данного заказа
$dataProvider=new CActiveDataProvider('EventContent', array(    
        'criteria' => array(
        'condition'=>'eventId = '. $eventId), // $eventId передан из view 'update' 
		'pagination'=>array(
			'pageSize'=>100,
		),
	));
$form=$this->beginWidget('CActiveForm',array(
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
 ));
	
$this->widget( 'zii.widgets.grid.CGridView', array(
        'id' => 'orderscontent', 
		'selectableRows' => 2, 
		'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
		// выводим сумму по таблице и подсчитываем всю сумму и заносим это в атрибут 'totalSum' модели Events ---> $this->countSumTotal($eventId). Это происходит каждый раз при пересчёте/обновлении таблицы
	    'summaryText' => '<h3>' . Yii::t('general','Total with discount' ) . ' <em>'. EventContent::getTotalSumByEvent($eventId) . '</em> ' . Yii::t('general','RUB')  . '</h3>' . 'Результат {start} - {end} из {count}',
		'dataProvider' => $dataProvider,   	 
        'columns' => array( 
			'id',
			'assortmentArticle', 
			'assortmentTitle',
			array(  
				'type'=>'raw',
				'name'=>'assortmentAmount',
				'value' => array($this, 'amountDataField'), 
			),			 
			'price', 		 
			'cost', 			
			array(
				'class' => 'CCheckBoxColumn',
				'id' => 'eventContentId',	
			), 
		),
    )); 
	
echo CHtml::ajaxSubmitButton(Yii::t('general', 'Delete selection') /* 'Удалить несколько'*/,  array('eventContent/bulkActions', 'name' => 'delete'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent");}'), array('style'=>'float:right;')); 
//echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 
$this->endWidget(); ?>	

<!--button class='no-print' 'style'='float:right;' onClick="window.print()"><?php echo Yii::t('general','Print event content');  ?></button--> 

<br><br><h3> 
<?php	
	echo Yii::t('general', 'Load assortment from file'), '</h3>';
	echo Yii::t('general','Pattern'), ': <b>', $loadDataSetting->TemplateName, '</b><br>';
	
	$form=$this->beginWidget('CActiveForm', array(  
	'id'=>'doc-event-content-file',
	'enableAjaxValidation'=>false,
	'action'=> array('order/loadContent'),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		),	
	)); 
	echo $form->hiddenField($loadDataSetting,'id'); 
		
	$this->widget('CMultiFileUpload', array( 		
		'name'=>'FileUpload1',
	));		  
	echo CHtml::submitButton(Yii::t('general', 'Load assortment from file'));
?>
	<div class="hidden">
		<?php echo $form->textField($model,'id'); ?>
	</div>
<?php $this->endWidget(); ?>
</div>
<style>  
.difference { background-color: yellow; } 
.green {background-color:  green;} 
.lime {background-color:  lime;} 
.blue { background-color: #3399FF;} 
.redbgcolor { background-color: #FF717E;} 
</style>

