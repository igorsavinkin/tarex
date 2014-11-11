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
 <td>
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name');  ?>
</td>
<td>
<?php //echo ' Поиск по организации:';
if (Yii::app()->user->role == User::ROLE_ADMIN) 
{
	$Organizations = Organization::model()->findAll(array(
		'select'=>'t.name, t.id',
		'group'=>'t.name',  
		'distinct'=>true ));
		
	echo $form->label($model,'organizationId'); 
	
	$this->widget('ext.select2.ESelect2', array(
		'model'=> $model,   
		'attribute'=> 'organizationId',
		'data' => CHtml::listData($Organizations, 'id','name'),
		'options'=> array('allowClear'=>true, 
		   'width' => '250', 
		   'placeholder' => '', 
			),  
	));      
}  /**/
?>
</td>   
	 
	<td align=center>
		<?php echo CHtml::submitButton(Yii::t('general','Search'), array('style'=> 'border-color: red;')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->