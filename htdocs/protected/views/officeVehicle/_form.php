<?php
/* @var $this OfficeVehicleController */
/* @var $model OfficeVehicle */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'office-vehicle-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>
 
	
	<td  >
		<?php echo $form->labelEx($model,'make'); ?> 
		<?php echo $form->textField($model,'make',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'make'); ?>
	</td>

 
	<td class='padding10side'>
		<?php echo $form->labelEx($model,'model'); ?> 
		<?php echo $form->textField($model,'model',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'model'); ?>
	</td>
	
	<td>
		<?php echo $form->labelEx($model,'driver'); ?> 
		<?php echo $form->textField($model,'driver',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'driver'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'vin'); ?> 
		<?php echo $form->textField($model,'vin',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'vin'); ?>
	</td>
 
    <td class='padding10side'>
		<?php echo $form->labelEx($model,'first_registration_date'); ?> 
		<?php  
		if (Yii::app()->user->role <= 2)
			{				
				if (Yii::app()->language == 'ru')   
				{       
					$options = array(
						'dateFormat'=>'yy-mm-dd',  
						'timeFormat'=>strtolower(Yii::app()->locale->timeFormat),
						'changeMonth'=>'true',  
						'showSecond'=>true,
						'changeYear'=>'true',
						'changeHour'=>'true', 
						'timeOnlyTitle' => 'Выберите часы',
						'timeText' => 'Время',
						'hourText'=>'Часы',
						'minuteText'=> 'Минуты',
						'secondText'=> 'Секунды');
						$lang = 'ru';
				} else { $lang = 'en-GB'; } 
				$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
					'model'=>$model,
					'attribute'=>'first_registration_date',
					'language'=> $lang,  
					'options'=>$options, 
					));  
				echo $form->error($model,'first_registration_date');
			} else {
				echo Controller::FConvertDate($model->first_registration_date);			
			} 
		?> 		
	</td> 
	
	<td >
		<?php echo $form->labelEx($model,'milage'); ?> 
		<?php echo $form->textField($model,'milage',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'milage'); ?>
	</td>
</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'last_maintenance_date'); ?> 
		<?php 
		if (Yii::app()->user->role <= 2)
			{				
				if (Yii::app()->language == 'ru')   
				{       
					$options = array(
						'dateFormat'=>'yy-mm-dd',  
						'timeFormat'=>strtolower(Yii::app()->locale->timeFormat),
						'changeMonth'=>'true',  
						'showSecond'=>true,
						'changeYear'=>'true',
						'changeHour'=>'true', 
						'timeOnlyTitle' => 'Выберите часы',
						'timeText' => 'Время',
						'hourText'=>'Часы',
						'minuteText'=> 'Минуты',
						'secondText'=> 'Секунды');
						$lang = 'ru';
				} else { $lang = 'en-GB'; } 
				$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
					'model'=>$model,
					'attribute'=>'last_maintenance_date',
					'language'=> $lang,  
					'options'=>$options, 
					));  
				echo $form->error($model,'last_maintenance_date');
			} else {
				echo Controller::FConvertDate($model->last_maintenance_date);			
			} 
		?> 	 
	</td> 

	<td class='padding10side'>
		<?php echo $form->labelEx($model,'milage_since_last_maintenance'); ?> 
		<?php echo $form->textField($model,'milage_since_last_maintenance',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'milage_since_last_maintenance'); ?>
	</td>

	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td> 
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->