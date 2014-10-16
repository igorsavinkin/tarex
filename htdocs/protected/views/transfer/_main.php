<?php

	$UserRole=Yii::app()->user->role;
	$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;
	 
// для событий типа проформа () мы  вычисляем возможные статусы для показа
$statuses = array(Events::STATUS_NEW, Events::STATUS_IN_WORK, Events::STATUS_CANCELLED, Events::STATUS_COMPLETED); 
foreach (EventStatus::model()->findAllByPk($statuses, array('order'=>'Order1 ASC' )) as $r) $AllowedForAdminEventStatuses[$r->id] = Yii::t('general',$r->name);	   

$ContractorType = $this->contractorType(); // получаем тип контрагента для разных типов событий ( isCustomer или isSeller)
?>     

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',	
	'enableAjaxValidation'=>false,
)); ?>	 

	<?php echo $form->errorSummary($model); ?>

	<!---Номер события --->
	<td>
		<?php echo $form->labelEx($model,'eventNumber');?> 
		<?php if ($UserRole<=2) 
			echo $form->textField($model,'id',array('size'=>10,'maxlength'=>20)); 		
		else 
			echo $model->id;
		?>		
		<?php echo $form->error($model,'eventNumber'); ?>
	</td>
	<!---Номер события --->

	<!---Дата --->
	<td><label>
		<?php echo Yii::t('general','Date'), '</label>';?> 
		<?php  
			if ($UserRole <= 2)
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
					'attribute'=>'Begin',
					'language'=> $lang,  
					'options'=>$options, 
					));  
				echo $form->error($model,'Begin');
			} else {
				echo Controller::FConvertDate($model->Begin);			
			}
		?> 
	</td>
	<!---Дата---> 
	
	<!--- Сумма --->	
	<td>
		<?php echo $form->labelEx($model,'totalSum'); ?> 
		<?php echo $model->totalSum; ?>
	</td>
    <!--- Сумма --->	
 
