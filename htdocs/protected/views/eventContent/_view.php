<?php
/* @var $this EventContentController */
/* @var $data EventContent */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eventId')); ?>:</b>
	<?php echo CHtml::encode($data->eventId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assortmentId')); ?>:</b>
	<?php echo CHtml::encode($data->assortmentId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assortmentAmount')); ?>:</b>
	<?php echo CHtml::encode($data->assortmentAmount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount')); ?>:</b>
	<?php echo CHtml::encode($data->discount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
	<?php echo CHtml::encode($data->cost); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cost_w_discount')); ?>:</b>
	<?php echo CHtml::encode($data->cost_w_discount); ?>
	<br />

	*/ ?>

</div>