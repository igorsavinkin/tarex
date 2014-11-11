<?php
/* @var $this ContractorDenisController */
/* @var $model ContractorDenis */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contractor-denis-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td>
		<?php echo $form->labelEx($model,'name'); ?> 
		<?php echo $form->textField($model,'name',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'address'); ?> 
		<?php echo $form->textField($model,'address',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'address'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'phone'); ?> 
		<?php echo $form->textField($model,'phone',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'email'); ?> 
		<?php echo $form->textField($model,'email',array('size'=>40,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email'); ?>
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
		<?php echo $form->labelEx($model,'userId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'userId',
						'data' => CHtml::listData(User::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
		<?php echo $form->error($model,'userId'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'note'); ?> 
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>40)); ?>
		<?php echo $form->error($model,'note'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'inn'); ?> 
		<?php echo $form->textField($model,'inn',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'inn'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'kpp'); ?> 
		<?php echo $form->textField($model,'kpp',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'kpp'); ?>
	</td>

</tr><tr>	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save')); ?>
	</td>
	<td>	<?php echo CHtml::ajaxSubmitButton('ajaxSubmitButton', array('Contractor Denis/update', 'id'=> $model->id), array('success'  => 'js: function(data) { $("#locator").html(data); } 
		function() { $.fn.yiiGridView.update("#contractor-denis-grid");}'
		)); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->