<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */
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
		<?php echo $form->label($model,'TemplateName'); ?>
		<?php echo $form->textField($model,'TemplateName',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'СolumnSearch'); ?>
		<?php echo $form->textField($model,'СolumnSearch',array('size'=>40,'maxlength'=>255)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'СolumnNumber'); ?>
		<?php echo $form->textField($model,'СolumnNumber'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'ListNumber'); ?>
		<?php echo $form->textField($model,'ListNumber'); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->