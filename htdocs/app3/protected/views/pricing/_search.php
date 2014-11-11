<?php
/* @var $this PricingController */
/* @var $model Pricing */
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
		<?php echo $form->label($model,'Date'); ?>
		<?php echo $form->textField($model,'Date'); ?>
	</td>

	<td>
		<?php echo $form->label($model,'Comment'); ?>
		<?php echo $form->textField($model,'Comment',array('size'=>40,'maxlength'=>255)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'SubgroupFilter'); ?>
		<?php echo $form->textField($model,'SubgroupFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'TitleFilter'); ?>
		<?php echo $form->textField($model,'TitleFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'ModelFilter'); ?>
		<?php echo $form->textField($model,'ModelFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'MakeFilter'); ?>
		<?php echo $form->textField($model,'MakeFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'ArticleFilter'); ?>
		<?php echo $form->textField($model,'ArticleFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'OemFilter'); ?>
		<?php echo $form->textField($model,'OemFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'ManufacturerFilter'); ?>
		<?php echo $form->textField($model,'ManufacturerFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'CountryFilter'); ?>
		<?php echo $form->textField($model,'CountryFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'FreeAssortmentFilter'); ?>
		<?php echo $form->textField($model,'FreeAssortmentFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

</tr><tr>	<td>
		<?php echo $form->label($model,'UsernameFilter'); ?>
		<?php echo $form->textField($model,'UsernameFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo $form->label($model,'GroupFilter'); ?>
		<?php echo $form->textField($model,'GroupFilter',array('size'=>40,'maxlength'=>200)); ?>
	</td>

	<td>
		<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>
	</td>
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->