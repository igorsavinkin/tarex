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
 <!--td>
		<?php /* echo $form->label($model,'StatusId'); ?>
		<?php $this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'StatusId',
						'data' => CHtml::listData(EventStatus::model()->findAll(array('order'=>'name ASC')), 'id', 'name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 'placeholder' => '', ),
					)); */?>
	</td-->

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
			$options = array(
				'dateFormat'=>'dd-mm-yy', 
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
				'secondText'=> 'Секунды');
		else
			$options = array( 'changeMonth'=>'false');
		$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'Begin',
			'language'=> substr(Yii::app()->getLanguage(), 0, 2),      // Yii::app()->language, 
			 'options'=>$options, /*array(  'dateFormat'=>'yy-mm-dd', 'timeFormat'=>strtolower(Yii::app()->locale->timeFormat), 'changeMonth'=>'true',	'showSecond'=>true,	'changeYear'=>'true', 'changeHour'=>'true', 'timeOnlyTitle' => 'Выберите часы', 	'timeText' => 'Время', 'hourText'=>'Часы',	'minuteText'=> 'Минуты', 'secondText'=> 'Секунды'),*/
			)); ?> 
	</td>

	<td> 
		<label><?php echo Yii::t('general','till Date'); ?></label>
		<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'End',
			'language'=> Yii::app()->language,
			'options'=>$options, 
			)); ?>
	</td>  
	<td>
		<?php echo $form->label($model,'totalSum'); ?>
		<?php echo $form->textField($model,'totalSum'/*,array('size'=>50,'maxlength'=>200)*/); ?>
	<p style='font: 10px gray; font-weight: bold;'><?php echo Yii::t('general', 'You may optionally enter a comparison operator' ), ' (<, <=, >, >=, <>, =) ', Yii::t('general','at the beginning of each of your search values to specify how the comparison should be done') ; ?></p>
	</td>
</tr><tr>	  
	<td>
		<?php if (Yii::app()->controller->id == 'events') 
		{
			echo $form->label($model,'EventTypeId');   
			
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
		}  ?>
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
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->