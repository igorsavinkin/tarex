<?php

	$UserRole=Yii::app()->user->role;
	$OrganizationId=Yii::app()->user->organization;
	//$UserRole=6;
	$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;
	
	
	//echo 'StatusId '.$model->StatusId;
	
	$CurrentStatus=EventStatus::model()->FindByPk($model->StatusId);
	$CurrentType=Eventtype::model()->FindByPk($model->EventTypeId);
	
	
 $Year=substr($model->Begin,0,4);
  $Mn=substr($model->Begin,5,2);
  $Day=substr($model->Begin,8,2);
  
  $Reference=$CurrentType->Reference;
  
  
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	
	'enableAjaxValidation'=>false,
)); 


?>	
	<br><br><br>

	<?php echo $form->errorSummary($model); ?>

	<!---Номер события --->
	<td>
		<?php echo $form->labelEx($model,'eventNumber');   

		?> 
		<?php if ($UserRole<=2) echo $form->textField($model,'id',array('size'=>10,'maxlength'=>20)); 		else echo $model->id;
		?>
		
		<?php echo $form->error($model,'eventNumber'); ?>
	</td>
	<!---Номер события --->

	<!---Дата --->
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
				echo $Day.'-'.$Mn.'-'.$Year;
			
			}
			
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
							//'minimumInputLength' => 3
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
							//'minimumInputLength' => 3
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
	
</tr><tr> 
	
	<!--- Приоритет --->
	<td>
		<?php 
			echo $form->labelEx($model,'Priority'); 
			if ($UserRole<=2){
				echo $form->textField($model,'Priority'); 
			}
			elseif ($UserRole<=5 && $CurrentStatusOrder<4){
				echo $form->textField($model,'Priority'); 
				
			}else{
				echo $model->Priority; 
			
			}
			echo $form->error($model,'Priority'); 
		?>
	</td>
	<!--- Приоритет --->

<!--- Заметки --->	
	<td>
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
	</td>
 <!--- Заметки --->
	
	</tr><tr> 
 <!--- Сумма --->	
	<td>
		<?php echo $form->labelEx($model,'totalSum'); ?> 
		<?php 
			
			$model->totalSum = EventContent::getTotalSumByEvent($model->id);
			//echo $form->textField($model,'totalSum'); 
			echo $model->totalSum;
		
		
		?>
		<?php echo $form->error($model,'totalSum').'<br>'; 		
		
		

		?>
	</td>
 <!--- Сумма --->	

 <!--- Ввод на основании --->	
	<td>

	<?
		$EnterOnTheBasisString=$CurrentType->IsBasisFor;
		$AllEventTypes=Eventtype::model()->findall(array('order'=>'name ASC'));
		foreach ($AllEventTypes as $r){
			//echo 'EnterOnTheBasisString '.$EnterOnTheBasisString.'/id '.$r->id.'<br>';
		
			if (   strstr($EnterOnTheBasisString, $r->id.',')    ){
				$EnterOnTheBasisArray[$r->id]=yii::t('general',$r->name);
			}
		}
		
		if (!empty($EnterOnTheBasisArray)){
			echo $form->labelEx($model,'Enter on the basis');
			$this->widget('ext.select2.ESelect2', array(
					//'model'=> $model,
					'name'=> 'EnterOnTheBasis',
					'data' => $EnterOnTheBasisArray,
					'options'=> array('allowClear'=>true, 
						'width' => '300', 
						'placeholder' => '',
						),
					));	
		}
	?>
	</td>
 <!--- Ввод на основании --->
 
<!--- КНОПКА СОХРАНИТЬ --->	
	<td>
	
	<? 
		
		$model->Reference=$Reference;
		echo $form->hiddenField($model, 'Reference');
	?>
	
	
	<?//
		
		
		//echo $form->textField($Reference, 'Reference'); 	
		
		echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 
	?>
	</td>
 <!--- КНОПКА СОХРАНИТЬ --->	
 
 
</tr><tr>
	

	
<td>	
	<?php 
		//echo CHtml::link(Yii::t('general','Print invoice'),  array('Events/PrintSF', "id"=> $model->id), array('class' => 'btn-win'));
		
		//echo CHtml::link(Yii::t('general','Print order'),  array('Events/PrintOrder', "id"=> $model->id), array('class' => 'btn-win'));
	?>
</td> 

</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->