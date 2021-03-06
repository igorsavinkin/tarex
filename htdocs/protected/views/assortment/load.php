<?php
/* @var $this EventcontentController */
/* @var $content Eventcontent */
/* @var $form CActiveForm */
?> 
<h2><?php echo Yii::t('general', 'Loading Assortment from Excel file'); ?></h2>
<div class='form'>
<h3> 
	<?php echo Yii::t('general', 'Set up the parameters for an assortment to be loaded'); ?>
</h3>
<?php $form=$this->beginWidget('CActiveForm', array(  
		'id'=>'doc-event-content-file',
		'enableAjaxValidation'=>false,
		//'action'=> array('events/loadAssortment'),
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
			),	
	));?>
<table><tr>
	<td> 	
	<label><?php echo Yii::t('general','Load assortment template'),'</label>';
		$this->widget('ext.select2.ESelect2',array(
			'model' => $loadDataSetting,
			 'attribute' => 'id', 
			'options'=> array('allowClear'=>true,
					'width' => '200'),  
			'data'=>CHtml::listData(LoadDataSettings::model()->findAll(), 'id', 'TemplateName'),
		));
		echo '&nbsp;<br/>' ,CHtml::link(Yii::t('general','Edit loading settings'), array('LoadDataSettings/admin'), array('target'=>'_blank')); ?>
	</td> 
	<td class='padding10side'><label><?php echo Yii::t('general','Warehouse'),'</label>'; 
		$this->widget('ext.select2.ESelect2',array(			 
			'model' =>$assortment, 
			'attribute' => 'warehouseId', 
			'options'=> array('allowClear'=>true,
					'width' => '200'),  
			'data'=>CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'),
		));
		echo '&nbsp;<br/>' ,CHtml::link(Yii::t('general','Edit Warehouses'), array('warehouse/admin'), array('target'=>'_blank')); ?>
	</td>
	<td class='top'><label><?php echo Yii::t('general','Organization'),'</label>'; 
		$this->widget('ext.select2.ESelect2',array(			 
			'model' =>$assortment, 
			'attribute'=> 'organizationId', 
			'options'=> array('allowClear'=>true,
					'width' => '200'),  
			'data'=>CHtml::listData(Organization::model()->findAll(), 'id', 'name'),
		)); ?>
	</td>
</tr><tr>	 	
	<td><label><?php echo Yii::t('general', 'First row is a column title'), '</label>';
		echo CHtml::checkBox('firstRow', $_POST['firstRow'], array('uncheckValue'=>0)  );		
// виджет загрузки файла
		$this->widget('CMultiFileUpload', array( 		
			'name'=>'FileUpload1',
		)); ?>
	</td>  
	<td class='bottom'> 
	<?php echo CHtml::submitButton(Yii::t('general', 'Load assortment from file'), array('class'=>'red')); ?>
	</td>	
</tr></table>
<?php $this->endWidget();?>
</div> <!-- form-->