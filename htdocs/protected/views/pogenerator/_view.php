<?php
/* @var $this PogeneratorController */
/* @var $data Assortment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->parent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subgroup')); ?>:</b>
	<?php echo CHtml::encode($data->subgroup); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model')); ?>:</b>
	<?php echo CHtml::encode($data->model); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('make')); ?>:</b>
	<?php echo CHtml::encode($data->make); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('measure_unit')); ?>:</b>
	<?php echo CHtml::encode($data->measure_unit); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount')); ?>:</b>
	<?php echo CHtml::encode($data->discount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('warehouseId')); ?>:</b>
	<?php echo CHtml::encode($data->warehouseId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imageUrl')); ?>:</b>
	<?php echo CHtml::encode($data->imageUrl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fileUrl')); ?>:</b>
	<?php echo CHtml::encode($data->fileUrl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isService')); ?>:</b>
	<?php echo CHtml::encode($data->isService); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('depth')); ?>:</b>
	<?php echo CHtml::encode($data->depth); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article')); ?>:</b>
	<?php echo CHtml::encode($data->article); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('priceS')); ?>:</b>
	<?php echo CHtml::encode($data->priceS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oem')); ?>:</b>
	<?php echo CHtml::encode($data->oem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organizationId')); ?>:</b>
	<?php echo CHtml::encode($data->organizationId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agroup')); ?>:</b>
	<?php echo CHtml::encode($data->agroup); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('availability')); ?>:</b>
	<?php echo CHtml::encode($data->availability); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MinPart')); ?>:</b>
	<?php echo CHtml::encode($data->MinPart); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('YearBegin')); ?>:</b>
	<?php echo CHtml::encode($data->YearBegin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('YearEnd')); ?>:</b>
	<?php echo CHtml::encode($data->YearEnd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Currency')); ?>:</b>
	<?php echo CHtml::encode($data->Currency); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Analogi')); ?>:</b>
	<?php echo CHtml::encode($data->Analogi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Barcode')); ?>:</b>
	<?php echo CHtml::encode($data->Barcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Misc')); ?>:</b>
	<?php echo CHtml::encode($data->Misc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PartN')); ?>:</b>
	<?php echo CHtml::encode($data->PartN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('COF')); ?>:</b>
	<?php echo CHtml::encode($data->COF); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Category')); ?>:</b>
	<?php echo CHtml::encode($data->Category); ?>
	<br />

	*/ ?>

</div>