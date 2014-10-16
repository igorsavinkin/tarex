<?php
/* @var $this PricesettingController */
/* @var $model Pricesetting */
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
		<?php echo $form->label($model,'dateTime'); ?>
		<?php  $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'dateTime',
			'language'=>'ru',
			 'options'=>array(
				'dateFormat'=>'yy-mm-dd',
				'timeFormat'=>strtolower(Yii::app()->locale->timeFormat),
				'changeMonth'=>'true',
				 'showSecond'=>true,
				'changeYear'=>'true',
				'changeHour'=>'true',
				//'showButtonPanel'=>'true',
				'timeOnlyTitle' => 'Выберите часы',
				'timeText' => 'Время',
				'hourText'=>'Часы',
				'minuteText'=> 'Минуты',
				'secondText'=> 'Секунды', 				
				),
			)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'RURrate'); ?>
		<?php echo $form->textField($model,'RURrate'); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'EURrate'); ?>
		<?php echo $form->textField($model,'EURrate'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'LBPrate'); ?>
		<?php echo $form->textField($model,'LBPrate'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'USDrate'); ?>
		<?php echo $form->textField($model,'USDrate'); ?>
	</td>

</tr><tr>	<td>
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

	<td>
		<?php echo $form->label($model,'personResponsible'); ?>
		<?php echo $form->textField($model,'personResponsible'); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->