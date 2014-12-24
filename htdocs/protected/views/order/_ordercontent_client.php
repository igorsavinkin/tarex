<?php // echo 'here client';
/* @var $this EventcontentController */
/* @var $content Eventcontent */
/* @var $form CActiveForm */
//echo 'not Valid: ', $notValid;
?>
<div class="search-field" style="display:block">
<?php  // включаем поле с формой для поиска
$this->renderPartial('_search_field', array('model'=>$model)); 
?>
</div><!-- search-field -->
<div class='tar_search form'>
<?php echo CHtml::button(Yii::t('general','Back to orders'), array('class'=>'red bottom', 'onclick' => 'js:document.location.href="'. $this->createUrl('admin', array('id'=>$eventId, 'new'=> ($model->StatusId == Events::STATUS_NEW) ? 1: 0)) . '" ' ));?>
</div><div class='tar_search form'>
<?php if($model->totalSum>0) // ставим эту кнопку только если сумма заказа не нулевая
     echo CHtml::button( Yii::t('general','Form the order'), array( 'class'=>'red',  'id'=>'payment-shipping-link', 'onclick'=>'js:$("#payment-shipping").dialog("open"); ' )); ?>
</div>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'payment-shipping',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>Yii::t('general','Define payment & shipping methods'),
        'autoOpen'=>false,
		),
	));?>
<div class="form" style='padding-top:15px;'>
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'payment-shipping-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
	'action'=>array('admin'), 
)); ?>
		<?php 
		// добавляем скрытое поле для id заказа  
		echo CHtml::hiddenField( 'event_identificator', $eventId); 
		// индикатор что статус заказа новый
		if($model->StatusId==Events::STATUS_NEW) 
     			echo CHtml::hiddenField( 'status-new', 1);  ?> 
	<div class="row"> 
		<?php  echo $form->labelEx($model,'PaymentType');  
		Yii::app()->clientScript->registerScript('some-script', "
		jQuery('#s2id_Events_PaymentType').on('select2-open', function(e) { console.log('open'); });
 	    ");
		
		    $this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'PaymentType',//'open'=>'js:{alert("init");}',
				'data' => CHtml::listData(PaymentMethod::model()->findall(), 'id','name'),
				//'id'=> 'js:function(){console.log("Select2 initialized over");} ',
				
				'htmlOptions'=>array( 
				/*	'initSelection'=>CHtml::ajax(array('type'=>'GET',
				    	'url'=>$this->createUrl('user/cashlessUser', array ('id'=>Yii::app()->user->id)),
				    	'data'=>'js:{PaymentMethod: this.value }',
					)), 'init'=> 'console.log("smth")',
			        'select2-opening'=> 'js: console.log("smth"); ',
			        'select2-opening'=> ' console.log("smth"); ',
			        'select2-opening'=> ' alert("smth"); ',
			        's2id_Events_PaymentType.open'=> 'js: console.log("open"); ',
			        'onFocus'=> 'js: console.log("smth"); ',*/
					'onChange'=>CHtml::ajax(array('type'=>'GET',
					'url'=>$this->createUrl('user/cashlessUser', array ('id'=>Yii::app()->user->id)),
					'data'=>'js:{PaymentMethod: this.value }',
					'success'=>"js:function(data){   
						  if('0'==data)
						   {
							 $('div.buttons center').hide();
							 $('#alert-msg').show();
						   } else {
						     $('div.buttons center').show();
							 $('#alert-msg').hide();						   
						   }
					   }",
					)),
				), 
				'options'=> array('allowClear'=>true, 
					'width' => '250', 
					'placeholder' => '', 
					), 		 	
			));	 ?>
	</div>
	<div class="row"> 
		<?php echo $form->labelEx($model,'shippingMethod');  
		    $this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'shippingMethod',
				'data' => CHtml::listData(ShippingMethod::model()->findall(), 'id','name'),
				'options'=> array('allowClear'=>true, 
					'width' => '250', 
					'placeholder' => '', 
					), 			
			));	 ?>
	</div>
   	<br>
	<div class="buttons" ><center> 
		<?php echo CHtml::submitButton(Yii::t('general', 'Form the order'), array('class'=>'btn btn-medium btn-primary', 'name'=> 'client-save')); ?>
		</center>
		<div id='alert-msg' style="display:none;"><?php echo  Yii::t('general', 'You banking data for cashless payment are not in order'). '. ' .Yii::t('general', 'Please fix these in your profile'). '. '. CHtml::link(Yii::t('general', 'Profile'), array('user/update', 'id'=>Yii::app()->user->id), array('target'=>'_blank', 'class'=>'btn-win'));?>
		</div>
	</div>
</div> 	
<?php $this->endWidget();	//echo 'inside widget';

$this->endWidget('zii.widgets.jui.CJuiDialog');
 
// если поисковый параметр установлен то включаем view 'searchUnique' где мы обсчитываем/ищем и выводим найденные позиции включая аналоги
if(isset($_POST['search-value'])) 
		$this->renderPartial('searchUnique');
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
	    'template'=>'{items}{pager}{summary}',  
		'summaryText' => 'Результат {start} - {end} из {count}<h3 class="order-total">' . Yii::t('general','Total with discount' ) . ' <em id="grid-total-sum">'. EventContent::getTotalSumByEvent($eventId) . '</em> ' . Yii::t('general','RUB')  . '</h3>' ,
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
<!--script>
$("#s2id_Events_PaymentType")
   .on("select2-open", function(e) { console.log("open"); });
</script-->