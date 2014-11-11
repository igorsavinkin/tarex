<div class="wide form">
<table><tr> 
<td>
<label><?php echo Yii::t('general','Warehouse'); ?></label> 
<?php $form=$this->beginWidget('CActiveForm', array());   	
	if (!Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
		$condition = 'organizationId = ' . Yii::app()->user->organization;
	else
		$condition = '1=1'; 
	$this->widget('ext.select2.ESelect2', array(
		'model'=> $warehouse,
		'attribute'=> 'id', 
		'data' => CHtml::listData(Warehouse::model()->findAll($condition), 'id','name'),
		'options'=> array('allowClear'=>true, 
							'width' => '200', 'placeholder' => ''),							
		'htmlOptions'=>array(
			'onChange'=>'js:function(e) { 
						console.dir(e);  
						alert(e);
				}',
		), 	   	 			
	));	
   echo '&nbsp;', CHtml::Link(Yii::t('general','Edit Warehouses') , array('warehouse/admin'), array('target'=>'_blank')), '&nbsp;';
 ?>
 </td><td>
<?php 
   echo $form->label($event,'EventTypeId'); //, '<br>'; 
   foreach(Eventtype::model()->findAll(array('order'=>'name ASC')) as $type)
				$listdata[$type->id] = Yii::t('general', $type->name);  
   $this->widget('ext.EchMultiSelect.EchMultiSelect', array(
		'model' => $event, 
		'dropDownAttribute' => 'EventTypeId',     
		'data' => $listdata,
		'dropDownHtmlOptions'=> array(
			'style'=>'width:250px;',
		),
	));	
   echo '&nbsp;', CHtml::Link(Yii::t('general','Edit Event Types') , array('eventtype/admin'), array('target'=>'_blank')), '&nbsp;';	
   ?>
  </td>
  <td> 
	<span style="white-space:nowrap;"><?php echo $form->label($event,'authorId'); ?></span>
	<?php 
		if (!Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
			$condition = 'organization = ' . Yii::app()->user->organization;
		else
			$condition = '1=1';
	    $this->widget('ext.select2.ESelect2', array(
			'model'=> $event,
			'attribute'=> 'authorId',
			'data' => CHtml::listData(User::model()->findAll($condition), 'id','username'),
			'options'=> array('allowClear'=>true, 
							   'width' => '200', 
								'placeholder' => ''),
		));	
		echo '<br>', CHtml::Link(Yii::t('general','Edit Users') , array('user/admin'), array('target'=>'_blank')); 
		?>
	</td>
		<td>
	<?php echo $form->label($event,'contractorId');  
	   $condition = '(isCustomer = 1 OR isSeller  =1)';
	   if (!Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
			$condition .= ' AND organization = ' . Yii::app()->user->organization;
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $event,
			'attribute'=> 'contractorId',
			'data' => CHtml::listData(User::model()->findAll($condition), 'id','username'),
			'options'=> array('allowClear'=>true, 
							   'width' => '200', 
								'placeholder' => ''),
		));	 
		?>
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
			'model'=>$event,
			'attribute'=>'Begin',
			'language'=> $lang,  
			'options'=>$options, 
			)); ?> 
	</td>

	<td> 
		<label><?php echo Yii::t('general','till Date'); ?></label>
		<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$event,
			'attribute'=>'End',
			'language'=> $lang, 
			'options'=>$options, 
			)); ?>
	</td>  
  <td> 
<?php  echo '&nbsp;', CHtml::submitButton(Yii::t('general','Form all reports'), array('class'=> 'red', 'name'=>'all'));  
  ?></td> 
  
  </tr><tr>
  <td> 
<?php  echo '&nbsp;', CHtml::submitButton(Yii::t('general','Form report grouped by warehouse'), array('class'=> 'red', 'name'=>'bywarehouse'));  
  ?></td> 
  <td> 
<?php  echo '&nbsp;', CHtml::submitButton(Yii::t('general','Form report by each assortment'), array('class'=> 'red',  'name'=>'byassortment'));  
  ?></td> <td> 
<?php  echo '&nbsp;', CHtml::submitButton(Yii::t('general','Form report for particular assortment'), array('class'=> 'red',  'name'=>'particular_assortment'));  
  ?></td> 
  </tr></table>
<?php $this->endWidget(); ?>
</div><!-- from -->  