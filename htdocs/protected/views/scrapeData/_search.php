<?php
/* @var $this ScrapeDataController */
/* @var $model ScrapeData */
/* @var $form CActiveForm */
?>

<div class="wide form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<td>
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'marker'); ?>
		<?php echo $form->textField($model,'marker',array('size'=>40,'maxlength'=>63)); ?>
	</td>

	<td> 
		<?php //echo $form->label($model, 'created'); ?>
		<?php //echo $form->textField($model, 'created'); ?>
	</td> 

</tr><tr>	<td>
		<?php echo $form->label($model,'make'); ?>
		<?php echo $form->textField($model,'make',array('size'=>40,'maxlength'=>63)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>40,'maxlength'=>63)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'seria'); ?>
		<?php echo $form->textField($model,'seria',array('size'=>40,'maxlength'=>63)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'engine'); ?>
		<?php echo $form->textField($model,'engine',array('size'=>40,'maxlength'=>63)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'year'); ?>
		<?php echo $form->textField($model,'year'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'owner'); ?>
		<?php echo $form->textField($model,'owner',array('size'=>40,'maxlength'=>255)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>40,'maxlength'=>63)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'isChecked'); ?>
		<?php echo $form->checkBox($model,'isChecked'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'isPaid'); ?>
		<?php echo $form->checkBox($model,'isPaid'); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->