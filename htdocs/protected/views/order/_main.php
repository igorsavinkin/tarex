<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScript('some-code', "
// привязываем отправку формы когда элементы с классом 'notes' теряют фокус
$('.notes').bind('blur', function(e) {
	   setTimeout(function() { e.target.form.submit(); /*console.dir(e.target.value);*/  } , 40);   
}); 
", CClientScript::POS_END);  
      
	$UserRole=Yii::app()->user->role;
	$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;

?>

<div class="form">
<table width=880><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));  
?> 
	<?php echo $form->errorSummary($model); ?>
 
	<td width='250'>
		<?php echo $form->labelEx($model,'eventNumber');  ?> 
		<?php /* if ($UserRole<=2) echo $form->textField($model,'id',array('size'=>10,'maxlength'=>20,  'class'=>'notes')); 
			else */ echo $model->id; ?> 
		<?php //echo $form->error($model,'eventNumber'); ?>
	</td>
  
	<td width='230'>
		<?php echo '<label>' , Yii::t('general', 'Date') ,': </label>'; ?> 
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
				'htmlOptions'=>array( 
					'onChange'=>'js:this.form.submit()',
				),
			)); 
			}else{
				echo Controller::FConvertDate($model->Begin);
			}  
		?>
		<?php echo $form->error($model,'Begin'); ?>
	</td>

	<td  >
		<?php echo $form->labelEx($model,'totalSum'); ?> 
		<?php $model->totalSum = EventContent::getTotalSumByEvent($model->id); 
			echo '<b id="total-sum">', $model->totalSum, '</b>'; ?>
		<?php echo $form->error($model,'totalSum'); ?>
	</td> 
	
</tr><tr> 

	<td> <label><?php echo Yii::t('general', 'Contractor'); ?></label>
		<?php 
		// ===== КОНТРАГЕНТ =====
		//echo $form->labelEx($model,'contractorId'); ?> 
		<?php 	 
			if ($UserRole<2){
				$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,
					'attribute'=> 'contractorId',        
					'data' => CHtml::listData(User::model()->findAll(array('condition'=>'isCustomer=1 OR role >= 6', 'order'=>'name ASC')), 'id','username'),
					'options'=> array('allowClear'=>true, 
						'width' => '200', 
						'placeholder' => '', 
						),
					'htmlOptions'=>array(
						'onChange'=>'js:this.form.submit()',
						/*'onChange'=>CHtml::ajax(array('type'=>'POST',
						'url'=>$this->createUrl('update', array('id'=>$model->id)),
						//'url'=>$this->createUrl('user/returnShablonIdPaymentMethod'),
						'data'=>'js:$("#events-form").serialize()',	//'data'=>'js:{id:this.value}',					
						'success'=>'function(data){  							 
							 // перезагрузка страницы из сервера чтобы получить новые данные
							location.reload(true);							
						    //	data = JSON.parse(data)); console.dir(data);							
						}', 
						)) /*. 'js:alert(this.value);',*/
					), 
				)); 
				echo '<br>', CHtml::Link(Yii::t('general','Edit Customers') , array('user/admin', 'User[isCustomer]'=>'1'), array('target'=>'_blank')); 	
			}
			//Менеджерам разрешаем выбрать контрагента если заказ новый
			elseif ($CurrentStatusOrder<=1 && $UserRole<=5){
				$AllowedContractors=CHtml::listData(User::model()->findAll(array(
				'order'=>'name ASC',
				'condition'=>'organization=:organization AND (isCustomer=1 OR role >= 6)',
				'params'=>array(':organization'=> Yii::app()->user->organization),
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
						'htmlOptions'=>array( 
							'onChange'=>'js:this.form.submit()',
						),	
				));  
				echo '<br>', CHtml::Link(Yii::t('general','Manage Contractors') , array('user/admin'), array('target'=>'_blank')); 	
			}
			else { ?>
				<b>
				<?php echo User::model()->findByPk($model->contractorId)->username ? User::model()->findByPk($model->contractorId)->username : Yii::t('general', 'none'); ?></b>
		<?php		
			}
		 echo $form->error($model,'contractorId'); ?>
	</td>
	<td> <label><?php echo Yii::t('general', 'Manager'); ?></label>
	<?php echo ($model->contractorId) ? User::model()->findByPk($model->contractorId)->parent->username : '-'; ?>
	</td>
	<td>
		<?php
		if ($UserRole==7 || $UserRole<=5){
			echo $form->labelEx($model,'PaymentType');  				 
			$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,
					'attribute'=> 'PaymentType',
					'data' => CHtml::listData(PaymentMethod::model()->findall(), 'id','name'),
					'options'=> array('allowClear'=>true, 
						'width' => '200', 
						'placeholder' => '', 
						),
					'htmlOptions'=>array( 
						'onChange'=>'js:this.form.submit()',
					),					
			)); 				
			echo $form->error($model,'PaymentType');  
		}
		?>
	</td>
	
	<td>		
		<?php 
			if ($UserRole<=5 ){
				echo $form->labelEx($model,'Priority'); //echo $form->textField($model,'Priority');  
				$data = array(); for($i=1; $i <= 10; $i++ ) { $data[$i] = $i; }		
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'Priority',
						'data' => $data,
						'options'=> array(
							'allowClear'=>true, 
							'width' => '70', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
						'htmlOptions'=>array( 
							'onChange'=>'js:this.form.submit()',
						),	
					));	
				echo $form->error($model,'Priority'); 
			} 
		?> 
	</td> 
	
