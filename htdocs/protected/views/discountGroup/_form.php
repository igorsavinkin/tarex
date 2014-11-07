<?php
/* @var $this DiscountGroupController */
/* @var $model DiscountGroup */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'discount-group-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td>
		<?php echo $form->labelEx($model,'name'); ?> 
		<?php echo $form->textField($model,'name',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'name'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'articles'); ?> 
		<?php echo $form->textArea($model,'articles',array('rows'=>6, 'cols'=>40)); ?>
		<?php echo $form->error($model,'articles'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'value'); ?> 
		<?php echo $form->textField($model,'value'); ?>
		<?php echo $form->error($model,'value'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'isActive'); ?> 
		<?php echo $form->checkBox($model,'isActive'); ?>
		<?php echo $form->error($model,'isActive'); ?>
	</td>

	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save')); ?>
	</td>
	<td>	<?php echo CHtml::ajaxSubmitButton('ajaxSubmitButton', array('Discount Group/update', 'id'=> $model->id), array('success'  => 'js: function(data) { $("#locator").html(data); } 
		function() { $.fn.yiiGridView.update("#discount-group-grid");}'
		)); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->