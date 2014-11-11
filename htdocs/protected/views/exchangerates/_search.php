<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */
?>
<!--br/><br/-->
<div class="wide form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
</tr><tr> 	
	<td style='padding:5px;'>	
	<label><?php echo Yii::t('general','Date'); ?></label>
		<?php  
			if ($UserRole<=5){
			$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
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
				'timeOnlyTitle' => 'Выберите часы',
				'timeText' => 'Время',
				'hourText'=>'Часы',
				'minuteText'=> 'Минуты',
				'secondText'=> 'Секунды', 				
				),
			));		 
			} else {
				echo Controller::FConvertDate($model->Begin);			
			} ?> 
	</td>
	<td> 
		<label><?php echo Yii::t('general','Currency'); // ===== ВАЛЮТА ===== ?></label>
		<?php  $this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'Currency',
						'data' =>  CHtml::listData(Currency::model()->findAll(array('order'=>'Name ASC')), 'name','name'), 
						'options'=> array('allowClear'=>true, 
							'width' => '100',  
							'placeholder' => '', 
							),
				)); ?> 
	</td> 
    
	<td class='padding5'> <label>
		<?php echo Yii::t('general','Cost in RUB'); ?>  </label>
		<?php echo $form->textField($model,'totalSum'); ?> 
	</td>  
	
	<td valign='top' width='250'>
		<?php  
			if (Yii::app()->user->role == User::ROLE_ADMIN) 
			{   echo $form->label($model,'organizationId'); 
				$Organizations = Organization::model()->findAll(array(
					'select'=>'t.name, t.id',
					'group'=>'t.name', 
					'distinct'=>true )); 
				
				$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,   
					'attribute'=> 'organizationId',
					'data' => CHtml::listData($Organizations, 'id','name'),
					'options'=> array('allowClear'=>true, 
					   'width' => '250', 
					   'placeholder' => '', 
						),
				)); 
				echo CHtml::Link(Yii::t('general','Edit Organizations') , array('organization/admin'), array('target'=>'_blank')); 
			}  
		   ?>
	</td> 
	<td align=center>
		<?php echo CHtml::submitButton(Yii::t('general','Search'), array('style'=> 'border-color: red;')); ?>
	</td>
<?php $this->endWidget(); ?>
</tr></table> 


</div><!-- search-form -->