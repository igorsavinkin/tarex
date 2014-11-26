<?php
/* @var $this PriceListSettingController */
/* @var $model PriceListSetting */
/* @var $form CActiveForm */ 
//print_r(Yii::app()->locale->weekDayNames);
 ?>
<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'price-list-setting-form', 
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>
 
	
	<td class='padding10 top'  width='420px'> 
		<?php  
		    $model->daysOfWeek = explode(',' , $model->daysOfWeek ); // мы вытаскиваем из строковой переменной дни недели разделённые через запятую 
			if ($model->daysOfWeek[0]=='') $model->daysOfWeek=array(); 
			
		    echo $form->labelEx($model,'daysOfWeek');  
			echo $form->checkBoxList( $model, 'daysOfWeek', 
					Yii::app()->locale->getWeekDayNames('abbreviated'), 
					array('template'=>'<div class="item">{input}{label}</div>', 'separator'=>'', 'class'=>'checkBoxClass') 
				);
		/*	$this->widget('ext.EchMultiSelect.EchMultiSelect', array(
				'model' => $model,
				'dropDownAttribute' => 'daysOfWeek',     
				'data' => Yii::app()->locale->weekDayNames,
				'dropDownHtmlOptions'=> array(
					'style'=>'width:140px;',
				),
			)); */ ?>
		<?php echo $form->error($model,'daysOfWeek'); ?>
	</td>

	<td class='padding10'> 
		<?php echo $form->labelEx($model,'format');
				echo $form->radioButtonList($model,'format', $this->formats,
				array('template'=>'<div class="item">{input}{label}</div>', 'separator'=>'', 'class'=>'checkBoxClass')		
			);
	/*			
		$this->widget('ext.select2.ESelect2', array(						 
						'model'=> $model,
						'attribute'=> 'format',
						'data' => $this->formats,
						'options'=> array('allowClear'=>true, 
							'width' => '150',  
							), 
					)); */ ?>
		<?php echo $form->error($model,'format'); ?>
	</td> 
	<td class='padding10'>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td> 
</tr><tr> 		
	<td class='padding10'>
		<?php echo $form->labelEx($model,'email'); ?> 
		<?php echo $form->textField($model,'email',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</td> 
	<td class='padding10side'>
		<?php echo $form->labelEx($model,'time'); ?> 
		<?php if (Yii::app()->language == 'ru')   
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
		} else { $lang = 'en-GB';
				    $options=array('timeFormat'=>strtolower(Yii::app()->locale->timeFormat)); } 
		
		 $this->widget( 'ext.EJuiTimePicker.EJuiTimePicker', array(
			  'model' => $model, // Your model
			  'attribute' => 'time', // Attribute for input
			  'timeHtmlOptions' => array(
				  'size' => 5,
				  'maxlength' => 5,
				),
			  'mode' => 'time',
			));  
		echo $form->error($model,'time'); ?> 
	</td >
	<td class='padding10side'>
		<?php if(Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
		{
			echo $form->labelEx($model,'userId');  	
			$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'userId',
				'data' => CHtml::listData(User::model()->findAll(array('order'=>'username ASC')), 'id','username'),
				'options'=> array('allowClear'=>true, 
					'width' => '220',  
					),
			));  
			echo $form->error($model,'userId');
		} ?>
	</td>
</tr><tr>	
	<td colspan='3' class='padding10'> <label> 
	<?php
	     echo  Yii::t('general', 'Car makes'),  '</label>'; 
			$criteria = new CDbCriteria;
			$criteria->compare('depth', 2);	
			$criteria->order = 'title ASC';			
			$manufacturers = Assortment::model()->findAll($criteria);
			foreach($manufacturers as $m) 
				$makes[$m->title] = $m->title;
			$model->carmakes = explode(',' , $model->carmakes ); // мы вытаскиваем из строковой переменной марки машин разделённые через запятую	
				
			echo $form->checkBoxList( $model, 'carmakes', 
					$makes, 
					array('template'=>'<div class="car-item">{input}{label}</div>', 'separator'=>'', 'class'=>'checkBoxClass', 'checkAll'=>'<h5 style="line-height:0.2em">' . Yii::t("general", "CHECK ALL") . '</h5>') 
				);	
	    //echo  ; ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->
<style>
#PriceListSetting_daysOfWeek input, #PriceListSetting_carmakes input {
    float: left;
    margin-right: 10px;
	padding: 5px;
} 
.checkBoxClass {
	float: left;
} 
#PriceListSetting_daysOfWeek label, #PriceListSetting_carmakes label
{
	float: left;
	font-weight: bold;
	font-size: 0.9em; 
	line-height: .4em;
}
div.item { float: left; padding: 7px; margin: 2px;}
div.car-item { float: left; padding: 5px;  width:150px; }
</style>
