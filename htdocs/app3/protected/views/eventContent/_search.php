<?php
/* @var $this EventContentController */
/* @var $model EventContent */
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
		<?php echo $form->label($model,'eventId'); ?>
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'eventId',
						'data' => CHtml::listData(Events::model()->findAll(array('order'=>'Subject ASC')), 'id','Subject'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
	</td>
  
</tr><tr>	
	<td>
		<?php echo $form->label($model,'assortmentTitle'); ?>
		<?php echo $form->textField($model,'assortmentTitle',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'assortmentAmount'); ?>
		<?php echo $form->textField($model,'assortmentAmount'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'discount'); ?>
		<?php echo $form->textField($model,'discount'); ?>
	</td>

</tr><tr>	
	<td>
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'cost'); ?>
		<?php echo $form->textField($model,'cost'); ?>
	</td> 
</tr><tr>	
	<td>
		<?php echo $form->label($model,'RecommendedPrice'); ?>
		<?php echo $form->textField($model,'RecommendedPrice'); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->