<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */
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
		<?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'parent_id'); ?>
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'parent_id',
						'data' => CHtml::listData(Parent_::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'subgroup'); ?>
		<?php echo $form->textField($model,'subgroup',array('size'=>40,'maxlength'=>250)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'make'); ?>
		<?php echo $form->textField($model,'make',array('size'=>40,'maxlength'=>50)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'measure_unit'); ?>
		<?php echo $form->textField($model,'measure_unit',array('size'=>20,'maxlength'=>20)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'discount'); ?>
		<?php echo $form->textField($model,'discount'); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'warehouseId'); ?>
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'warehouseId',
						'data' => CHtml::listData(Warehouse::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'imageUrl'); ?>
		<?php echo $form->textField($model,'imageUrl',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'fileUrl'); ?>
		<?php echo $form->textField($model,'fileUrl',array('size'=>40,'maxlength'=>255)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'isService'); ?>
		<?php echo $form->textField($model,'isService'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'depth'); ?>
		<?php echo $form->textField($model,'depth'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'article'); ?>
		<?php echo $form->textField($model,'article',array('size'=>40,'maxlength'=>200)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'priceS'); ?>
		<?php echo $form->textField($model,'priceS'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'oem'); ?>
		<?php echo $form->textArea($model,'oem',array('rows'=>6, 'cols'=>40)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'organizationId'); ?>
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'organizationId',
						'data' => CHtml::listData(Organization::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'manufacturer'); ?>
		<?php echo $form->textField($model,'manufacturer',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'agroup'); ?>
		<?php echo $form->textField($model,'agroup',array('size'=>40,'maxlength'=>50)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'availability'); ?>
		<?php echo $form->textField($model,'availability'); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'MinPart'); ?>
		<?php echo $form->textField($model,'MinPart'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'YearBegin'); ?>
		<?php echo $form->textField($model,'YearBegin'); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'YearEnd'); ?>
		<?php echo $form->textField($model,'YearEnd'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'Currency'); ?>
		<?php echo $form->textField($model,'Currency',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'Analogi'); ?>
		<?php echo $form->textArea($model,'Analogi',array('rows'=>6, 'cols'=>40)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'Barcode'); ?>
		<?php echo $form->textField($model,'Barcode',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'Misc'); ?>
		<?php echo $form->textField($model,'Misc',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'PartN'); ?>
		<?php echo $form->textField($model,'PartN',array('size'=>40,'maxlength'=>255)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'COF'); ?>
		<?php echo $form->textField($model,'COF',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'Category'); ?>
		<?php echo $form->textField($model,'Category',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->