</tr><tr>
	
	<td colspan='3' valign=top>
	
	
		<?php echo $form->labelEx($model,'StatusId'); ?> 
		<?php 	
	//===== СМЕНА СТАТУСА (ТОЛЬКО ВПЕРЁД - пока не реализована) ======
		 		if ($UserRole<=2){
				foreach (EventStatus::model()->findAll() as $status)
					$AllowedEventStatuses[$status->id] = Yii::t('general',$status->name);
 				asort($AllowedEventStatuses); // cортировка по возрастанию
				
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'StatusId',
						'data' => $AllowedEventStatuses, //CHtml::listData(EventStatus::model()->findAll(array('order'=>'name ASC')), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '', 
							),
						'htmlOptions'=>array( 
							'onChange'=>'js:this.form.submit()',
						),	
					)); 
			} elseif ($UserRole<6 && $UserRole>3)
			{	 
				foreach (EventStatus::model()->findAll() as $status)
					$AllowedEventStatuses[$status->id] = Yii::t('general',$status->name);
 				asort($AllowedEventStatuses); // cортировка по возрастанию
				
				$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,
					'attribute'=> 'StatusId',
					'data' => $AllowedEventStatuses,
					'options'=> array('allowClear'=>true, 
						'width' => '230', 
						'placeholder' => '', 
						),
					'htmlOptions'=>array( 
						'onChange'=>'js:this.form.submit()',
					),	
				));
				echo '&#09;&#09;&#09;&nbsp;&nbsp;&nbsp;&nbsp;';
				//Запрос в резерв
				if ($model->StatusId == 14 ){
					echo CHtml::link(Yii::t('general','Confirm to reserve'), array('update', 'StatusId' => 16, 'id' => $model->id), array('class' => 'btn-win'));	
					
					echo CHtml::link(Yii::t('general','Confirm with changes'), array('update', 'StatusId' => 17, 'id' => $model->id), array('class' => 'btn-win'));	
				
				}
				//Запрос на доставку
				if ($model->StatusId==15){
					
					echo CHtml::link(Yii::t('general','Confirm to delivery'), array('update', 'StatusId' => 23, 'id' => $model->id), array('class' => 'btn-win'));

					echo CHtml::link(Yii::t('general','Confirm with changes'), array('update', 'StatusId' => 17, 'id' => $model->id), array('class' => 'btn-win'));				


					echo CHtml::link(Yii::t('general','Confirm to delivery with changes'), array('update', 'StatusId' => 18, 'id' => $model->id), array('class' => 'btn-win'));	
				}				
					
			}else{ 
			// для клиентов оптовых и розничных
				echo '<b>' , Yii::t('general', EventStatus::model()->FindByPk($model->StatusId)->name) , '</b>';
				echo '&#09;&#09;&#09;&nbsp;&nbsp;&nbsp;&nbsp;';
				//Для нового заказа или заказа в работе дадим возможность клиенту делать запрос в резерв и на доставку или для заказа "подтверждён с изменениями" или "Подтверждён на доставку с изменениями"

				if ($model->StatusId==2 || $model->StatusId==3 || $model->StatusId==17 || $model->StatusId==18){ 
					
					echo CHtml::link(Yii::t('general','Request to the reserve'),  array('update', 'StatusId' => 14, 'id' => $model->id), array('class' => 'btn-win'));	
					
					echo CHtml::link(Yii::t('general','Request to the delivery'), array('update', 'StatusId' => 15, 'id' => $model->id), array('class' => 'btn-win'));	 
				}
				if ( $model->StatusId==16){ 					
					echo CHtml::link(Yii::t('general','Request to the delivery'), array('update', 'StatusId' => 15, 'id' => $model->id), array('class' => 'btn-win'));	
				}  
				
			
			}
			//===== СМЕНА СТАТУСА ТОЛЬКО ВПЕРЁД ======
			
		?>
		<?php echo $form->error($model,'StatusId'); ?>  
 
	</td> 
</tr><tr>  
	<td colspan=3  valign=middle>
		<?php 
			if ($UserRole<=5){
				echo $form->labelEx($model,'Notes');
				echo $form->textArea($model,'Notes',array('rows'=>4, 'cols'=>60, 'class'=>'notes')); 
				echo $form->error($model,'Notes');
			} else {
				echo $form->labelEx($model,'Notes');
				echo '<b>', $model->Notes , '&nbsp;</b>'; 
			}
		?>
		<span class='paddingSpecial1'>		
			<?php  
			echo CHtml::button( Yii::t('general','Back to orders'), array( 'class'=>'red', 'onclick' => 'js:document.location.href="'. $this->createUrl('admin').'" '));
			 ?>
		</span>
		<span class='paddingSpecial1'>
			<?php echo CHtml::submitButton( Yii::t('general','Save'), array('class'=>'red', 'name'=>'save')); ?>
		</span>
		<span class='paddingSpecial1'>
			<?php echo CHtml::submitButton( Yii::t('general','Save & close'), array('class'=>'red', 'name'=>'OK')); ?>
		</span>
		
	</td> 
<?php $this->endWidget(); ?> 
</tr><tr>
	<td colspan='2'>
	<? 
		$CurrentType=Eventtype::model()->FindByPk($model->EventTypeId);
		if ($CurrentType->IsBasisFor) 
			foreach ( explode(',', $CurrentType->IsBasisFor)  as $r)
				if (Eventtype::model()->findbypk($r))
					$events[$r] = yii::t('general', Eventtype::model()->findbypk($r)->name);			
		
// если есть события и пользователь - менеджер		
		if (!empty($events) && Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
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
	
</tr></table>  
	
<div style='padding: 10px 0px 0px'>
<?php  
echo CHtml::link(Yii::t('general','Print invoice.'),  array('printSchet', "id"=> $model->id), array('class' => 'btn-win'));

echo CHtml::link(Yii::t('general','Print order'),  array('printOrder', "id"=> $model->id), array('class' => 'btn-win'));   
 
?>
</div> 



</div><!-- form -->