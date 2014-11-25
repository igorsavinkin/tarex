<?php
/* @var $this PriceListSettingController */
/* @var $model PriceListSetting */
/* @var $form CActiveForm */ 
//print_r(Yii::app()->locale->weekDayNames);
 ?>
<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'price-list-setting-form', 
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>
 
	<td class='padding10side'>
		<?php if(Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
		{
			echo $form->labelEx($model,'userId');  	
			$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'userId',
				'data' => CHtml::listData(User::model()->findAll(array('order'=>'username ASC')), 'id','username'),
				'options'=> array('allowClear'=>true, 
					'width' => '220',  
					),
			));  
			echo $form->error($model,'userId');
		} ?>
	</td>
	<td rowspan='5' class='padding10side' width='100px'> 
		<?php  

		
		    $model->daysOfWeek = explode(',' , $model->daysOfWeek ); // мы вытаскиваем из строковой переменной дни недели разделённые через запятую
		    echo $form->labelEx($model,'daysOfWeek');  
			echo $form->checkBoxList($model, 'daysOfWeek', Yii::app()->locale->getWeekDayNames('abbreviated'), array('template'=>'{input}{label}', 'separator'=>'', 'class'=>'checkBoxClass') );
		/*	$this->widget('ext.EchMultiSelect.EchMultiSelect', array(
				'model' => $model,
				'dropDownAttribute' => 'daysOfWeek',     
				'data' => Yii::app()->locale->weekDayNames,
				'dropDownHtmlOptions'=> array(
					'style'=>'width:140px;',
				),
			)); */ ?>
		<?php echo $form->error($model,'daysOfWeek'); ?>
	</td>
</tr><tr> 	
	<td class='padding10'>
		<?php echo $form->labelEx($model,'format'); ?> 
		<?php $this->widget('ext.select2.ESelect2', array(						 
						'model'=> $model,
						'attribute'=> 'format',
						'data' => $this->formats,
						'options'=> array('allowClear'=>true, 
							'width' => '150',  
							),
					)); ?>
		<?php echo $form->error($model,'format'); ?>
	</td> 
</tr><tr> 
	<td class='padding10'>
		<?php echo $form->labelEx($model,'email'); ?> 
		<?php echo $form->textField($model,'email',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</td>
	
</tr><tr> 
	
	<td class='padding10side'>
		<?php echo $form->labelEx($model,'time'); ?> 
		<?php if (Yii::app()->language == 'ru')   
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
		} else { $lang = 'en-GB';
				    $options=array('timeFormat'=>strtolower(Yii::app()->locale->timeFormat)); } 
		
		 $this->widget( 'ext.EJuiTimePicker.EJuiTimePicker', array(
			  'model' => $model, // Your model
			  'attribute' => 'time', // Attribute for input
			  'timeHtmlOptions' => array(
				  'size' => 5,
				  'maxlength' => 5,
				),
			  'mode' => 'time',
			));  
		echo $form->error($model,'time'); ?> 
	</td >
</tr><tr>	
	<td class='padding10'>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td> 
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->
<style>
#PriceListSetting_daysOfWeek input {
    float: left;
    margin-right: 10px;
}
.checkBoxClass {
	float: left;
}
</style>
