<?php
/* @var $this LoadDataSettingsController */
/* @var $data LoadDataSettings */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TemplateName')); ?>:</b>
	<?php echo CHtml::encode($data->TemplateName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('СolumnSearch')); ?>:</b>
	<?php echo CHtml::encode($data->СolumnSearch); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('СolumnNumber')); ?>:</b>
	<?php echo CHtml::encode($data->СolumnNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ListNumber')); ?>:</b>
	<?php echo CHtml::encode($data->ListNumber); ?>
	<br />


</div>