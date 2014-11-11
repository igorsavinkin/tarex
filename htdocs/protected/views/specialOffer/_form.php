<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'special-offer-form', 
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); 
//Yii::app()->user->setReturnUrl($this->route);
//echo 'return url = ',  Yii::app->user->returnUrl; 
?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td>
		<?php echo $form->labelEx($model, 'assortmentId'); ?> 
		<?php echo  'id: ', $model->assortmentId; ?> 
	</td> 
	
	<td>
		<?php echo $form->labelEx($model,'price'); ?> 
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</td> 
	<td style='text-align:center;'><?php echo CHtml::link(Yii::t('general', 'Load an assortment item'), array('assortment/admin', 'return'=> '+' . $model->id ), array('class'=>'btn-win')); 
		//Yii::app()->params['returnUrl'] = Yii::app()->request->url;
		//print_r(Yii::app()->getParams());		//  Yii::app()->request->url;
	?>
	</td>  
	
 </tr><tr> 
	<td colspan='3'>
		<?php echo $form->labelEx($model,'description'); ?> 
		<?php echo $form->textField($model,'description',array('size'=>70,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'description'); ?>
	</td> 
	<td> 
		<?php echo $form->labelEx($model,'make'); ?> 
		<?php echo $form->textField($model,'make' ); ?>
		<?php echo $form->error($model,'make'); ?>
	</td> 
    
 </tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'photo'); ?> 
		<?php echo $form->fileField($model,'photo',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'photo'); ?>
	</td>  
	<td style='text-align:center;'><?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td> 
</tr></table> 
<div class="row">
     <?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/foto/'.$model->photo,"photo",array("width"=>250));   // Image shown here if page is update page 
	 ?>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->