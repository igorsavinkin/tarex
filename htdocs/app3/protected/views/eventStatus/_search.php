<?php
/* @var $this EventStatusController */
/* @var $model EventStatus */
/* @var $form CActiveForm */
?> 
<div class="wide form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
</tr><tr>
<td >
		<label ><?php echo Yii::t('general','#'); ?></label>
		<?php echo $form->textField($model,'id', array('size'=>4));  ?>
</td>   
<td>
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name');  ?>
</td>  
<td>
		<?php echo $form->label($model,'Order1'); ?>
		<?php 
				$data = array(); for($i=1; $i <= 10; $i++ ) { $data[$i] = $i; }		
				$this->widget('ext.select2.ESelect2', array(
						'model'=> $model,
						'attribute'=> 'Order1',
						'data' => $data,
						'options'=> array(
							'allowClear'=>true, 
							'width' => '70', 
							'placeholder' => ''),
					)); ?>
</td> 	
<td align='center' class='padding10side' >
	<?php echo CHtml::submitButton(Yii::t('general','Search'), array('class'=> 'red')); ?>
</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->