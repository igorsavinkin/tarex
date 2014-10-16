<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */
?>
<!--br/><br/-->
<div class="wide form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
</tr><tr>
<td width='15px'>
		<label style='text-align: left;'><?php echo Yii::t('general','#'); ?></label>
		<?php echo $form->textField($model,'id', array('size'=>4));  ?>
</td>   
<td>
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name');  ?>
</td>  
<td>
		<?php echo $form->label($model,'subType'); ?>
		<?php echo $form->textField($model,'subType');  ?>
</td> 
<td>
		<?php echo $form->label($model,'Reference'); ?>
		<?php echo $form->textField($model,'Reference');  ?>
</td> 	
<td>
		<span style='white-space: nowrap;'><?php echo $form->label($model,'IsBasisFor'); ?></span>
		<?php $this->widget('ext.select2.ESelect2', array(
						'model' => $model,
						'attribute' => 'IsBasisFor',     
						'data' => Eventtype::getEventtypesLocale(),    
						'options'=> array('allowClear'=>true, 
							'width' => '250', 
				 			'placeholder' => ''), 
					)); ?>
</td> 	 
<td align=center>
	<?php echo CHtml::submitButton(Yii::t('general','Search'), array('style'=> 'border-color: red;')); ?>
</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->