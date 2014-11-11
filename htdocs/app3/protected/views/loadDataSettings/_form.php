<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */
/* @var $form CActiveForm */
?>
<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'load-data-settings-form', 
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p>

	<?php echo $form->errorSummary($model); ?>
 
	<td>
		<?php echo $form->labelEx($model,'TemplateName'); ?> 
		<?php echo $form->textField($model,'TemplateName',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'TemplateName'); ?>
	</td>
 
	<td class='padding10side' >
		<?php echo $form->labelEx($model,'ColumnNumber'); ?> 
		<?php //echo $form->textField($model,'ColumnNumber'); 
			$alphas = range('A', 'Z'); $letters=array();
			foreach($alphas as $value) 
				$letters[$value] = $value;
			$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'ColumnNumber',
						'data' => $letters,
						'options'=> array(
							'allowClear'=>true, 
							'width' => '100', 
							'placeholder' => '', 
							),
					));	  
			echo $form->error($model,'ColumnNumber'); ?>
	</td>


	<td>
		<?php echo $form->labelEx($model,'ListNumber'); ?> 
		<?php // echo $form->textField($model,'ListNumber'); 
			$data = array(); for($i=1; $i <=20; $i++ ) { $data[$i] = $i; }		
			$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,
					'attribute'=> 'ListNumber',
					'data' => $data,
					'options'=> array(
						'allowClear'=>true, 
						'width' => '100', 
						'placeholder' => '', 
						),
				));	 
		    echo $form->error($model,'ListNumber'); ?>
	</td>	
<!--/tr><tr--> 	
	<td class='padding10side'>
		<?php echo $form->labelEx($model,'TitleColumnNumber');  
    		$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,
					'attribute'=> 'TitleColumnNumber',
					'data' => $letters,
					'options'=> array(
						'allowClear'=>true, 
						'width' => '100', 
						'placeholder' => '', 
						),
				));	  
		  echo $form->error($model,'TitleColumnNumber'); ?>
	</td>
	
	<td class='padding10side'>
		<?php echo $form->labelEx($model,'AmountColumnNumber'); ?> 
		<?php //echo $form->textField($model,'AmountColumnNumber'); 
    		$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,
					'attribute'=> 'AmountColumnNumber',
					'data' => $letters,
					'options'=> array(
						'allowClear'=>true, 
						'width' => '100', 
						'placeholder' => '', 
						),
				));	  
		  echo $form->error($model,'AmountColumnNumber'); ?>
	</td>
	<td>
		<?php echo $form->labelEx($model,'PriceColumnNumber'); ?> 
		<?php // echo $form->textField($model,'PriceColumnNumber'); 
			$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,
					'attribute'=> 'PriceColumnNumber',
					'data' => $letters,
					'options'=> array(
						'allowClear'=>true, 
						'width' => '100', 
						'placeholder' => '', 
						),
				));	  ?>
		<?php echo $form->error($model,'PriceColumnNumber'); ?>
	</td>
</tr><tr> 	
	<td>	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>
</div><!-- form -->