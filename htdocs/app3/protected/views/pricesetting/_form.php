<?php
/* @var $this PricesettingController */
/* @var $model Pricesetting */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pricesetting-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 <?php /* 
	<td>
		 echo $form->labelEx($model,'dateTime'); ?> 
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
		<?php echo $form->error($model,'dateTime');
	</td> */?>

 
	<td>
		<?php echo $form->labelEx($model,'RURrate'); ?> 
		<?php echo $form->textField($model,'RURrate'); ?>
		<?php echo $form->error($model,'RURrate'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'EURrate'); ?> 
		<?php echo $form->textField($model,'EURrate'); ?>
		<?php echo $form->error($model,'EURrate'); ?>
	</td>

</tr><tr>  
	<td>
		<?php echo $form->labelEx($model,'LBPrate'); ?> 
		<?php echo $form->textField($model,'LBPrate'); ?>
		<?php echo $form->error($model,'LBPrate'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'USDrate'); ?> 
		<?php echo $form->textField($model,'USDrate'); ?>
		<?php echo $form->error($model,'USDrate'); ?>
	</td>

<?php /* 
	<td>
		echo $form->labelEx($model,'organizationId'); ?> 
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
		<?php echo $form->error($model,'organizationId');
	</td>*/ ?>
 
 <?php /*
	<td>
		 echo $form->labelEx($model,'personResponsible'); ?> 
		<?php echo $form->textField($model,'personResponsible'); ?>
		<?php echo $form->error($model,'personResponsible'); 
	</td>
	*/ ?>
</tr><tr>	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td> 
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->