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
<td align=center>
	<?php echo CHtml::submitButton(Yii::t('general','Search'), array('class'=> 'red')); ?>
</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->