<?php
/* @var $this DiscountGroupController */
/* @var $model DiscountGroup */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'discount-group-form', 
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td class='padding5side top'>
		<?php echo $form->labelEx($model,'name'); ?> 
		<?php echo $form->textField($model,'name',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'name'); ?>
	<br>	
		<?php echo $form->labelEx($model,'value'); ?> 
		<?php echo $form->textField($model,'value'); ?>
		<?php echo $form->error($model,'value'); ?>
	<br>	
		<?php echo $form->labelEx($model,'isActive'); ?> 
		<?php echo $form->checkBox($model,'isActive'); ?>
		<?php echo $form->error($model,'isActive'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'articles'); ?> 
		<?php echo $form->textArea($model,'articles',array('rows'=>7, 'cols'=>80)); ?>
		<?php echo $form->error($model,'articles'); ?>
	</td>
 
</tr><tr>  
	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td> 
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->