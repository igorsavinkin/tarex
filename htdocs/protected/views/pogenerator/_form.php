<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assortment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td>
		<?php echo $form->labelEx($model,'parent_id'); ?> 
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
		<?php echo $form->error($model,'parent_id'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'subgroup'); ?> 
		<?php echo $form->textField($model,'subgroup',array('size'=>40,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'subgroup'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'title'); ?> 
		<?php echo $form->textField($model,'title',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'model'); ?> 
		<?php echo $form->textField($model,'model',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'model'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'make'); ?> 
		<?php echo $form->textField($model,'make',array('size'=>40,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'make'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'measure_unit'); ?> 
		<?php echo $form->textField($model,'measure_unit',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'measure_unit'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'price'); ?> 
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'discount'); ?> 
		<?php echo $form->textField($model,'discount'); ?>
		<?php echo $form->error($model,'discount'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'warehouseId'); ?> 
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
		<?php echo $form->error($model,'warehouseId'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'imageUrl'); ?> 
		<?php echo $form->textField($model,'imageUrl',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'imageUrl'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'fileUrl'); ?> 
		<?php echo $form->textField($model,'fileUrl',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'fileUrl'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'isService'); ?> 
		<?php echo $form->textField($model,'isService'); ?>
		<?php echo $form->error($model,'isService'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'depth'); ?> 
		<?php echo $form->textField($model,'depth'); ?>
		<?php echo $form->error($model,'depth'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'article'); ?> 
		<?php echo $form->textField($model,'article',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'article'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'priceS'); ?> 
		<?php echo $form->textField($model,'priceS'); ?>
		<?php echo $form->error($model,'priceS'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'oem'); ?> 
		<?php echo $form->textArea($model,'oem',array('rows'=>6, 'cols'=>40)); ?>
		<?php echo $form->error($model,'oem'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'organizationId'); ?> 
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
		<?php echo $form->error($model,'organizationId'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'manufacturer'); ?> 
		<?php echo $form->textField($model,'manufacturer',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'manufacturer'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'agroup'); ?> 
		<?php echo $form->textField($model,'agroup',array('size'=>40,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'agroup'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'availability'); ?> 
		<?php echo $form->textField($model,'availability'); ?>
		<?php echo $form->error($model,'availability'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'country'); ?> 
		<?php echo $form->textField($model,'country',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'country'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'MinPart'); ?> 
		<?php echo $form->textField($model,'MinPart'); ?>
		<?php echo $form->error($model,'MinPart'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'YearBegin'); ?> 
		<?php echo $form->textField($model,'YearBegin'); ?>
		<?php echo $form->error($model,'YearBegin'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'YearEnd'); ?> 
		<?php echo $form->textField($model,'YearEnd'); ?>
		<?php echo $form->error($model,'YearEnd'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'Currency'); ?> 
		<?php echo $form->textField($model,'Currency',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Currency'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'Analogi'); ?> 
		<?php echo $form->textArea($model,'Analogi',array('rows'=>6, 'cols'=>40)); ?>
		<?php echo $form->error($model,'Analogi'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'Barcode'); ?> 
		<?php echo $form->textField($model,'Barcode',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Barcode'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'Misc'); ?> 
		<?php echo $form->textField($model,'Misc',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Misc'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'PartN'); ?> 
		<?php echo $form->textField($model,'PartN',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'PartN'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'COF'); ?> 
		<?php echo $form->textField($model,'COF',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'COF'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'Category'); ?> 
		<?php echo $form->textField($model,'Category',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Category'); ?>
	</td>

	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save')); ?>
	</td>
	<td>	<?php echo CHtml::ajaxSubmitButton('ajaxSubmitButton', array('Assortment/update', 'id'=> $model->id), array('success'  => 'js: function(data) { $("#locator").html(data); } 
		function() { $.fn.yiiGridView.update("#assortment-grid");}'
		)); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->