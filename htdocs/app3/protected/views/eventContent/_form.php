<?php
/* @var $this EventContentController */
/* @var $model EventContent */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-content-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td>
		<?php echo $form->labelEx($model,'eventId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'eventId',
						'data' => CHtml::listData(Event::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
		<?php echo $form->error($model,'eventId'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'assortmentId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'assortmentId',
						'data' => CHtml::listData(Assortment::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
		<?php echo $form->error($model,'assortmentId'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'assortmentTitle'); ?> 
		<?php echo $form->textField($model,'assortmentTitle',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'assortmentTitle'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'assortmentAmount'); ?> 
		<?php echo $form->textField($model,'assortmentAmount'); ?>
		<?php echo $form->error($model,'assortmentAmount'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'discount'); ?> 
		<?php echo $form->textField($model,'discount'); ?>
		<?php echo $form->error($model,'discount'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'price'); ?> 
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'cost'); ?> 
		<?php echo $form->textField($model,'cost'); ?>
		<?php echo $form->error($model,'cost'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'cost_w_discount'); ?> 
		<?php echo $form->textField($model,'cost_w_discount'); ?>
		<?php echo $form->error($model,'cost_w_discount'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'RecommendedPrice'); ?> 
		<?php echo $form->textField($model,'RecommendedPrice'); ?>
		<?php echo $form->error($model,'RecommendedPrice'); ?>
	</td>

</tr><tr>	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save')); ?>
	</td>
	<td>	<?php echo CHtml::ajaxSubmitButton('ajaxSubmitButton', array('Event Content/update', 'id'=> $model->id), array('success'  => 'js: function(data) { $("#locator").html(data); } 
		function() { $.fn.yiiGridView.update("#event-content-grid");}'
		)); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->