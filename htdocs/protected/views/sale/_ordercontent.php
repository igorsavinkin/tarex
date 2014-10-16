<div class='print' >
<?php // сетка с номенклатурой для данного заказа
//echo 'eventId = '. $eventId;


$dataProvider=new CActiveDataProvider('EventContent', array(    
        'criteria' => array(
        'condition'=>'eventId = '. $eventId), // $eventId передан из view 'update' 
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
		'selectableRows' => 2, 
		'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
	    'summaryText' => '<h3>' . Yii::t('general','Total with discount' ) . ' <em>'. EventContent::getTotalSumByEvent($eventId) . '</em> ' . Yii::t('general','RUB')  . '</h3>' . 'Результат {start} - {end} из {count}',
		'dataProvider' => $dataProvider,   	 
        'columns' => array( 
			'id',
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
	
echo CHtml::ajaxSubmitButton(Yii::t('general', 'Delete selection') /* 'Удалить несколько'*/,  array('eventContent/bulkActions', 'name' => 'delete'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent"); $(".summary").find("em").css("background-color", "red");}'), array('style'=>'float:right;')); // $("#boo1 + label").css("background-color", "#c0392b");

echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 
	
	
	
	//echo CHtml::endForm();
	$this->endWidget();
?>	
	<button class='no-print' 'style'='float:right;' onClick="window.print()"><?php echo Yii::t('general','Print event content');  ?></button>
	
	
<?php	
	
	
	echo '<br><br><br>'.Yii::t('general', 'Load assortment from file');
		$form=$this->beginWidget('CActiveForm', array(  
		'id'=>'doc-event-content-file',
		'enableAjaxValidation'=>false,
		'action'=> array('Orders/loadContent'),
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),	
		));
		
		if (Yii::app()->user->role<=5){
			$ArrayD=CHtml::listData(LoadDataSettings::model()->findAll(), 'id', 'TemplateName');
			$this->widget('ext.select2.ESelect2',array(
					'name' => 'LoadDataSettingsID',
					'options'=> array('allowClear'=>true,
							'width' => '200'),
					'data'=>$ArrayD,
			));
			
			echo CHtml::link(Yii::t('general','Edit loading settings'), array('LoadDataSettings/admin')); 
		}
		
				
		$this->widget('CMultiFileUpload', array( 		
			'name'=>'FileUpload1',
		));
		  
		echo CHtml::submitButton(Yii::t('general', 'Load assortment from file'));
	//<div class="hidden">
	
	
?>

	<div class="hidden">
<?php echo $form->textField($model,'id'); ?>
	</div>
	
<?php
	$this->endWidget();
 
?>	
	
	



<?php //$this->endWidget(); ?>

</div>
<style>  
.difference { background-color: yellow; } 
.green {background-color:  green;} 
.lime {background-color:  lime;} 
.blue { background-color: #3399FF;} 
.redbgcolor { background-color: #FF717E;} 
</style>

