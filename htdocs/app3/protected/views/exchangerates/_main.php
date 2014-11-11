<?php
/* @var $this ExchangeratesController */
/* @var $model Exchangerates */
/* @var $form CActiveForm */


	$UserRole=Yii::app()->user->role;
	$OrganizationId=Yii::app()->user->organization;
	//$UserRole=6;
	$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;
 
  
?>

<div class="form">
<table><tr valign="middle">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
)); 
?>
	
	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>
 
	<td>
		<?php 
		echo $form->labelEx($model,'eventNumber');   
		if($model->isNewRecord){
			echo $model->id;
		}else{
			if ($UserRole<=2) {
				echo $form->textField($model,'id',array('size'=>10,'maxlength'=>20));  
				echo $form->error($model,'id');
				}
			else echo $model->id;
		}  ?>
	</td>

	<td style='padding:5px;'>	<label>
		<?php 		//Дата
		echo Yii::t('general','Date'); ?></label>
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
			}
			
		?>
		<?php echo $form->error($model,'Begin'); ?>
	</td>
	<td> 
		<label><?php // ===== ВАЛЮТА =====		
		echo Yii::t('general','Currency') ?> </label>
		<?php  $this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'Currency',
						'data' =>  CHtml::listData(Currency::model()->findAll(array('order'=>'Name ASC')), 'name','name'), 
						'options'=> array('allowClear'=>true, 
							'width' => '100',  
							'placeholder' => '',
							),
				)); ?>
		<?php echo $form->error($model,'Currency'); ?>
	</td> 
 
	<td class='padding5'> <label>
		<?php echo Yii::t('general','Cost in RUB'); ?>  </label>
		<?php echo $form->textField($model,'totalSum'); ?>
		<?php echo $form->error($model,'totalSum'); ?>
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
				echo $form->error($model,'organizationId');
				echo CHtml::Link(Yii::t('general','Edit Organizations') , array('organization/admin'), array('target'=>'_blank')); 
			}  
		   ?>
	</td> 
	
	<td>	<?php  
	echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 
	?>
	</td>  
	
</tr></table> 
<?php $this->endWidget(); ?>
 
</div><!-- form -->