<?php
/* @var $this SearchTermController */
/* @var $model SearchTerm */
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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'frequency'); ?>
		<?php echo $form->textField($model,'frequency'); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'firstOccurance'); ?>
		<?php echo $form->textField($model,'firstOccurance'); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->