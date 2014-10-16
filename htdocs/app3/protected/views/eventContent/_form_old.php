<?php
/* @var $this EventContentController */
/* @var $model EventContent */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-content-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'eventId'); ?>
		<?php echo $form->textField($model,'eventId'); ?>
		<?php echo $form->error($model,'eventId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'assortmentId'); ?>
		<?php echo $form->textField($model,'assortmentId'); ?>
		<?php echo $form->error($model,'assortmentId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'assortmentAmount'); ?>
		<?php echo $form->textField($model,'assortmentAmount'); ?>
		<?php echo $form->error($model,'assortmentAmount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount'); ?>
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cost'); ?>
		<?php echo $form->textField($model,'cost'); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cost_w_discount'); ?>
		<?php echo $form->textField($model,'cost_w_discount'); ?>
		<?php echo $form->error($model,'cost_w_discount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->