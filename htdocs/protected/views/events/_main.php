<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */


	$UserRole=Yii::app()->user->role;

	$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;
 
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
)); 




?>
	
	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 


 
	<td>
		<?php echo $form->labelEx($model,'eventNumber');   

		?> 
		<?php if ($UserRole<=2) echo $form->textField($model,'eventNumber',array('size'=>10,'maxlength'=>20)); 		else echo $model->id;
		?>
		
		<?php echo $form->error($model,'eventNumber'); ?>
	</td>

	<td>
		<?php echo '<strong>Дата: </strong>'; ?> 
		<?php  
			if ($UserRole<=2){
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
				//'showButtonPanel'=>'true',
				'timeOnlyTitle' => 'Выберите часы',
				'timeText' => 'Время',
				'hourText'=>'Часы',
				'minuteText'=> 'Минуты',
				'secondText'=> 'Секунды', 				
				),
			)); 
			}else{
				Controller::FConvertDate($model->Begin);
			}
			
		?>
		<?php echo $form->error($model,'Begin'); ?>
	</td>
	
	<td>
	
	
		<?php echo $form->labelEx($model,'StatusId'); ?> 
		<?php 	
			//===== СМЕНА СТАТУСА ТОЛЬКО ВПЕРЁД ======
			
			if ($UserRole<=2){
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'StatusId',
						'data' => CHtml::listData(EventStatus::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); 
			}elseif ($UserRole<6 && $UserRole>3){	
				$AllovedEventStatuses=CHtml::listData(
					EventStatus::model()->findAll(array('order'=>'Order1 ASC', 'condition'=>'Order1 >= :Order1', 'params'=>array(':Order1'=>$CurrentStatusOrder) ))
				
				, 'id','name');
				
				$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'StatusId',
				'data' => $AllovedEventStatuses,
				'options'=> array('allowClear'=>true, 
					'width' => '200', 
					'placeholder' => '',
					//'minimumInputLength' => 3
					),
				));
				//Запрос в резерв
				if ($model->StatusId==14){
					echo CHtml::link(Yii::t('general','Confirm'), array('update', 'StatusId' => 16, 'id' => $model->id), array('class' => 'btn-win'));	
					
					echo CHtml::link(Yii::t('general','Confirm with changes'), array('update', 'StatusId' => 17, 'id' => $model->id), array('class' => 'btn-win'));	
				
				}
				//Запрос на доставку
				if ($model->StatusId==15){
					
					echo CHtml::link(Yii::t('general','Confirm delivery'), array('update', 'StatusId' => 10, 'id' => $model->id), array('class' => 'btn-win'));					


					echo CHtml::link(Yii::t('general','Confirm delivery with changes'), array('update', 'StatusId' => 18, 'id' => $model->id), array('class' => 'btn-win'));	
				}
				
					
			}else{
				echo EventStatus::model()->FindByPk($model->StatusId)->name;
				//Для нового заказа или заказа в работе дадим возможность клиенту делать запрос в резерв и на доставку
				if ($model->StatusId==2 || $model->StatusId==3){
					//echo CHtml::submitButton(Yii::t('general','Request to the reserve'), array('update', 'StatusId' => 14), array('class' => 'btn-win', 'name'=>'Status-14' ));	
					
					echo CHtml::link(Yii::t('general','Request to the reserve'),  array('update', 'StatusId' => 14, 'id' => $model->id), array('class' => 'btn-win'));	
					
					echo CHtml::link(Yii::t('general','Request to the delivery'), array('update', 'StatusId' => 15, 'id' => $model->id), array('class' => 'btn-win'));	
				
				}
				
			
			}
			//===== СМЕНА СТАТУСА ТОЛЬКО ВПЕРЁД ======
			
		?>
		<?php echo $form->error($model,'StatusId'); ?>
		
		
		<?php //echo $form->labelEx($model,'EventTypeId'); ?> 
		<?php 	/*$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'EventTypeId',
						'data' => CHtml::listData(Eventtype::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); */
		?>
		<?php //echo $form->error($model,'EventTypeId'); ?>
	
	
	</td>
	
	
	


