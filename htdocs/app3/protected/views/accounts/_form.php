<?php
/* @var $this AccountsController */
/* @var $model Accounts */
/* @var $form CActiveForm */
?>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>

 
	<td>
		<?php echo $form->labelEx($model,'name'); ?> 
		<?php echo $form->textField($model,'name',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'CustomerName'); ?> 
		<?php echo $form->textField($model,'CustomerName',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'CustomerName'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'AccountNumber'); ?> 
		<?php echo $form->textField($model,'AccountNumber'); ?>
		<?php echo $form->error($model,'AccountNumber'); ?>
	</td>

</tr><tr> 
	<td>
		<?php echo $form->labelEx($model,'AccountCurrency'); ?> 
		<?php 
			//echo $form->textField($model,'AccountCurrency');
			    $AccountCurrency = CHtml::listData(Currency::model()->findAll(array('order'=>'name ASC')), 'id','name');

				$this->widget('ext.select2.ESelect2',array(
                'model'=> $model,
                'attribute'=> 'AccountCurrency',
                'options'=> array('allowClear'=>true,
                        'width' => '200',
                ),
                'data'=>$AccountCurrency,
                ));

		
		?>
		<?php echo $form->error($model,'AccountCurrency'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'AccountLimit'); ?> 
		<?php echo $form->textField($model,'AccountLimit'); ?>
		<?php echo $form->error($model,'AccountLimit'); ?>
	</td>

 
	<td>
		<?php echo $form->labelEx($model,'ParentCustomer'); ?> 
		<?php 
			//echo $form->textField($model,'ParentCustomer'); 
		
				$Users = CHtml::listData(User::model()->findAll(array('order'=>'name ASC',
					'condition'=>'isCustomer=1',
				)), 'id','username');

				$this->widget('ext.select2.ESelect2',array(
                'model'=> $model,
                'attribute'=> 'ParentCustomer',
                'options'=> array('allowClear'=>true,
                        'width' => '200',
                ),
                'data'=>$Users,
                ));
		
		?>
		<?php echo $form->error($model,'ParentCustomer'); ?>
	</td>

</tr><tr>	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save')); ?>
	</td>

</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->