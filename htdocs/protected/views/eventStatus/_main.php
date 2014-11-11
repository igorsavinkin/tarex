<div class="form">
<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
));?> 
	<?php echo $form->errorSummary($model); ?> 
	<td valign='top' width='250' >
		<?php echo $form->labelEx($model,'name'); 
				  echo $form->textField($model,'name', array('size'=>'30')); 
				  echo $form->error($model,'name'); 
				  ?>
	</td>	
	<td>
		<?php echo $form->label($model,'Order1'); ?>
		<?php 
				$data = array(); for($i=1; $i <= 10; $i++ ) { $data[$i] = $i; }		
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'Order1',
						'data' => $data,
						'options'=> array(
							'allowClear'=>true, 
							'width' => '70', 
							'placeholder' => ''),
					)); ?>
	</td> 	
 	<td align='center' width='250'>	<?php 	
	echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 	?>
	</td>  
	
</tr></table> 
<?php $this->endWidget(); ?>
 
</div><!-- form -->