</tr><tr> 

	<td>
		<?php echo $form->labelEx($model,'contractorId'); ?> 
		<?php 	
			if ($UserRole<=2){
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'contractorId',
						'data' => CHtml::listData(Contractor::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); 
			}else{
				echo Contractor::model()->findByPk($model->contractorId)->name;
			}
			
			
		?>
		<?php echo $form->error($model,'contractorId'); ?>
	</td>
	
	<td>
		
	</td>
	
	
</tr><tr> 
	
	<td>
		
		<?php 
			if ($UserRole<=5){
				echo $form->labelEx($model,'Priority'); 
				echo $form->textField($model,'Priority'); 
				echo $form->error($model,'Priority'); 
				
				
				
				
			}	
		?>
		
		
	</td>
	
 
	<td>
		<?php 
			if ($UserRole<=5){
				echo $form->labelEx($model,'Notes');
				echo $form->textArea($model,'Notes',array('rows'=>6, 'cols'=>40)); 
				echo $form->error($model,'Notes');
			}else {
				echo $form->labelEx($model,'Notes');
				echo $model->Notes; 
			}
		?>
	</td>
 
	
	<td>
		<?php echo $form->labelEx($model,'totalSum'); ?> 
		<?php 
			
			$model->totalSum = EventContent::getTotalSumByEvent($model->id);
			//echo $form->textField($model,'totalSum'); 
			echo $model->totalSum;
		
		
		?>
		<?php echo $form->error($model,'totalSum'); ?>
	</td>
</tr><tr> 


 

 

	
	<td>	<?php 
	
	
	echo 'test';
		$ArrayD=CHtml::listData(LoadDataSettings::model()->findAll(), 'id', 'TemplateName');
        $this->widget('ext.select2.ESelect2',array(
                'name' => 'LoadDataSettingsID',
                'options'=> array('allowClear'=>true,
                        'width' => '200'),
                'data'=>$ArrayD,
           ));
		
		echo CHtml::link(Yii::t('general','Edit loading settings'), array('LoadDataSettings/admin')); 
				
		$this->widget('CMultiFileUpload', array( 		
			'name'=>'FileUpload1',
		  ));
		  
		echo CHtml::submitButton(Yii::t('general', 'Load assortment from file'));
		 
	
	echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 
	
	?>
	</td> 
</tr>
<?php $this->endWidget(); ?>
<tr>
<!--- Ввод на основании --->  	
<td colspan='2'>
<?  $CurrentType=Eventtype::model()->FindByPk($model->EventTypeId);
	foreach ( explode(',', $CurrentType->IsBasisFor)  as $r) 
		$events[$r] = yii::t('general', Eventtype::model()->findbypk($r)->name);
	
	if (!empty($events))  
	{
		?>
     <h3><?php echo Yii::t('general', 'Create new event on the basis of this event'); ?></h3> 
		<?php echo CHtml::Form(Yii::app()->createUrl('events/clone'));
		echo CHtml::hiddenField('id', $model->id); //передаём id этого (существующего) события
		echo CHtml::label(Yii::t('general','Event Type'), '');
		$this->widget('ext.select2.ESelect2', array( 
				'name'=> 'newEventTypeId',
				'data' => $events,
				'options'=> array('allowClear'=>true, 
					'width' => '200', 
					'placeholder' => '',
					),
				));	 
		echo '&#9;&nbsp;&#9;&nbsp;&#9;&nbsp;&#9;&nbsp;', CHtml::submitButton(  Yii::t('general','Create new event') , array('class'=>'red')); 
		echo CHtml::endForm();	    
	}
?>
</td>
<!--- конец Ввод на основании ---> 

</tr></table> 

	<div style='padding: 10px 0px 0px'><?php 
	
		echo CHtml::link(Yii::t('general','Print invoice'),  array('Events/PrintSF', "id"=> $model->id), array('class' => 'btn-win'));
		
		echo CHtml::link(Yii::t('general','Print order'),  array('Events/PrintOrder', "id"=> $model->id), array('class' => 'btn-win'));
	
	?>
	</div> 

</div><!-- form -->