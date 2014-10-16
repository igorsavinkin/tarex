<?php

	$UserRole=Yii::app()->user->role;
	$OrganizationId=Yii::app()->user->organization;

	$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;
	
	$CurrentStatus=EventStatus::model()->FindByPk($model->StatusId);
	$CurrentType=Eventtype::model()->FindByPk($model->EventTypeId);
   
    $Reference=$CurrentType->Reference;
  
  
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',	
	'enableAjaxValidation'=>false,
)); 
?>	
	<?php echo $form->errorSummary($model); ?>

	<!---Номер события --->
	<td>
		<?php echo $form->labelEx($model,'eventNumber'); ?> 
		<?php if ($UserRole<=2) 
						echo $form->textField($model,'id',array('size'=>10,'maxlength'=>20)); 		
				  else 
						echo $model->id; ?>		
		<?php echo $form->error($model,'eventNumber'); ?>
	</td>
	<!---Номер события --->

	<!---Дата --->
	<td><label>
		<?php echo Yii::t('general', 'Date'); ?> </label>
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
				'timeOnlyTitle' => 'Выберите часы',
				'timeText' => 'Время',
				'hourText'=>'Часы',
				'minuteText'=> 'Минуты',
				'secondText'=> 'Секунды', 				
				),
			)); 
			}else
				echo Controller::FConvertDate($model->Begin);
		?>
		<?php echo $form->error($model,'Begin'); ?>
	</td>
	<!---Дата--->


</tr><tr> 

	<!--- КОНТРАГЕНТ --->
	<td>
		<?php echo $form->labelEx($model,'contractorId'); ?> 
		<?php 	
		
			if ($UserRole<2){
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'contractorId',
						'data' => CHtml::listData(User::model()->findAll(array('order'=>'name ASC')), 'id','username'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							),
					)); 
			}
			//Менеджерам разрешаем выбрать контрагента если  новый
			elseif ( $CurrentStatusOrder<4 && $UserRole<=5){
				$AllowedContractors=CHtml::listData(User::model()->findAll(array(
				'order'=>'name ASC',
				'condition'=>'organization=:organization AND isCustomer=1',
				'params'=>array(':organization'=>$OrganizationId),
				)), 'id','username');
			
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'contractorId',
						'data' => $AllowedContractors,
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							),
				)); 			
			}
			else {
				echo User::model()->findByPk($model->contractorId)->username;
			}			
		?>
		<?php echo $form->error($model,'contractorId'); ?>
	</td>
	<!--- КОНТРАГЕНТ --->
	
	<!--- СТАТУС --->
	<td>
	
	<?php echo $form->labelEx($model,'StatusId'); ?> 
		<?php 	
			//===== СМЕНА СТАТУСА ТОЛЬКО ВПЕРЁД ======
			if ($UserRole<=2){
			
				$EventStatus=EventStatus::model()->findAll(array('order'=>'Order1 ASC' ));
				foreach ($EventStatus as $r){
					$name=yii::t('general',$r->name);
					
					$AllovedEventStatuses[$r->id]=$name;	
				
				}
				
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'StatusId',
						'data' => $AllovedEventStatuses,
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',

							),
				)); 
			}elseif ($UserRole<6 && $UserRole>3 && $CurrentStatusOrder<4){	
			
				$EventStatus=EventStatus::model()->findAll(array('order'=>'Order1 ASC', 'condition'=>'Order1 >= :Order1', 'params'=>array(':Order1'=>$CurrentStatusOrder) ));
				//echo 'CurrentStatusOrder '.$CurrentStatusOrder;
				
				foreach ($EventStatus as $r){
					//echo $r->name.'<br>';
					$name=yii::t('general',$r->name);
					
					$AllovedEventStatuses[$r->id]=$name;					
				}
				
				
				if (!empty($AllovedEventStatuses)){
					$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,
					'attribute'=> 'StatusId',
					'data' => $AllovedEventStatuses,
					'options'=> array('allowClear'=>true, 
						'width' => '300', 
						'placeholder' => '',						
						),
					));
				}
							
					
			}else{ 
				// для клиентов оптовых и розничных
				echo EventStatus::model()->FindByPk($model->StatusId)->name;
				//Для нового заказа или заказа в работе дадим возможность клиенту делать запрос в резерв и на доставку или для заказа "подтверждён с изменениями" или "Подтверждён на доставку с изменениями"

			}
			//===== СМЕНА СТАТУСА ТОЛЬКО ВПЕРЁД ======
			
		?>
		<?php echo $form->error($model,'StatusId'); ?>
	</td>
	<!--- СТАТУС --->
	
	<!--- Приоритет --->
	<td>
		<?php 
			echo $form->labelEx($model,'Priority'); 
			if (($UserRole<=2) OR ($UserRole<=5 && $CurrentStatusOrder<4)){
				$data = array(); for($i=1; $i <= 10; $i++ ) { $data[$i] = $i; }		
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'Priority',
						'data' => $data,
						'options'=> array(
							'allowClear'=>true, 
							'width' => '70', 
							'placeholder' => '', 
							),
					));	 
				echo $form->error($model,'Priority'); 
			} else 
				echo $model->Priority; 	 			
		?>
	</td>
	<!--- Приоритет --->
	
</tr><tr> 

<!--- Заметки --->	
	<td colspan='2'>
	<div>
		<?php		
		echo $form->labelEx($model,'Notes');
			if ($UserRole<=2){
				echo $form->textArea($model,'Notes',array('rows'=>6, 'cols'=>40)); 
			}
			elseif ($UserRole<=5 && $CurrentStatusOrder<4){
				
				echo $form->textArea($model,'Notes',array('rows'=>6, 'cols'=>40)); 
			
			}else {
				
				echo $model->Notes; 
			}
			echo $form->error($model,'Notes');
		?>
	 </div>
		
	<!--- КНОПКИ СОХРАНЕНИЯ И СКРЫТОЕ ПОЛЕ С Reference -->	
	<!--td-->	
	   <? echo $form->hiddenField($model, 'Reference');
	
		echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 
		echo '&#09;&nbsp;', CHtml::submitButton(  Yii::t('general','OK'), array('class'=>'red', 'name'=>'ok')); 
		?>
	<!--/td-->
   <!--- КНОПКИ СОХРАНЕНИЯ --->		
		
	</td>
 <!--- Заметки ---> 
  
</tr>
<?php $this->endWidget(); ?>

<tr valign='bottom'>

<!--- Ввод на основании --->	
<td colspan='2'>
<? 
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
		echo '&#9;&nbsp;&#9;&nbsp;&#9;&nbsp;&#9;&nbsp;&#9;&nbsp;&#9;&nbsp;', CHtml::submitButton(  Yii::t('general','Create new event') , array('class'=>'red')); 
		echo CHtml::endForm();	    
	}
?>
</td>
<!--- конец Ввод на основании ---> 
	
<td>	
	<?php 
		//echo CHtml::link(Yii::t('general','Print invoice'),  array('Events/PrintSF', "id"=> $model->id), array('class' => 'btn-win'));
		
		//echo CHtml::link(Yii::t('general','Print order'),  array('Events/PrintOrder', "id"=> $model->id), array('class' => 'btn-win'));
	?>
</td> 

</tr></table> 


</div><!-- form -->