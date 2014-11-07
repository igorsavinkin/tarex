<?php
/* @var $this UserGroupDiscountController */
/* @var $model UserGroupDiscount */
/* @var $form CActiveForm */
?>
<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-group-discount-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>
	<?php echo $form->errorSummary($model); ?> 
	<td>
		<?php echo $form->labelEx($model,'userId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'userId',
			'data' => CHtml::listData(User::model()->findAll(array('order'=>'username ASC','condition'=> '`role`=' . User::ROLE_USER)), 'id','username'),
			'options'=> array('allowClear'=>true, 
				'width' => '200', 'placeholder' => '', 
				),
		)); ?>
		<?php echo $form->error($model,'userId'); ?>
	</td> 
	<td class='padding5side'>
		<?php echo $form->labelEx($model,'discountGroupId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'discountGroupId',
			'data' => CHtml::listData(DiscountGroup::model()->findAll(array('order'=>'name ASC')), 'id','name'),
			'options'=> array('allowClear'=>true, 
				'width' => '150', 
				'placeholder' => '', 
				),
		));  
		echo $form->error($model,'discountGroupId'); ?>
	</td> 
	<td class='padding5side'>
		<?php echo $form->labelEx($model,'value'); ?> 
		<?php echo $form->textField($model,'value', array('size'=>15)); ?>
		<?php echo $form->error($model,'value'); ?>
	</td> 	
	<td class='bottom'>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td> 
</tr></table> 
<?php $this->endWidget(); ?>
</div><!-- form -->