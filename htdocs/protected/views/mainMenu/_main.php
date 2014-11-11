<div class="form">
<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
));?> 
	<?php echo $form->errorSummary($model); ?> 
	  
	<td>
		<?php echo $form->label($model,'Subsystem'); ?>
		<?php  $criteria = new CDbCriteria;
					$criteria->distinct = true;
					$criteria->order = 'Subsystem ASC';
					$criteria->select = array('Subsystem');
					$refs = MainMenu::model()->findAll($criteria);
					$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'Subsystem',
						'data' => CHtml::listData($refs, 'Subsystem','Subsystem'),
						'options'=> array('allowClear'=>true, 
										   'width' => '200', 
											'placeholder' => ''),
				));
				 echo $form->error($model,'Subsystem'); ?>
	</td>

	<td  class='padding10side'>
		<?php echo $form->label($model,'Img'); ?>
		<?php echo $form->textField($model,'Img',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Img'); ?>
	</td>

	

	<td>
		<?php echo $form->label($model,'Link'); ?><!--label style='margin-left:-20px'>(Link)</label-->
		<?php echo $form->textField($model,'Link',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Link'); ?>
	</td>
	
</tr><tr>	

	<td>
		<?php echo $form->label($model,'Reference'); ?><!--label style='margin-left:-20px'>(Reference)</label-->
		<?php echo $form->textField($model,'Reference',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Reference'); ?>
	</td>

	<td class='padding10side'>
		<?php echo $form->label($model,'ReferenceImg'); ?>
		<?php echo $form->textField($model,'ReferenceImg',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'ReferenceImg'); ?>
	</td>


	<td>
		<?php echo $form->label($model,'RoleId'); ?>
		<?php echo $form->textField($model,'RoleId'); ?>
		<?php echo $form->error($model,'RoleId'); ?>
	</td>
</tr><tr>	
	<td>
		<?php echo $form->label($model,'DisplayOrder'); ?>
		<?php echo $form->textField($model,'DisplayOrder', array('size'=>'12')); ?>
		<?php echo $form->error($model,'RoleId'); ?>
	</td>
	
	<td align='center' width='250'>	<?php 	
	echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 	?>
	</td>  
	
</tr></table> 
<?php $this->endWidget(); ?>
 
</div><!-- form -->