<?php
/* @var $this AdvertisementController */
/* @var $model Advertisement */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'advertisement-form', 
	'enableAjaxValidation'=>false,
)); ?> 

	<?php echo $form->errorSummary($model); ?>
	<td>
		<?php echo $form->labelEx($model,'isActive'); ?> 
		<?php echo $form->checkBox($model,'isActive'); ?>
		<?php echo $form->error($model,'isActive'); ?>
	</td>


	<td>	<?php echo CHtml::submitButton(Yii::t('general','Save'), array('class'=>'red')); ?>
	</td>
</tr><tr>	 
	<td colspan='5' height='600px'>
		<?php// echo $form->labelEx($model,'content'); ?> 
		<?php 	$this->widget('ext.XHeditor',array(
		'language'=>'en',
		'model'=>$model,
		'modelAttribute'=>'content',
	//	 'htmlOptions'=>array('id'=>'',  'cols'=>400,'rows'=>50,'style'=>'width: 100%; height: 500px;'),
	//	'showModelAttributeValue'=>false, // defaults to true, displays the value of $modelInstance->attribute in the textarea
	 	'config'=>array( 
			'tools'=>'full', // mini, simple, fill or from XHeditor::$_tools
			'width'=>'100%', 
			'height'=>'100%',
			//see XHeditor::$_configurableAttributes for more
		),
	 
	//	'contentValue'=>'Enter your text here', // default value displayed in textarea/wysiwyg editor field 
		'htmlOptions'=>array('rows'=>5, 'cols'=>140),// to be applied to textarea
	)); ?>	 
	</td>	
</tr></table> 
<?php $this->endWidget(); ?>
</div><!-- form -->