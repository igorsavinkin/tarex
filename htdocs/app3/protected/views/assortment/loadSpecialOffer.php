<h2><?php echo Yii::t('general', 'Load Assortment articles for Special Offer from Excel file'); ?></h2>
<div class='form'>
<h3> 
	<?php echo Yii::t('general', 'Set up file'); ?>
</h3>
<?php $form=$this->beginWidget('CActiveForm', array(  
		'id'=>'doc-event-content-file',
		'enableAjaxValidation'=>false, 
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
			),	
	));?>
<table><tr>	 	
	<td><label><?php echo Yii::t('general', 'First row is a column title'), '</label>';
		echo CHtml::checkBox('firstRow', $_POST['firstRow'], array('uncheckValue'=>0)  );		
// виджет загрузки файла
		$this->widget('CMultiFileUpload', array( 		
			'name'=>'FileUpload1',
		//	'htmlOptions' => array('multiple' => 'multiple' ),
		)); ?>
	</td>  
	<td class='bottom'> 
	<?php echo CHtml::submitButton(Yii::t('general', 'Load articles of special offer from file'), array('class'=>'red')); ?>
	</td>	
</tr></table>
<?php $this->endWidget();?>
</div> <!-- form-->

<?php echo CHtml::link(Yii::t('general','View special offer assortment items'), array('specialOffer'), array('class' => 'btn-win'));?>
<br>
