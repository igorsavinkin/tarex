<?php
/* @var $this OfficeVehicleController */
/* @var $model OfficeVehicle */
/* @var $form CActiveForm */
?>

<div class="wide form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<td>
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'first_registration_date'); ?>
		<?php echo $form->textField($model,'first_registration_date'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'make'); ?>
		<?php echo $form->textField($model,'make',array('size'=>40,'maxlength'=>255)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'vin'); ?>
		<?php echo $form->textField($model,'vin',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'milage'); ?>
		<?php echo $form->textField($model,'milage',array('size'=>12,'maxlength'=>12)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'last_maintenance_date'); ?>
		<?php echo $form->textField($model,'last_maintenance_date'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'milage_since_last_maintenance'); ?>
		<?php echo $form->textField($model,'milage_since_last_maintenance',array('size'=>12,'maxlength'=>12)); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->