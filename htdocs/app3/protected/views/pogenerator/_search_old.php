<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parent_id'); ?>
		<?php echo $form->textField($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subgroup'); ?>
		<?php echo $form->textField($model,'subgroup',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'make'); ?>
		<?php echo $form->textField($model,'make',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'measure_unit'); ?>
		<?php echo $form->textField($model,'measure_unit',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount'); ?>
		<?php echo $form->textField($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'warehouseId'); ?>
		<?php echo $form->textField($model,'warehouseId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'imageUrl'); ?>
		<?php echo $form->textField($model,'imageUrl',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fileUrl'); ?>
		<?php echo $form->textField($model,'fileUrl',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'isService'); ?>
		<?php echo $form->textField($model,'isService'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'depth'); ?>
		<?php echo $form->textField($model,'depth'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article'); ?>
		<?php echo $form->textField($model,'article',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'priceS'); ?>
		<?php echo $form->textField($model,'priceS'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oem'); ?>
		<?php echo $form->textArea($model,'oem',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'organizationId'); ?>
		<?php echo $form->textField($model,'organizationId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manufacturer'); ?>
		<?php echo $form->textField($model,'manufacturer',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'agroup'); ?>
		<?php echo $form->textField($model,'agroup',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'availability'); ?>
		<?php echo $form->textField($model,'availability'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MinPart'); ?>
		<?php echo $form->textField($model,'MinPart'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'YearBegin'); ?>
		<?php echo $form->textField($model,'YearBegin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'YearEnd'); ?>
		<?php echo $form->textField($model,'YearEnd'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Currency'); ?>
		<?php echo $form->textField($model,'Currency',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Analogi'); ?>
		<?php echo $form->textArea($model,'Analogi',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Barcode'); ?>
		<?php echo $form->textField($model,'Barcode',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Misc'); ?>
		<?php echo $form->textField($model,'Misc',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PartN'); ?>
		<?php echo $form->textField($model,'PartN',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'COF'); ?>
		<?php echo $form->textField($model,'COF',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Category'); ?>
		<?php echo $form->textField($model,'Category',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->