<?php
/* @var $this PriceListSettingController */
/* @var $model PriceListSetting */
/* @var $form CActiveForm  */ 
$msg = Yii::t('general', 'Wait several seconds till the server composes and sends you personalized price list'); 
Yii::app()->clientScript->registerScript('download-checked-makes', "
$('.column-button').click(function(){
	$('.column-form').toggle();
	return false;
}); 
$('.download-link').on('click', function(e){  
	setTimeout(function(){ alert('{$msg}')},500);
	var selected = $('input.carmake:checked').map(function(i,el){return el.value;}).get().join(',');  
	// console.log(selected);
 	location.href = $(this).attr('href') + '?carmakes=' + selected; 
	
	return false; // return false from within a jQuery event handler is effectively the same as calling both e.preventDefault and e.stopPropagation on the passed jQuery.Event object.
});", CClientScript::POS_END);
 ?> 
<div class='form'>
		
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'price-list-setting-form', 
	'enableAjaxValidation'=>false,
)); ?> 
 
	<td rowspan='3' class='top'>
		<h3><center>
<?php 
	echo 'Скачай прямо сейчас<br>';
	echo CHtml::Image('/images/download_arrow_blue.png'), '<br><br>';
	echo CHtml::Link(Yii::t('general','TarexPrice.xls') , array('user/pricelist') , array(  'class'=>'btn-win',  'style'=>'line-height:0.5em; padding:5px 5px;margin-top:20px;', 'onclick'=>"js:setTimeout(function(){ alert('{$msg}')},600);"));  
	echo '<br><br>', CHtml::Link(Yii::t('general','TarexPrice.csv') , array('user/pricelistCSV') , array( 'class'=>'btn-win',   'style'=>'line-height:1.0em; padding:5px 5px;', 'onclick'=>"js:setTimeout(function(){ alert('{$msg}')},600);")); 
?>
</center></h3>
	</td>
	<td colspan='5'><h3><center><?php echo 'Настройка рассылки<br>';?></center></h3>
	
	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>
	</td>
</tr><tr>
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
	<td colspan='5'><h4>
        <?php echo CHtml::link(Yii::t('general','Setup price columns'),'#', array('class'=>'column-button')); ?>
			</h4>
		<?php echo $form->hiddenField($model, 'columns'); ?> 
		<div class="column-form" style="display:none">
			<h3><center><?php echo 'Выбрать колонки для прайса';?></center></h3>	
			<?php $this->renderPartial('_columns',array(
				'model'=>$model,
			)); ?>
		</div><!-- search-form -->
	</td>
</tr><tr>	
	<td colspan='5'><h3><center><?php echo 'Скачать по марке автомобиля';?></center></h3></td>
</tr><tr> 
	<td colspan='5' class='padding10'> 
	   
	<?php 
			$criteria = new CDbCriteria;
			$criteria->compare('depth', 2);	
			$criteria->order = 'title ASC';			
			$manufacturers = Assortment::model()->findAll($criteria);
			foreach($manufacturers as $m) 
				$makes[$m->title] = $m->title;
			$model->carmakes = explode(',' , $model->carmakes ); // мы вытаскиваем из строковой переменной марки машин разделённые через запятую	
				
			echo $form->checkBoxList( $model, 'carmakes', 
					$makes, 
					array('template'=>'<div class="car-item">{input}{label}</div>', 'separator'=>'', 'class'=>'checkBoxClass carmake' /*, 'checkAll'=>'<h5 style="line-height:0.2em; margin-top:-0px;">' . Yii::t("general", "CHECK ALL") . '</h5>'*/) 
				); ?> 
	 </td>
</tr><tr>
	 <td colspan='5' class='padding10'>
		<div style="float:right;">
	   <label class='simple'><?php echo Yii::t('general', 'Use also for regular mailing');?></label>&nbsp;
	   <input type='checkbox' name='use-in-reg-mailing' checked='checked'>
	   </div>
	 </td>
</tr><tr>
	 <td colspan='5' class='padding10'>
	 <?php		
	     echo CHtml::Link(Yii::t('general','Скачать по маркам XLS') , array('user/pricelist') , array('class'=>'download-link btn-win', 'style'=>"float:right;")); ?>
	 </td>
</tr></table> 
<?php $this->endWidget(); ?> 
</div> <!-- form --> 