<?php
/* @var $this MaxDiscountController */
/* @var $model MaxDiscount */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'max-discount-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td>
		<?php echo $form->labelEx($model,'prefix'); ?> 
		<?php echo $form->textField($model,'prefix',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'prefix'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'value'); ?> 
		<?php echo $form->textField($model,'value'); ?>
		<?php echo $form->error($model,'value'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'manufacturer'); ?> 
		<?php echo $form->textField($model,'manufacturer',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'manufacturer'); ?>
	</td>

</tr><tr>	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save')); ?>
	</td>
	<td>	<?php echo CHtml::ajaxSubmitButton('ajaxSubmitButton', array('Max Discount/update', 'id'=> $model->id), array('success'  => 'js: function(data) { $("#locator").html(data); } 
		function() { $.fn.yiiGridView.update("#max-discount-grid");}'
		)); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->