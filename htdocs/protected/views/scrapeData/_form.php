<?php
/* @var $this ScrapeDataController */
/* @var $model ScrapeData */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'scrape-data-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td>
		<?php echo $form->labelEx($model,'marker'); ?> 
		<?php echo $form->textField($model,'marker',array('size'=>40,'maxlength'=>63)); ?>
		<?php echo $form->error($model,'marker'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'date'); ?> 
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'make'); ?> 
		<?php echo $form->textField($model,'make',array('size'=>40,'maxlength'=>63)); ?>
		<?php echo $form->error($model,'make'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'model'); ?> 
		<?php echo $form->textField($model,'model',array('size'=>40,'maxlength'=>63)); ?>
		<?php echo $form->error($model,'model'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'seria'); ?> 
		<?php echo $form->textField($model,'seria',array('size'=>40,'maxlength'=>63)); ?>
		<?php echo $form->error($model,'seria'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'engine'); ?> 
		<?php echo $form->textField($model,'engine',array('size'=>40,'maxlength'=>63)); ?>
		<?php echo $form->error($model,'engine'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'year'); ?> 
		<?php echo $form->textField($model,'year'); ?>
		<?php echo $form->error($model,'year'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'owner'); ?> 
		<?php echo $form->textField($model,'owner',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'owner'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'phone'); ?> 
		<?php echo $form->textField($model,'phone',array('size'=>40,'maxlength'=>63)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'isChecked'); ?> 
		<?php echo $form->checkBox($model,'isChecked'); ?>
		<?php echo $form->error($model,'isChecked'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'isPaid'); ?> 
		<?php echo $form->checkBox($model,'isPaid'); ?>
		<?php echo $form->error($model,'isPaid'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'link'); ?> 
		<?php echo $form->textField($model,'link',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link'); ?>
	</td>

</tr><tr>	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save')); ?>
	</td>
	<td>	<?php echo CHtml::ajaxSubmitButton('ajaxSubmitButton', array('Scrape Data/update', 'id'=> $model->id), array('success'  => 'js: function(data) { $("#locator").html(data); } 
		function() { $.fn.yiiGridView.update("#scrape-data-grid");}'
		)); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->