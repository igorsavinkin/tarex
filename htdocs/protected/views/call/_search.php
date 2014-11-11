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
</tr><tr valign='top'> 
    <td valign='top'> 
	<span style="white-space:nowrap;"><label><?php echo Yii::t('general','User in system, who calls'); ?></label></span><!--br-->  
<?php 
		$condition = ' isEmployee = 1 '; // берём всех кто работник организации	
	    if (!Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
			$condition .= ' AND organization = ' . Yii::app()->user->organization;
	    $this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'authorId',
			'data' => CHtml::listData(User::model()->findAll($condition), 'id','username'),
			'options'=> array('allowClear'=>true, 
							   'width' => '150', 
								'placeholder' => ''),
		));	
		echo '<br>', CHtml::Link(Yii::t('general','Edit Users') , array('user/admin'), array('target'=>'_blank'));  
		?>
	</td>  
	<td>
	<span style="white-space:nowrap;"><label><?php echo Yii::t('general','User in system, whom to call'); ?></label></span>
<br>	
	<?php   
		$condition = ' isEmployee = 0 '; // берём всех кто не работник организации	
	    if (!Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
			$condition .= ' AND organization = ' . Yii::app()->user->organization;
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'contractorId',
			'data' => CHtml::listData(User::model()->findAll($condition), 'id','username'),
			'options'=> array('allowClear'=>true, 
							   'width' => '150', 
								'placeholder' => ''),
		));	 
		?>  
	</td>
	
	<td  valign='middle'>
		<?php echo $form->label($model,'Notes'); ?>
		<?php echo $form->textField($model,'Notes',array('size'=>50,'maxlength'=>200)); ?>
	</td>
	
</tr><tr>	 

	<td> 
		<label><?php echo Yii::t('general','from Date'); ?></label>
		<?php 
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
		} else
			{ $lang = 'en-GB';  } 
		$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'Begin',
			'language'=> $lang,  
			'options'=>$options, 
			)); ?> 
	</td>

	<td> 
		<label><?php echo Yii::t('general','till Date'); ?></label>
		<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'End',
			'language'=> $lang, 
			'options'=>$options, 
			)); ?>
	</td>  
	
	<td align=center>
		<?php echo CHtml::submitButton(Yii::t('general','Search'), array('style'=> 'border-color: red; padding: 3px;')); ?>
	</td>
	
</tr><tr> 	
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
				echo CHtml::Link(Yii::t('general','Edit Organizations') , array('organization/admin'), array('target'=>'_blank')); 
			}  
		   ?>
	</td>  
	
	
	
	<?php if (Yii::app()->controller->id == 'events') 
		{
			echo '<td>', $form->label($model,'EventTypeId');   
			
			foreach(Eventtype::model()->findAll(array('order'=>'name ASC')) as $type)
				$listdata[$type->id] = Yii::t('general',$type->name);
				
			$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'EventTypeId',  
				'data' => $listdata,  
				'options'=> array('allowClear'=>true, 
					'width' => '200', 
					'placeholder' => ''),   
			)); 
			echo '<br>', CHtml::Link(Yii::t('general','Edit Event Types') , array('eventtype/admin'), array('target'=>'_blank'));  
		}  
		echo '</td>';
	?>
	
	
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->