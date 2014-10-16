<?php
/* @var $this OfficeVehicleController */
/* @var $data OfficeVehicle */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_registration_date')); ?>:</b>
	<?php echo CHtml::encode($data->first_registration_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('make')); ?>:</b>
	<?php echo CHtml::encode($data->make); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model')); ?>:</b>
	<?php echo CHtml::encode($data->model); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vin')); ?>:</b>
	<?php echo CHtml::encode($data->vin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('milage')); ?>:</b>
	<?php echo CHtml::encode($data->milage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_maintenance_date')); ?>:</b>
	<?php echo CHtml::encode($data->last_maintenance_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('milage_since_last_maintenance')); ?>:</b>
	<?php echo CHtml::encode($data->milage_since_last_maintenance); ?>
	<br />

	*/ ?>

</div>