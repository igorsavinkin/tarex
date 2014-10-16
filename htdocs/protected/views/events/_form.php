<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td>
		<?php echo $form->labelEx($model,'Subject'); ?> 
		<?php echo $form->textField($model,'Subject',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Subject'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'eventNumber'); ?> 
		<?php echo $form->textField($model,'eventNumber',array('size'=>40,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'eventNumber'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'Notes'); ?> 
		<?php echo $form->textArea($model,'Notes',array('rows'=>6, 'cols'=>40)); ?>
		<?php echo $form->error($model,'Notes'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'Place'); ?> 
		<?php echo $form->textField($model,'Place',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Place'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'EventTypeId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'EventTypeId',
						'data' => CHtml::listData(Eventtype::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
		<?php echo $form->error($model,'EventTypeId'); ?>
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

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'Begin'); ?> 
		<?php  $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'Begin',
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
		<?php echo $form->error($model,'Begin'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'End'); ?> 
		<?php  $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'End',
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
		<?php echo $form->error($model,'End'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'contractorId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'contractorId',
						'data' => CHtml::listData(Contractor::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
		<?php echo $form->error($model,'contractorId'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'contractId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'contractId',
						'data' => CHtml::listData(Contract::model()->findAll(array('order'=>'id ASC')), 'id','contractKod'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
		<?php echo $form->error($model,'contractId'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'Percentage'); ?> 
		<?php echo $form->textField($model,'Percentage'); ?>
		<?php echo $form->error($model,'Percentage'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'totalSum'); ?> 
		<?php echo $form->textField($model,'totalSum'); ?>
		<?php echo $form->error($model,'totalSum'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'ReflectInCalendar'); ?> 
		<?php echo $form->checkBox($model,'ReflectInCalendar'); ?>
		<?php echo $form->error($model,'ReflectInCalendar'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'ReflectInTree'); ?> 
		<?php echo $form->checkBox($model,'ReflectInTree'); ?>
		<?php echo $form->error($model,'ReflectInTree'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'parent_id'); ?>  
		<?php echo $form->textField($model,'parent_id'); ?>  
		<?php echo $form->error($model,'parent_id'); ?>
	</td>

</tr><tr> 
	  
	<td>
		<?php echo $form->labelEx($model,'Priority'); ?> 
		<?php echo $form->textField($model,'Priority'); ?>
		<?php echo $form->error($model,'Priority'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'StatusId'); ?> 
		<?php 	$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'StatusId',
						'data' => CHtml::listData(EventStatus::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
		<?php echo $form->error($model,'StatusId'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'Comment'); ?> 
		<?php echo $form->textField($model,'Comment',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Comment'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'PlanHours'); ?> 
		<?php echo $form->textField($model,'PlanHours'); ?>
		<?php echo $form->error($model,'PlanHours'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'FactHours'); ?> 
		<?php echo $form->textField($model,'FactHours'); ?>
		<?php echo $form->error($model,'FactHours'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'Tags'); ?> 
		<?php echo $form->textField($model,'Tags',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Tags'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'bizProcessId'); ?> 	 
		<?php echo $form->textField($model,'bizProcessId'); ?> 	 
		<?php echo $form->error($model,'bizProcessId'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'manualTransactionEditing'); ?> 
		<?php echo $form->checkBox($model,'manualTransactionEditing'); ?>
		<?php echo $form->error($model,'manualTransactionEditing'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'dateTimeForDelivery'); ?> 
		<?php  $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'dateTimeForDelivery',
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
		<?php echo $form->error($model,'dateTimeForDelivery'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'dateTimeForPayment'); ?> 
		<?php  $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'dateTimeForPayment',
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
		<?php echo $form->error($model,'dateTimeForPayment'); ?>
	</td>
	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td> 
	
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->