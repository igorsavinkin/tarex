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
		<?php echo $form->label($model,'Id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>5)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'articles'); ?>
		<?php echo $form->textField($model,'articles'); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'value'); ?>
		<?php echo $form->textField($model,'value',array('size'=>5,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'isActive'); ?>
		<?php echo $form->checkBox($model,'isActive'); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search'), array('class'=>'red')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->