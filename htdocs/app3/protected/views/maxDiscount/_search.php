<?php
/* @var $this MaxDiscountController */
/* @var $model MaxDiscount */
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
		<?php echo $form->label($model,'prefix'); ?>
		<?php echo $form->textField($model,'prefix',array('size'=>2,'maxlength'=>2)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'value'); ?>
		<?php echo $form->textField($model,'value'); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'manufacturer'); ?>
		<?php echo $form->textField($model,'manufacturer',array('size'=>11,'maxlength'=>11)); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->