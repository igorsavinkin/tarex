<?php
	$UserRole=Yii::app()->user->role;
	$UserId=Yii::app()->user->id;
	$UserName=Yii::app()->user->username;
	//echo $UserRole;
	
?>

<div class="wide form">
<table><tr>	

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
)); 

?>
<td>
<?php
	echo '<strong>'.Yii::t('general','Begin').' &nbsp;</strong>'; 
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
</td><td>
<?php	
	echo '<strong>'.Yii::t('general','End').'&nbsp; </strong>'; 
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
</td>
</tr><tr>
<td>
<?
	echo '<strong>'.Yii::t('general','Contractor').' &nbsp;</strong>'; 
	if($RoleId<=3){
		$condition = ($UserRole == User::ROLE_ADMIN) ?  '1=1' : 'organization = ' . Yii::app()->user->organization; 
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'contractorId',
			'data' => CHtml::listData(User::model()->findAll(array('order'=>'name ASC', 'condition'=>$condition)), 'id','username'),
			'options'=> array('allowClear'=>true, 
				'width' => '200', 
				'placeholder' => '',
				//'minimumInputLength' => 3
				),
		)); 
	}elseif ($RoleId>3 && $RoleId<6){
	
		$AllowedContractors=CHtml::listData(User::model()->findAll(array(
			'order'=>'name ASC',
			'condition'=>'organization=:organization AND isSeller=1',
			'params'=>array(':organization'=>Yii::app()->user->organization),
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
		echo $UserName;	
	}


?>
</td>

<td>
<? echo '<label>'.Yii::t('general','Warehouse') .' 1</label>'; 
	 if($RoleId<=3)
	 {
		$condition = ($UserRole == User::ROLE_ADMIN) ?  '1=1' : 'organizationId = ' . Yii::app()->user->organization; 
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'Subconto1',
			'data' => CHtml::listData(Warehouse::model()->findAll(array('order'=>'name ASC', 'condition'=>$condition)), 'id','name'),
			'options'=> array('allowClear'=>true, 
				'width' => '200', 
				'placeholder' => '', 
				),
		)); 
	} elseif ($RoleId>3 && $RoleId<6)
	{ 	
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'Subconto1',
			'data' => CHtml::listData(Warehouse::model()->findAll(array('order'=>'name ASC', 'condition'=>'organization= ' . Yii::app()->user->organization,)), 'id','name'),
			'options'=> array('allowClear'=>true, 
				'width' => '200', 
				'placeholder' => '', 
				),
		)); 
	} 
?>
</td><td >
<?
	echo '&#09;&nbsp;' , CHtml::submitButton(Yii::t('general', 'Generate report'), array('class'=>'red'));
?>	
</td> 
</tr></table> 
<?php $this->endWidget(); ?>
</div><!-- class="wide form" -->
<br>
<?
	if(isset($_POST['Events']))
	{	
		echo '<table width=100% border=1><tr> 
		<th>'.Yii::t('general','Date').'</th>
		<th>'.Yii::t('general','Document').'</th>
		<th>'.Yii::t('general','Opening Balance').'</th>
		<th>'.Yii::t('general','Arrival').'</th>
		<th>'.Yii::t('general','Consumption').'</th>
		<th>'.Yii::t('general','Closing Balance').'</th></tr>';
		echo '<tr><td></td><td></td><td>'. $OpeningBalances.'</td><td></td><td></td><td></td></tr>';
		$Arrival=0;	
		$Consumption=0;	
		//echo 'OpeningBalances = ' ,  $OpeningBalances;
		foreach ($modelRes as $r){
			echo '<tr><td>', $this->FConvertDate($r->Begin), '</td>';
			$EventType=Eventtype::model()->findbypk($r->EventTypeId);
			
			echo '<td>', CHtml::link(Yii::t('general',$EventType->name) . ' № '. $r->id . ' ' . Yii::t('general','from') . ' ' . $this->FConvertDate($r->Begin) , array('events/update',   'id'=>$r->id)) . '</td>';
			
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
		echo '<tr><td colspan=2 align=right><b>'.Yii::t('general','TOTAL').'</b></td><td></td><td><b>'. $Arrival . '</b></td><td><b>' . $Consumption . '</b></td><td><b>' . $OpeningBalances . '</b></td></tr></table>';
	}
	
?>		
	




