<?php
/* @var $this SparePartController */
/* @var $model SparePart */
/* @var $form CActiveForm */
?>
<div class="form">
<table><tr valign='top'>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'spare-part-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>
	<?php echo $form->errorSummary($model); ?>
 
	<td colspan='2'>
		<?php echo $form->labelEx($model,'assortmentId'); ?> 
		<?php echo $form->textField($model,'assortmentId'); ?>  
		<?php echo $form->error($model,'assortmentId'); ?>
		
	</td>
	
	<td class='padding10side'>
		<?php echo $form->labelEx($model,'OEM'); ?> 
		<?php echo $form->textField($model,'OEM',array('size'=>40,'maxlength'=>255)); 
		 echo '<br>', CHtml::Link(Yii::t('general','Load a spare part by OEM') , array('assortment/admin', 'returnSparePart'=> $model->id), array('class'=>'btn-win'));
		?>		
		<?php echo $form->error($model,'OEM'); ?>
	</td>
<?php /*	
	<td>
		echo $form->labelEx($model,'article'); ?> 
		<?php echo $form->textField($model,'article',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'article'); 
	</td>
*/ ?>
</tr><tr  valign='top'> 
	<td>
		<?php echo $form->labelEx($model,'changeDate'); ?> 
		<?php   			
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
				} else { $lang = 'en-GB'; /* $options=array(); */ } 
				$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
					'model'=>$model,
					'attribute'=>'changeDate',
					'language'=> $lang,  
					'options'=>$options, 
					));  
				echo $form->error($model,'changeDate'); ?>
		<?php echo $form->error($model,'changeDate'); ?>
	</td>

 
	<td class='padding10side'>
		<?php echo $form->labelEx($model,'analogs'); ?> 
		<?php echo $form->textArea($model,'analogs',array('rows'=>4)); ?>
		<?php echo $form->error($model,'analogs'); ?>
	</td>

	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td>
	 
</tr></table> 
<?php $this->endWidget(); ?>
</div><!-- form -->