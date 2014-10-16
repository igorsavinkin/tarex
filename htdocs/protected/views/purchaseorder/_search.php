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
	<td>  
	<span style="white-space:nowrap;"><?php echo $form->label($model,'authorId'); ?></span><!--br-->
<?php 
		if (!Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
			$condition = 'organization = ' . Yii::app()->user->organization;
		else
			$condition = '1=1';
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
	<?php echo $form->label($model,'contractorId');  
	    if (!Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
			$condition = 'organization = ' . Yii::app()->user->organization . ' AND isCustomer = 1';
		else
			$condition = '1=1';
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
	<td>
	    <div style='float:left;'>
			<?php echo $form->label($model,'totalSum'); ?>
			<?php echo $form->textField($model,'totalSum', array('size'=>10,'maxlength'=>200)); ?>
		</div>	
		<div>	
			<?php echo $form->label($model, 'eventNumber'); ?>
			<?php echo $form->textField($model, 'id' , array('size'=>10,'maxlength'=>200)); ?>
		</div>	
		<p style='font: 10px gray; font-weight: bold;clear:both; padding: 0px 10px;'><?php echo Yii::t('general', 'You may optionally enter a comparison operator' ), ' (<, <=, >, >=, <>, =) ', Yii::t('general','at the beginning of each of your search values to specify how the comparison should be done') ; ?></p>
	</td>
</tr><tr>
	<td>
	 <label><?php echo Yii::t('general','Warehouse'); ?></label> 
	<?php 
		if (!Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
			$condition = 'organizationId = ' . Yii::app()->user->organization;
		else
			$condition = '1=1';
	    $this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'Subconto1',
			'data' => CHtml::listData(Warehouse::model()->findAll($condition), 'id','name'),
			'options'=> array('allowClear'=>true, 
							    'width' => '150', 
								'placeholder' => ''),
		));	
		echo '<br>', CHtml::Link(Yii::t('general','Edit Warehouses') , array('warehouse/admin'), array('target'=>'_blank')); 
		?>
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
				echo CHtml::Link(Yii::t('general','Edit Organizations') , array('organization/admin'), array('target'=>'_blank')); 
			}  
		   ?>
	</td>  
	<td align=center>
		<?php echo CHtml::submitButton(Yii::t('general','Search'), array('style'=> 'border-color: red; padding: 3px;')); ?>
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