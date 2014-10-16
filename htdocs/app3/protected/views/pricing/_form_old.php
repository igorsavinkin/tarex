<?php
/* @var $this PricingController */
/* @var $model Pricing */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pricing-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Date'); ?>
		<?php echo $form->textField($model,'Date'); ?>
		<?php echo $form->error($model,'Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Comment'); ?>
		<?php echo $form->textField($model,'Comment',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SubgroupFilter'); ?>
		<?php echo $form->textField($model,'SubgroupFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'SubgroupFilter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'TitleFilter'); ?>
		<?php echo $form->textField($model,'TitleFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'TitleFilter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ModelFilter'); ?>
		<?php echo $form->textField($model,'ModelFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'ModelFilter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'MakeFilter'); ?>
		<?php echo $form->textField($model,'MakeFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'MakeFilter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ArticleFilter'); ?>
		<?php echo $form->textField($model,'ArticleFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'ArticleFilter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'OemFilter'); ?>
		<?php echo $form->textField($model,'OemFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'OemFilter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ManufacturerFilter'); ?>
		<?php echo $form->textField($model,'ManufacturerFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'ManufacturerFilter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CountryFilter'); ?>
		<?php echo $form->textField($model,'CountryFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'CountryFilter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'FreeAssortmentFilter'); ?>
		<?php echo $form->textField($model,'FreeAssortmentFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'FreeAssortmentFilter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsernameFilter'); ?>
		<?php echo $form->textField($model,'UsernameFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'UsernameFilter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'GroupFilter'); ?>
		<?php echo $form->textField($model,'GroupFilter',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'GroupFilter'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->