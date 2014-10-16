<?php
/* @var $this PricingController */
/* @var $data Pricing */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Date')); ?>:</b>
	<?php echo CHtml::encode($data->Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Comment')); ?>:</b>
	<?php echo CHtml::encode($data->Comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SubgroupFilter')); ?>:</b>
	<?php echo CHtml::encode($data->SubgroupFilter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TitleFilter')); ?>:</b>
	<?php echo CHtml::encode($data->TitleFilter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ModelFilter')); ?>:</b>
	<?php echo CHtml::encode($data->ModelFilter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MakeFilter')); ?>:</b>
	<?php echo CHtml::encode($data->MakeFilter); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ArticleFilter')); ?>:</b>
	<?php echo CHtml::encode($data->ArticleFilter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('OemFilter')); ?>:</b>
	<?php echo CHtml::encode($data->OemFilter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ManufacturerFilter')); ?>:</b>
	<?php echo CHtml::encode($data->ManufacturerFilter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CountryFilter')); ?>:</b>
	<?php echo CHtml::encode($data->CountryFilter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FreeAssortmentFilter')); ?>:</b>
	<?php echo CHtml::encode($data->FreeAssortmentFilter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UsernameFilter')); ?>:</b>
	<?php echo CHtml::encode($data->UsernameFilter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GroupFilter')); ?>:</b>
	<?php echo CHtml::encode($data->GroupFilter); ?>
	<br />

	*/ ?>

</div>