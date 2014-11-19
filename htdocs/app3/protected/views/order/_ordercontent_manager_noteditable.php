
<?php
/* @var $this EventcontentController */
/* @var $content Eventcontent */
/* @var $form CActiveForm */
?>
<h2><?php echo Yii::t('general', 'Order\'s content'); //Содержание заказа ?></h2>
<!--div class="form"-->
 
<div class='print' >

<h4 class='print' style='font-color:grey;'><?php// echo Yii::t('general','Order\'s Assortment'); //Номенклатура заказа: ?></h4>
<?php // сетка с номенклатурой для данного заказа
$contractorIsOpt = User::model()->findByPk($model->contractorId)->role == User::ROLE_USER;
$dataProvider=new CActiveDataProvider('EventContent', array(    
        'criteria' => array(
        'condition'=>'eventId = '. $eventId , 'order'=>'id DESC'), // $eventId передан из view 'update' 
		'pagination'=>array(
			'pageSize'=>100,
		),
	));
// добавим тег открытия формы
echo CHtml::form();
$this->widget( 'zii.widgets.grid.CGridView', array(
        'id' => 'orderscontent',
	//	'itemsCssClass' => 'table-bordered items',
		'selectableRows' => 2, 
		'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
		// выводим сумму по таблице и подсчитываем всю сумму и заносим это в атрибут 'totalSum' модели Events ---> $this->countSumTotal($eventId). Это происходит каждый раз при пересчёте/обновлении таблицы
	    'summaryText' => '<h3>' . Yii::t('general','Total with discount' ) . ' <em>'. EventContent::getTotalSumByEvent($eventId) . '</em> ' . Yii::t('general','RUB')  . '</h3>' . 'Результат {start} - {end} из {count}',
		'dataProvider' => $dataProvider,   	 
        'columns' => array( 
			'id',
			'assortment.article2',
			//'assortmentTitle',
			array(  
			//	'type'=>'raw',
				'name'=>'assortmentTitle',
			//	'value' => array($this, 'titleDataField'),
			),
			'assortmentAmount',
			'basePrice'=>array(  
			 	'type'=>'raw',
				'name'=>Yii::t('general','Base Price'). ' (цена до всех скидок)',				
				'value' =>  '$data->assortment->getCurrentPrice()',
			),		 
			'discount'=>array(  
			 	'type'=>'raw', 
				'name'=>Yii::t('general','Opt Discount' ),
				'value' =>'$data->assortment->getDiscountOpt('. $model->contractorId .')',		
				'visible'=>$contractorIsOpt, 				
			),
			'discountCurrent'=>array(  
			 	'type'=>'raw', 
				'name'=>Yii::t('general','Current discount' ) . ' %',
				'value' =>'round(($data->price - $data->assortment->getCurrentPrice())/$data->assortment->getCurrentPrice()*100, 2)',  				
			),			
			'price', 
			/*'RecommendedPrice'=>array(
					'name'=>'RecommendedPrice',
					'header'=>Yii::t('general','Recommended Price'), 
					'cssClassExpression'=>'$data->priceCssClass',   
					), */
			'cost'=>array(
				'name'=>'cost',
				'cssClassExpression'=>'$data->priceCssClass()',   
			), 		
		),
    )); 
echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 

echo CHtml::endForm(); ?>
</div>
<!--button class='no-print' 'style'='float:right;' onClick="window.print()"><?php echo Yii::t('general','Print event content');  ?></button--> 
<br><br><h3> 
<?php	 /*
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
<?php $this->endWidget(); ?>
</div> 