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
 <td>
		<?php echo $form->label($model,'StatusId'); ?>
		<?php $this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'StatusId',
						'data' => CHtml::listData(EventStatus::model()->findAll(array('order'=>'name ASC')), 'id', 'name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							),
					)); ?>
	</td>

	<td>
	<?php //echo ' Поиск по контрагенту:';
	  //echo ' Контрагент ';
		echo $form->label($model,'contractorId'); 
		$this->widget('ext.select2.ESelect2', array(
		'model'=> $model,
		'attribute'=> 'contractorId',
		'data' => CHtml::listData(Contractor::model()->findAll(), 'id','name'),
			 'options'=> array('allowClear'=>true, 
							   'width' => '150', 
								'placeholder' => '',//'minimumInputLength' => 3
								),
		));	?>
	</td>
	<td>
		<?php echo $form->label($model,'EventTypeId'); ?>
		<?php $this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'EventTypeId',
						'data' => CHtml::listData(Eventtype::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); ?>
	</td>

</tr><tr>	 

	<td>
		<?php echo $form->label($model,'Begin'); ?>
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
	</td>

	<td>
		<?php echo $form->label($model,'End'); ?>
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
	</td>
		<?php/*
    <td>
		<?php  echo $form->label($model,'dateTimeForPayment');   $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
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
			));   ?>
	</td> */ ?>
   <td>
		<?php echo $form->label($model,'Tags'); ?>
		<?php echo $form->textField($model,'Tags',array('size'=>40,'maxlength'=>200)); ?>
	</td>
</tr><tr>	
	
<?php /*
	<td colspan=2>
		<?php echo $form->label($model,'Notes'); ?>
		<?php echo $form->textArea($model,'Notes',array('rows'=>4, 'cols'=>80)); ?>
	</td>
	*/ ?> 
	<td align=center>
		<?php echo CHtml::submitButton(Yii::t('general','Search'), array('style'=> 'border-color: red;')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->