</tr><tr valign='top'> 

	<!--- СТАТУС --->
	<td >
	
	<?php echo $form->labelEx($model,'StatusId'); ?> 
		<?php 	
			//===== СМЕНА СТАТУСА ТОЛЬКО ВПЕРЁД ======
			if ($UserRole<=2)
			{					
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'StatusId',
						'data' => $AllowedForAdminEventStatuses,
						'options'=> array('allowClear'=>true, 
							'width' => '150', 
				 			'placeholder' => ''),
				)); 
			} 
			elseif ($UserRole<6 && $UserRole>3 && $CurrentStatusOrder<4)
			{	
				$criteria = new CDbCriteria;
				$criteria->condition = 'Order1 >= :Order1';
				$criteria->addInCondition('id', $statuses);
				$criteria->params = array(':Order1'=>$CurrentStatusOrder) + $criteria->params;//+ is an array union operator
				$EventStatus = EventStatus::model()->findAll($criteria);
				//$EventStatus=EventStatus::model()->findAll(array('order'=>'Order1 ASC', 'condition'=>'Order1 >= :Order1', 'params'=>array(':Order1'=>$CurrentStatusOrder) ));
				//echo 'CurrentStatusOrder '.$CurrentStatusOrder;				
				foreach ($EventStatus as $r)					
					$AllowedForManagerEventStatuses[$r->id] = yii::t('general',$r->name);
	
				if (!empty($AllowedForManagerEventStatuses))
				{
					$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,
					'attribute'=> 'StatusId',
					'data' => $AllowedForManagerEventStatuses,
					'options'=> array('allowClear'=>true, 
						'width' => '150', 
						'placeholder' => '',						
						),
					));
				}	
				echo $form->error($model,'StatusId');
			} else { 
				// для клиентов оптовых и розничных
				echo Yii::t('general', EventStatus::model()->FindByPk($model->StatusId)->name); 
			} 
			//===== СМЕНА СТАТУСА ТОЛЬКО ВПЕРЁД ======			
		?> 
	</td>
	<!--- СТАТУС --->
	
	<!--- КОНТРАГЕНТ --->
	<td  >
		<?php echo $form->labelEx($model,'contractorId'); ?> 
		<?php 			
			if ($UserRole < 2) 
			{
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'contractorId',
						'data' => CHtml::listData(User::model()->findAll( array(
							'order'=>'name ASC', 
							'condition'=>"{$ContractorType} = 1")), 'id','username'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '', 
							),
					)); 
				 echo '<br>', CHtml::Link(Yii::t('general','Update Contractors') , array('user/admin'), array('target'=>'_blank')); 	
			}
			//Менеджерам разрешаем выбрать контрагента если новый
			elseif ($CurrentStatusOrder<4 && $UserRole<=5)
			{				
				$AllowedContractors=CHtml::listData(User::model()->findAll(array(
					'order'=>'name ASC',
					'condition'=>"organization=:organization AND {$ContractorType} = 1",
					'params'=>array(':organization'=>	Yii::app()->user->organization),
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
				echo '<br>', CHtml::Link(Yii::t('general','Update Contractors') , array('user/admin'), array('target'=>'_blank')); 	
			} 
			else {
				echo User::model()->findByPk($model->contractorId)->username;
			}
			
		?>
		<?php echo $form->error($model,'contractorId'); ?>
	</td>
	<!--- КОНТРАГЕНТ --->

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
 
 <!--- Склады --->
	<td>
	<label><?php echo Yii::t('general','Warehouse'), ' 1'; ?></label> 
	<?php 
		if ($UserRole <= 2)  
		{	
			$condition = ($UserRole == User::ROLE_ADMIN) ?  '1=1' : 'organizationId = ' . Yii::app()->user->organization; 
			$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'Subconto1',
				'data' => CHtml::listData(Warehouse::model()->findAll($condition), 'id','name'),
				'options'=> array('allowClear'=>true, 
								   'width' => '200', 
									'placeholder' => ''),
			));		 
		}
		elseif ($CurrentStatusOrder<4 && $UserRole<=5)
		{	 
			$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'Subconto1',
				'data' => CHtml::listData(Warehouse::model()->findAll('organizationId = ' . Yii::app()->user->organization), 'id','name'),
				'options'=> array('allowClear'=>true, 
								   'width' => '200', 
									'placeholder' => ''),
			));		  
		} else 
			echo Warehouse::model()->findByPk($model->Subconto1)->name;
			
		?>
		<br><br>  
	<label><?php echo Yii::t('general','Warehouse'), ' 2'; ?></label> 
	<?php 
		if ($UserRole <= 2 OR ($CurrentStatusOrder<4 && $UserRole<=5))  
		{	
			$condition = ($UserRole == User::ROLE_ADMIN) ?  '1=1' : 'organizationId = ' . Yii::app()->user->organization; 
			$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'Subconto2',
				'data' => CHtml::listData(Warehouse::model()->findAll($condition), 'id','name'),
				'options'=> array('allowClear'=>true, 
								   'width' => '200', 
									'placeholder' => ''),
			));				 
			echo '<br>', CHtml::Link(Yii::t('general','Edit Warehouses') , array('warehouse/admin'), array('target'=>'_blank')); 
		} else 
			echo Warehouse::model()->findByPk($model->Subconto2)->name;			
		?>
	</td>
 
 
 <!--- Склады --->
   
</tr>
<?php $this->endWidget(); ?>
<tr>
	<!--- Ввод на основании --->	
<td colspan='2'>
<? $CurrentType=Eventtype::model()->FindByPk($model->EventTypeId);
	 foreach ( explode(',', $CurrentType->IsBasisFor)  as $r) 
		$events[$r] = yii::t('general', Eventtype::model()->findbypk($r)->name);
	
	 if (!empty($events)) 
	 {
		?>
     <h3><?php echo Yii::t('general', 'Create new event on the basis of this event'); ?></h3> 
		<?php echo CHtml::Form(Yii::app()->createUrl('events/clone'));
		echo CHtml::hiddenField('id', $model->id); //передаём id этого (существующего) события
		echo CHtml::hiddenField( 'Reference' , $model->Reference );
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


</div><!-- form -->