<?php
/* @var $this DiscountGroupController */
/* @var $model DiscountGroup */
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
		<?php echo $form->textField($model,'name',array('size'=>4,'maxlength'=>4)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'articles'); ?>
		<?php echo $form->textArea($model,'articles',array('rows'=>6, 'cols'=>40)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'value'); ?>
		<?php echo $form->textField($model,'value'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'isActive'); ?>
		<?php echo $form->checkBox($model,'isActive'); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->