<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */
/* @var $form CActiveForm */

// скрипт для того чтобы сделать неактивными поля если задан RSS канал
Yii::app()->clientScript->registerScript('disable-script', " 
var selectors = '#News_link, #News_newsDate, #News_title, #News_content';
if ( '' != $('#News_RSSchannel').val()) {
  $(selectors).attr('disabled', 'disabled');
  $('.news-picture').addClass('hidden');
}
  
$('#News_RSSchannel').on('blur', function() { 
  if ($(this).val() != '') {
	  $(selectors).attr('disabled', 'disabled');
	  $('.news-picture').addClass('hidden');
  }
  else {
	  $(selectors).removeAttr('disabled');
	  $('.news-picture').removeClass('hidden');
  }
});
" , CClientScript::POS_END);
?>
<div class='form'>
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'special-offer-form', 
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
));  
?><label class='required'>Чтобы сделать новость неактивной - просто удалите всё её содержимое.</label>
	<p class='note'><?php echo Yii::t('general','Fields with'); ?><span class='required'> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>
 	
	<td>
		<?php echo $form->labelEx($model,'title'); ?> 
		<?php echo $form->textField($model,'title', array('size'=>'58')); ?>
		<?php echo $form->error($model,'title'); ?>
	</td> 
   
	 
	<td class='padding10side'>
		<?php echo $form->labelEx($model,'newsDate'); ?> 		 
		<?php  $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
			'model'=>$model,
			'attribute'=>'newsDate',
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
			)); ?>
		<?php echo $form->error($model,'newsDate'); ?>		
	</td>
	<td>	
		<?php echo $form->labelEx($model,'isActive'); ?> 
		<?php echo $form->checkBox($model,'isActive' ); ?>
		<?php echo $form->error($model,'isActive'); ?>
	</td> 
    
 </tr><tr> 
	<td >
		<?php echo $form->labelEx($model,'content'); ?> 
		<?php echo $form->textArea($model,'content', array('rows'=>4, 'cols'=>60)); ?>
		<?php echo $form->error($model,'content'); ?>
	</td> 
	<td class='padding10side' colspan='2'>
		<?php echo $form->labelEx($model,'link'); ?> 
		<?php echo $form->textField($model,'link'  , array('size'=>'35'/*,  'disabled'=>'true'*/ )/**/ ); ?>
		<p class='note'><span class='required'><?php echo 'Поставьте ссылку с <b>http://</b> или <b>https://</b> в начале;<br> например '; ?> <b> http://www.tarex.com </b></span></p>
		<?php echo $form->error($model,'link'); ?>
	</td> 
	
 </tr><tr> 
	<td class='news-picture'>
		<?php echo $form->labelEx($model,'imageUrl'); ?> 
		<?php echo $form->fileField($model,'imageUrl'); ?>
		<?php echo $form->error($model,'imageUrl'); ?>
	</td>  
	
	<td colspan='2' class='padding10side'>

		<?php echo $form->labelEx($model,'RSSchannel'); ?> 
		<?php echo $form->textField($model,'RSSchannel', array('size'=>'43')); ?>
		<?php echo $form->error($model,'RSSchannel'); ?>	
		<p class='note'><span class='required'>Когда задан <b>RSS канал</b>, то остальное содержимое неактивно.  Чтобы самостоятельно задать содержимое новости удалите весь текст (включая пробелы) из этого поля.</span></p>
		<div style='text-align:center;'>
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
		</div>
	</td> 
</tr></table> 
<div class='row news-picture'>
     <?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->imageUrl,'imageUrl', array('width'=>250));   // Image shown here if page is update page 
	 ?>
</div>
<?php $this->endWidget(); ?>

</div><!-- form --> 