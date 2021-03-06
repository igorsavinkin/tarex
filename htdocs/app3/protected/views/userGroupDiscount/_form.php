<?php
/* @var $this UserGroupDiscountController */
/* @var $model UserGroupDiscount */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-group-discount-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td>
		<?php echo $form->labelEx($model,'userId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'userId',
						'data' => CHtml::listData(User::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
		<?php echo $form->error($model,'userId'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'discountGroupId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'discountGroupId',
						'data' => CHtml::listData(Discountgroup::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
		<?php echo $form->error($model,'discountGroupId'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'value'); ?> 
		<?php echo $form->textField($model,'value'); ?>
		<?php echo $form->error($model,'value'); ?>
	</td>

</tr><tr>	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save')); ?>
	</td>
	<td>	<?php echo CHtml::ajaxSubmitButton('ajaxSubmitButton', array('User Group Discount/update', 'id'=> $model->id), array('success'  => 'js: function(data) { $("#locator").html(data); } 
		function() { $.fn.yiiGridView.update("#user-group-discount-grid");}'
		)); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->