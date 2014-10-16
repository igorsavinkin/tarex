<div class="form">
<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
));?> 
	<?php echo $form->errorSummary($model); ?> 
		<td valign='top' width='250' >
		<?php echo $form->labelEx($model,'name'); 
				  echo $form->textField($model,'name', array('size'=>'30')); 
				  echo $form->error($model,'name'); 
				/*  if (Yii::app()->language != 'en_us') 
					 echo '<p style="color:red;font-size:0.7em;"><em>' , Yii::t('general', 'The event type name is shown in your local language, while for model instance please enter it in English. Translation will be supplied later.'), '</em></p>';*/
				  ?>
		</td>	
		<td valign='top' width='250'>
		<?php echo $form->labelEx($model,'subType'); 
				  echo $form->textField($model,'subType'); 
				  echo $form->error($model,'subType'); ?>
		</td>
		<td valign='top' width='250'>
		<?php echo $form->labelEx($model,'Reference'); 
				  echo $form->textField($model,'Reference'); 
				  echo $form->error($model,'Reference'); ?>
		</td>
		
</tr><tr>

	<td valign='top' width='300'>
		<?php echo $form->labelEx($model,'IsBasisFor');  						
			$this->widget('ext.EchMultiSelect.EchMultiSelect', array(
				'model' => $model,
				'dropDownAttribute' => 'basesArray',     
				'data' => Eventtype::getEventtypesLocale(), 
				'dropDownHtmlOptions'=> array('style'=>'width:260px;'),
				)); 
		   echo $form->error($model,'IsBasisFor'); ?>
	</td>		 
	
	<td align='center' width='250'>	<?php 	
	echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 	?>
	</td>  
	
</tr></table> 
<?php $this->endWidget(); ?>
 
</div><!-- form -->