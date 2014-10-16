<?php
/* @var $this MainMenuController */
/* @var $model MainMenu */
/* @var $form CActiveForm */
?>

<div class="wide form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>  

	<td>
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</td>

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
				));?>
	</td>

	<td>
		<?php echo $form->label($model,'Img'); ?>
		<?php echo $form->textField($model,'Img',array('size'=>40,'maxlength'=>255)); ?>
	</td>

</tr><tr>	
	<td>
		<?php echo $form->label($model,'Link'); ?><label style='margin-left:-40px'>(Link)</label>
		<?php echo $form->textField($model,'Link',array('size'=>40,'maxlength'=>255)); ?>
	</td>
	
	<td>
		<?php echo $form->label($model,'Reference'); ?><label style='margin-left:-30px'>(Reference)</label>
		<?php 
			$criteria = new CDbCriteria;
			$criteria->distinct = true;
			$criteria->order = 'Reference ASC';
			$criteria->select = array('Reference');
			$refs = MainMenu::model()->findAll($criteria);
			$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'Reference',
				'data' => CHtml::listData($refs, 'Reference','Reference'),
				'options'=> array('allowClear'=>true, 
								   'width' => '200', 
									'placeholder' => ''),
				));	 	
		//echo $form->textField($model,'Reference',array('size'=>40,'maxlength'=>255)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'ReferenceImg'); ?>
		<?php echo $form->textField($model,'ReferenceImg',array('size'=>40,'maxlength'=>255)); ?>
	</td>

</tr><tr>	
	<td>
		<?php echo $form->label($model,'RoleId'); ?>
		<?php 
			$condition = (Yii::app()->user->role) ? 'id >= '. Yii::app()->user->role : '1=1';
			$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'RoleId',
				'data' => CHtml::listData(UserRole::model()->findAll($condition), 'id','name'),
				'options'=> array('allowClear'=>true, 
								   'width' => '150', 
									'placeholder' => ''),
				));	 		   ?>
	</td>

	<td>
		<?php echo $form->label($model,'DisplayOrder'); ?>
		<?php echo $form->textField($model,'DisplayOrder', array('size'=>'25')); ?>
	</td>

	<td style='text-align:center;'>
		<?php echo CHtml::submitButton(Yii::t('general','Search'), array('class'=>'red')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>
<p style='font: 10px gray; font-weight: bold;clear:both; padding: 0px 10px;'><?php echo Yii::t('general', 'You may optionally enter a comparison operator' ), ' (<, <=, >, >=, <>, =) ', Yii::t('general','at the beginning of each of your search values to specify how the comparison should be done') ; ?></p>
</div><!-- search-form -->