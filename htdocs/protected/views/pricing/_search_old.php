<?php
/* @var $this PricingController */
/* @var $model Pricing */
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
		<?php echo $form->label($model,'Date'); ?>
		<?php echo $form->textField($model,'Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Comment'); ?>
		<?php echo $form->textField($model,'Comment',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SubgroupFilter'); ?>
		<?php echo $form->textField($model,'SubgroupFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TitleFilter'); ?>
		<?php echo $form->textField($model,'TitleFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ModelFilter'); ?>
		<?php echo $form->textField($model,'ModelFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MakeFilter'); ?>
		<?php echo $form->textField($model,'MakeFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ArticleFilter'); ?>
		<?php echo $form->textField($model,'ArticleFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'OemFilter'); ?>
		<?php echo $form->textField($model,'OemFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ManufacturerFilter'); ?>
		<?php echo $form->textField($model,'ManufacturerFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CountryFilter'); ?>
		<?php echo $form->textField($model,'CountryFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FreeAssortmentFilter'); ?>
		<?php echo $form->textField($model,'FreeAssortmentFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'UsernameFilter'); ?>
		<?php echo $form->textField($model,'UsernameFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GroupFilter'); ?>
		<?php echo $form->textField($model,'GroupFilter',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->