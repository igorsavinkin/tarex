<?php
/* @var $this EventContentController */
/* @var $model EventContent */
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
		<?php echo $form->label($model,'eventId'); ?>
		<?php echo $form->textField($model,'eventId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'assortmentId'); ?>
		<?php echo $form->textField($model,'assortmentId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'assortmentAmount'); ?>
		<?php echo $form->textField($model,'assortmentAmount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount'); ?>
		<?php echo $form->textField($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cost'); ?>
		<?php echo $form->textField($model,'cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cost_w_discount'); ?>
		<?php echo $form->textField($model,'cost_w_discount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->