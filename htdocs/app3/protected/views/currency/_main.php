<div class="form">
<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
));?> 
	<?php echo $form->errorSummary($model); ?> 
	<td valign='top' width='250'>
		<?php echo $form->labelEx($model,'name'); 
				  echo $form->textField($model,'name'); 
				  echo $form->error($model,'name'); ?>
	</td>
	<td align='center' width='250'>	<?php 	
		echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 	?>
	</td>  
	
</tr></table> 
<?php $this->endWidget(); ?>
 
</div><!-- form -->