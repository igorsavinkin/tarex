<?php
/* @var $this PricingController */
/* @var $model Pricing */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr >
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pricing-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>
	<p class="note"><?php echo Yii::t('general','You might set several values for a single field - comma or semicolon separated. For example: <b>Toyota, Ford, Sang-Yong</b>.'); //, ' ',  Yii::t('general','For example: <b> Toyota, Ford, Sang-Yong</b>') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?> 
 
	<td>
		<?php echo $form->labelEx($model,'Date'); ?> 
		<?php //echo $form->textField($model,'Date'); 
			$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'Date',
			'language'=>'ru',
			 'options'=>array(
				'dateFormat'=>'yy-mm-dd',
				'timeFormat'=>strtolower(Yii::app()->locale->timeFormat),
				'changeMonth'=>'true',
				 //'showSecond'=>true,
				'changeYear'=>'true',
				'changeHour'=>'true', 
				'timeOnlyTitle' => 'Выберите часы',
				'timeText' => 'Время',
				'hourText'=>'Часы',
				'minuteText'=> 'Минуты',
				'secondText'=> 'Секунды', 				
				),
			)); 
		?>
		<?php echo $form->error($model,'Date'); ?>
	</td>

 
	<td colspan=2>
		<?php echo $form->labelEx($model,'Comment'); ?> 
		<?php echo $form->textField($model,'Comment', array('size'=>70,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Comment'); ?>
	</td>

 


</tr><tr> 
	<td>
		<?php 
		 echo '<b>', Yii::t('general','Filters based on assortment'), '</b>'; 
		
		echo $form->labelEx($model,'SubgroupFilter'); ?> 
		<?php echo $form->textField($model,'SubgroupFilter',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'SubgroupFilter'); ?>
	</td>
	
	<td valign='bottom'>
		<?php echo $form->labelEx($model,'TitleFilter'); ?> 
		<?php echo $form->textField($model,'TitleFilter',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'TitleFilter'); ?>
	</td>

 
	<td valign='bottom'>
		<?php echo $form->labelEx($model,'ModelFilter'); ?> 
		<?php echo $form->textField($model,'ModelFilter',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'ModelFilter'); ?>
	</td>

 


</tr><tr> 

	<td>
		<?php echo $form->labelEx($model,'MakeFilter'); ?> 
		<?php echo $form->textField($model,'MakeFilter',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'MakeFilter'); ?>
	</td>
	
	
	<td>
		<?php echo $form->labelEx($model,'ArticleFilter'); ?> 
		<?php echo $form->textField($model,'ArticleFilter',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'ArticleFilter'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'OemFilter'); ?> 
		<?php echo $form->textField($model,'OemFilter',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'OemFilter'); ?>
	</td>

 
	

</tr><tr> 

	<td>
		<?php echo $form->labelEx($model,'ManufacturerFilter'); ?> 
		<?php echo $form->textField($model,'ManufacturerFilter',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'ManufacturerFilter'); ?>
	</td>
	
	<td>
		<?php echo $form->labelEx($model,'CountryFilter'); ?> 
		<?php echo $form->textField($model,'CountryFilter',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'CountryFilter'); ?>
	</td>
</tr><tr>  
	<td>		
		<?php echo '<b>', Yii::t('general','Filters based on user'), '</b>'; ?>		
		<?php echo $form->labelEx($model,'UsernameFilter'); ?> 
		<?php echo $form->textField($model,'UsernameFilter',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'UsernameFilter'); ?>
	</td>

	<td valign='bottom'>
		<?php echo $form->labelEx($model,'GroupFilter'); ?> 
		<?php  $org = User::model()->findByPk(Yii::app()->user->id)->organization;
					$criteria = new CDbCriteria; 
					$criteria->order = 'name ASC';			
					$criteria->condition = 'organizationId = ' . $org ;
					$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'GroupFilter',
						'data' => CHtml::listData(UserGroup::model()->findAll($criteria/*array('order'=>'name ASC', 'condition'=>'organizationId'=>)*/), 'id','name'),
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
							'placeholder' => '',
							//'minimumInputLength' => 3
							),
					)); 
		
		//  echo $form->textField($model,'GroupFilter',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'GroupFilter'); ?>
	</td>
	<td valign='bottom'>
		<?php echo CHtml::Link(Yii::t('general', 'Edit') . ' ' . Yii::t('general', 'User Groups') , array('userGroup/admin', 'Subsystem'=>'Settings' , 'Reference'=>'User+Groups'), array('target'=>'_blank')) ; ?>
	</td>
</tr><tr> 	
	<td   valign='bottom'>
		<?php echo $form->labelEx($model,'Value'); ?> 
		<?php echo $form->textField($model,'Value'); ?>
		<?php echo $form->error($model,'Value'); ?>
	</td>	
	
	<td   valign='bottom'>
		<?php echo $form->labelEx($model,'isActive'); ?> 
		<?php echo $form->checkBox($model,'isActive'); ?>
		<?php echo $form->error($model,'isActive'); ?>
	</td>	
 
	<td valign='bottom'>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->