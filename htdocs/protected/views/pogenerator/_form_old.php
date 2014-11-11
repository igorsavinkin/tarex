<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assortment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->textField($model,'parent_id'); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subgroup'); ?>
		<?php echo $form->textField($model,'subgroup',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'subgroup'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'model'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'make'); ?>
		<?php echo $form->textField($model,'make',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'make'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'measure_unit'); ?>
		<?php echo $form->textField($model,'measure_unit',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'measure_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount'); ?>
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'warehouseId'); ?>
		<?php echo $form->textField($model,'warehouseId'); ?>
		<?php echo $form->error($model,'warehouseId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'imageUrl'); ?>
		<?php echo $form->textField($model,'imageUrl',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'imageUrl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fileUrl'); ?>
		<?php echo $form->textField($model,'fileUrl',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'fileUrl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isService'); ?>
		<?php echo $form->textField($model,'isService'); ?>
		<?php echo $form->error($model,'isService'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'depth'); ?>
		<?php echo $form->textField($model,'depth'); ?>
		<?php echo $form->error($model,'depth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article'); ?>
		<?php echo $form->textField($model,'article',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'article'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'priceS'); ?>
		<?php echo $form->textField($model,'priceS'); ?>
		<?php echo $form->error($model,'priceS'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oem'); ?>
		<?php echo $form->textArea($model,'oem',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'oem'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'organizationId'); ?>
		<?php echo $form->textField($model,'organizationId'); ?>
		<?php echo $form->error($model,'organizationId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer'); ?>
		<?php echo $form->textField($model,'manufacturer',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'manufacturer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'agroup'); ?>
		<?php echo $form->textField($model,'agroup',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'agroup'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'availability'); ?>
		<?php echo $form->textField($model,'availability'); ?>
		<?php echo $form->error($model,'availability'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'MinPart'); ?>
		<?php echo $form->textField($model,'MinPart'); ?>
		<?php echo $form->error($model,'MinPart'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'YearBegin'); ?>
		<?php echo $form->textField($model,'YearBegin'); ?>
		<?php echo $form->error($model,'YearBegin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'YearEnd'); ?>
		<?php echo $form->textField($model,'YearEnd'); ?>
		<?php echo $form->error($model,'YearEnd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Currency'); ?>
		<?php echo $form->textField($model,'Currency',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Currency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Analogi'); ?>
		<?php echo $form->textArea($model,'Analogi',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Analogi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Barcode'); ?>
		<?php echo $form->textField($model,'Barcode',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Barcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Misc'); ?>
		<?php echo $form->textField($model,'Misc',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Misc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PartN'); ?>
		<?php echo $form->textField($model,'PartN',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'PartN'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'COF'); ?>
		<?php echo $form->textField($model,'COF',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'COF'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Category'); ?>
		<?php echo $form->textField($model,'Category',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Category'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->