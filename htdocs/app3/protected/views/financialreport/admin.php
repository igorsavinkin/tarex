<?php
	$UserRole=Yii::app()->user->role;
	$UserId=Yii::app()->user->id;
	$UserName=Yii::app()->user->username; 
	//echo '<br><br><br><br>'; 
?>
<h1><?php echo Yii::t('general','Financial report'); ?></h1><br>
<div class='form'>
<table><tr>	 
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form', 
	'enableAjaxValidation'=>false,
));  ?>
<td>
<?php
	echo '<strong>'.Yii::t('general','Begin').' </strong>'; 
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
?>
</td><td class='padding10side'>
<?php	
	echo ' <strong>'.Yii::t('general','End').' </strong>'; 
	$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
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
	)); 

?>
</td><td class='padding10side'>
<?	
	if(Yii::app()->user->role<=3){
		echo '<label>'.Yii::t('general','Contractor').' </label>'; 
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'contractorId',
			'data' => CHtml::listData(User::model()->findAll(array('order'=>'name ASC')), 'id','username'),
			'options'=> array('allowClear'=>true, 
				'width' => '200', 
				'placeholder' => '', 
				),
		)); 
	} elseif (Yii::app()->user->role>3 && Yii::app()->user->role<6){
		echo '<strong>'.Yii::t('general','Contractor').' </strong>'; 
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
	}else{ 
		//echo $form->hiddenField( $model, 'contractorId');
		//echo $UserName;	
	}
?>
</td><td>
<?	echo CHtml::submitButton(Yii::t('general','Generate'), array('class'=>'red')); ?>
</td> 
</tr></table> 
<?php $this->endWidget(); ?>
</div> <!-- form --> 
<?
	if(isset($_POST['Events']))
	{	
		echo '<table width=100% border=1><tr> 
		<th>'.Yii::t('general','Date').'</th>
		<th>'.Yii::t('general','Document').'</th>
		<th>'.Yii::t('general','OpeningBalance').'</th>
		<th>'.Yii::t('general','Arrival').'</th>
		<th>'.Yii::t('general','Consumption').'</th>
		<th>'.Yii::t('general','ClosingBalance').'</th></tr>';
		echo '<tr><td></td><td></td><td>'.$OpeningBalances.'</td><td></td><td></td><td></td></tr>';
		$Arrival=0;	
		$Consumption=0;	
		//echo 'OpeningBalances '.$OpeningBalances;
		foreach ($modelRes as $r){
			echo '<tr><td>'.$this->FConvertDate($r->Begin).'</td>';
			$EventType=Eventtype::model()->findbypk($r->EventTypeId);
			
			echo '<td>'.CHtml::link(Yii::t('general',$EventType->name).' № '.$r->id.' '.Yii::t('general','From date').' '.$this->FConvertDate($r->Begin), array('Events/update',   'id'=>$r->id)   ).'</td>';
			
			echo '<td>'.$OpeningBalances.'</td>';
			if ($r->EventTypeId==24 || $r->EventTypeId==19 || $r->EventTypeId==20){
				echo '<td>'.$r->totalSum.'</td>';
				echo '<td>0</td>';
				$OpeningBalances += $r->totalSum;
				$Arrival += $r->totalSum;
			}else{
				echo '<td>0</td>';
				echo '<td>'.$r->totalSum.'</td>';
				$OpeningBalances -= $r->totalSum;
				$Consumption += $r->totalSum;
			}
			echo '<td>'.$OpeningBalances.'</td></tr>';
		}
		//echo '<tr><td></td><td></td><td></td><td>'.$Arrival.'</td><td>'.$Consumption.'</td><td>'.$OpeningBalances.'</td></tr></table>';
		
		echo '<tr><td colspan=2 align=right><b>'.Yii::t('general','TOTALLY').'</b></td><td></td><td><b>'.$Arrival.'</b></td><td><b>'.$Consumption.'</b></td><td><b>'.$OpeningBalances.'</b></td></tr></table>';
	}
?>