<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */
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
		<?php echo $form->label($model,'TemplateName'); ?>
		<?php echo $form->textField($model,'TemplateName',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'СolumnSearch'); ?>
		<?php echo $form->textField($model,'СolumnSearch',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'СolumnNumber'); ?>
		<?php echo $form->textField($model,'СolumnNumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ListNumber'); ?>
		<?php echo $form->textField($model,'ListNumber'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->