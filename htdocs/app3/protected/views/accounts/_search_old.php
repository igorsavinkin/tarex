<?php
/* @var $this AccountsController */
/* @var $model Accounts */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CustomerName'); ?>
		<?php echo $form->textField($model,'CustomerName',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'AccountNumber'); ?>
		<?php echo $form->textField($model,'AccountNumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'AccountCurrency'); ?>
		<?php echo $form->textField($model,'AccountCurrency'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'AccountLimit'); ?>
		<?php echo $form->textField($model,'AccountLimit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ParentCustomer'); ?>
		<?php echo $form->textField($model,'ParentCustomer'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->