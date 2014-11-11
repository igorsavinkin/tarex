<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'load-data-settings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'TemplateName'); ?>
		<?php echo $form->textField($model,'TemplateName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'TemplateName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'СolumnSearch'); ?>
		<?php echo $form->textField($model,'СolumnSearch',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'СolumnSearch'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'СolumnNumber'); ?>
		<?php echo $form->textField($model,'СolumnNumber'); ?>
		<?php echo $form->error($model,'СolumnNumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ListNumber'); ?>
		<?php echo $form->textField($model,'ListNumber'); ?>
		<?php echo $form->error($model,'ListNumber'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->