<?php
/* @var $this PricesettingController */
/* @var $data Pricesetting */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dateTime')); ?>:</b>
	<?php echo CHtml::encode($data->dateTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RURrate')); ?>:</b>
	<?php echo CHtml::encode($data->RURrate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('EURrate')); ?>:</b>
	<?php echo CHtml::encode($data->EURrate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LBPrate')); ?>:</b>
	<?php echo CHtml::encode($data->LBPrate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('USDrate')); ?>:</b>
	<?php echo CHtml::encode($data->USDrate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organizationId')); ?>:</b>
	<?php echo CHtml::encode($data->organizationId); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('personResponsible')); ?>:</b>
	<?php echo CHtml::encode($data->personResponsible); ?>
	<br />

	*/ ?>

</div>