<?php
/* @var $this AccountsController */
/* @var $data Accounts */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CustomerName')); ?>:</b>
	<?php echo CHtml::encode($data->CustomerName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AccountNumber')); ?>:</b>
	<?php echo CHtml::encode($data->AccountNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AccountCurrency')); ?>:</b>
	<?php echo CHtml::encode($data->AccountCurrency); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AccountLimit')); ?>:</b>
	<?php echo CHtml::encode($data->AccountLimit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ParentCustomer')); ?>:</b>
	<?php echo CHtml::encode($data->ParentCustomer); ?>
	<br />


</div>