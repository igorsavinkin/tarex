<?php
/* @var $this PriceListSettingController */
/* @var $model PriceListSetting */
/* @var $form CActiveForm */
?>

<div class="wide form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?> 
	<td>		<?php echo $form->label($model,'userId'); ?>
		<?php $this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'userId',
						'data' => CHtml::listData(User::model()->findAll(array('order'=>'username ASC')), 'id', 'username'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
	</td>

	<td class='padding10side'>		<?php echo $form->label($model,'format'); ?>
		<?php $this->widget('ext.select2.ESelect2', array(						 
						'name'=> 'PriceListSetting[format]',
						'data' => $this->formats,
						'options'=> array('allowClear'=>true, 
							'width' => '150',  
							),
					)); ?>
	</td>
</tr><tr>	
	<td>
		<?php echo $form->label($model,'daysOfWeek'); ?>
		<?php echo $form->textField($model,'daysOfWeek', array('size'=>30,'maxlength'=>255)); ?>
	</td> 
	<td class='padding10side'>
		<?php echo $form->label($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
	</td> 
	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search'), array('class'=>'red')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?> 
</div><!-- search-form -->