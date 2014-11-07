<?php
/* @var $this UserGroupDiscountController */
/* @var $model UserGroupDiscount */
/* @var $form CActiveForm */
?>
<div class="wide form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?> 
	<td>
		<?php echo $form->label($model,'userId'); ?>
		<?php 	$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'userId',
			'data' => CHtml::listData(User::model()->findAll(array('order'=>'username ASC','condition'=> '`role`=' . User::ROLE_USER)), 'id','username'),
			'options'=> array('allowClear'=>true, 
				'width' => '200', 
				'placeholder' => '', 
				),
		)); ?>
	</td>
	<td>
		<?php echo $form->label($model,'discountGroupId'); ?>
		<?php $this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'discountGroupId',
			'data' => CHtml::listData(DiscountGroup::model()->findAll(array('order'=>'name ASC')), 'id','name'),
			'options'=> array('allowClear'=>true, 
				'width' => '200', 
				'placeholder' => '', 
				),
		));   ?>
	</td> 
	<td class='padding10side'>
		<?php echo $form->label($model,'value'); ?>
		<?php echo $form->textField($model,'value'); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search'), array('class'=>'red')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->