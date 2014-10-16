<?php
/* @var $this AccountsController */
/* @var $model Accounts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CustomerName'); ?>
		<?php echo $form->textField($model,'CustomerName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'CustomerName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AccountNumber'); ?>
		<?php echo $form->textField($model,'AccountNumber'); ?>
		<?php echo $form->error($model,'AccountNumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AccountCurrency'); ?>
		<?php echo $form->textField($model,'AccountCurrency'); ?>
		<?php echo $form->error($model,'AccountCurrency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AccountLimit'); ?>
		<?php echo $form->textField($model,'AccountLimit'); ?>
		<?php echo $form->error($model,'AccountLimit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ParentCustomer'); ?>
		<?php echo $form->textField($model,'ParentCustomer'); ?>
		<?php echo $form->error($model,'ParentCustomer'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->