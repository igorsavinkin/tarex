<?php
/* @var $this AccountsController */
/* @var $model Accounts */
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
		<?php echo $form->label($model,'CustomerName'); ?>
		<?php echo $form->textField($model,'CustomerName',array('size'=>40,'maxlength'=>255)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'AccountNumber'); ?>
		<?php echo $form->textField($model,'AccountNumber'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'AccountCurrency'); ?>
		<?php echo $form->textField($model,'AccountCurrency'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'AccountLimit'); ?>
		<?php echo $form->textField($model,'AccountLimit'); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'ParentCustomer'); ?>
		<?php echo $form->textField($model,'ParentCustomer'); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->