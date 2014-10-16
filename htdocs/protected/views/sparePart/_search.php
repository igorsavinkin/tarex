<?php
/* @var $this SparePartController */
/* @var $model SparePart */
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
		<?php echo $form->textField($model,'id'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'changeDate'); ?>
		<?php echo $form->textField($model,'changeDate'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'OEM'); ?>
		<?php echo $form->textField($model,'OEM',array('size'=>40,'maxlength'=>255)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'article'); ?>
		<?php echo $form->textField($model,'article',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'assortmentId'); ?>
		<?php echo $form->textField($model,'assortmentId'); ?> 
		<?php  /*$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'assortmentId',
						'data' => CHtml::listData(Assortment::model()->findAll(array('order'=>'title ASC')), 'id','title'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					));*/ ?>
	</td>

	<td>
		<?php echo $form->label($model,'analogs'); ?>
		<?php echo $form->textField($model,'analogs',array('size'=>40,'maxlength'=>1000)); ?>
	</td>

</tr><tr>	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->