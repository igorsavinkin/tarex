<div class="form">
<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false, 
)); ?>  
	<?php echo $form->errorSummary($model); ?> 
	
<td valign='top' width='220'>
<?php echo $form->labelEx($model,'name'); 
		  echo $form->textField($model,'name', array('size'=>25)); 
		  echo $form->error($model,'name'); ?> 
</td>
<td  width='220'>
		<?php echo $form->label($model,'address'); ?>
		<?php echo $form->textArea($model,'address', array('rows'=>3, 'cols'=>30)); ?>
		<?php echo $form->error($model,'address');  ?>
</td>
<td  width='220' class='padding10side'>
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email', array('size'=>30));  ?>
		<?php echo $form->error($model,'email');  ?>
</td>

</tr><tr>  

<td>
		<?php echo $form->label($model,'INN'); ?>
		<?php echo $form->textField($model,'INN');  ?>
		<?php echo $form->error($model,'INN');  ?>
</td>  
<td>
		<?php echo $form->label($model,'phone'); ?>
		<?php echo $form->textField($model,'phone');  ?>
		<?php echo $form->error($model,'phone');  ?>
</td>  
<td class='padding10side'>
		<?php echo $form->label($model,'KPP'); ?>  
		<?php echo $form->textField($model,'KPP');  ?>
		<?php echo $form->error($model,'KPP');  ?>
</td>
</tr><tr>
<td >
		<?php echo $form->label($model,'BIC'); ?>  
		<?php echo $form->textField($model,'BIC');  ?>
		<?php echo $form->error($model,'BIC');  ?>
</td> 

<td >
		<?php echo $form->label($model,'OKVED'); ?>  
		<?php echo $form->textField($model,'OKVED');  ?>
		<?php echo $form->error($model,'OKVED');  ?>
</td>
<td class='padding10side'>
		<?php echo $form->label($model,'OKPO'); ?>  
		<?php echo $form->textField($model,'OKPO');  ?>
		<?php echo $form->error($model,'OKPO');  ?>
</td>
</tr><tr>
<td >
		<?php echo $form->label($model,'Bank'); ?>
		<?php echo $form->textArea($model,'Bank', array('rows'=>3, 'cols'=>30));  ?>
		<?php echo $form->error($model,'Bank');  ?>
</td>  

<td >  
			<?php echo $form->labelEx($model,'CorrespondentAccount'); ?>
			<?php echo $form->textField($model,'CorrespondentAccount'); ?>
			<?php echo $form->error($model,'CorrespondentAccount'); ?>
</td>
<td class='padding10side'>  	
			<?php echo $form->labelEx($model,'CurrentAccount'); ?>
			<?php echo $form->textField($model,'CurrentAccount'); ?>
			<?php echo $form->error($model,'CurrentAccount'); ?>
</td>
</tr><tr>

<td align='center' valign='middle' width='250'>	
<?php 	
echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
</td>    
</tr></table> 
<?php $this->endWidget(); ?>
</div><!-- form -->