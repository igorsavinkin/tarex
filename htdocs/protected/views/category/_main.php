<div class="form">
<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
));?> 
	<?php echo $form->errorSummary($model); ?> 
	<td valign='top' width='200'>
		<?php echo $form->labelEx($model,'id'); 
				  echo  $model->id; ?>
	</td>
	<td valign='top' width='200'>
		<?php echo $form->labelEx($model,'name'); 
				  echo $form->textField($model,'name'); 
				  echo $form->error($model,'name'); ?>
	</td>
	<td valign='top' width='200' class='padding10side'>
		<?php echo $form->labelEx($model,'image'); 
				  echo $form->fileField($model,'image'); 
				  echo $form->error($model,'image');  ?>
	</td>
	
	<td valign='top' width='140'  class='padding10side'>
		<?php echo $form->labelEx($model,'isActive'); 
				  echo $form->checkBox($model,'isActive'); 
				  echo $form->error($model,'isActive'); ?>
	</td>
	<td align='center' width='250'>	<?php 	
		echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 	?>
	</td>  
	
</tr></table> 
<div class="row">
     <?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/subgroups/'. $model->image,Yii::t('general',"image") ,array("width"=>250));   // Image shown here if page is update page 
	 ?>
</div>
<?php $this->endWidget(); ?>
 
</div><!-- form -->