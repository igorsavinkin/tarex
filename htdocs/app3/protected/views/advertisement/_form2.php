<?php
/* @var $this AdvertisementController */
/* @var $model Advertisement */
/* @var $form CActiveForm */ 
?>  
<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'advertisement-form', 
	'enableAjaxValidation'=>false,
)); ?> 
        <?php echo $form->labelEx($model,'content'); ?> 
		<?php echo $form->textArea($model,'content'); ?>
		<?php echo $form->error($model,'content');  
		
		$this->widget('ext.tinymce.SladekTinyMce'); 
   Yii::app()->clientScript->registerScript('tynimce-script', "
		tinymce.init({
			selector:'textarea#Advertisement_content', 
			theme: 'modern',
		   // width: 900,
			height: 500,
			plugins: [
				 'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
				 'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
				 'save table contextmenu directionality emoticons template paste textcolor'
		    ],
			content_css: 'css/content.css',
			toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons', 
			style_formats: [
				{title: 'Bold text', inline: 'b'},
				{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
				{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
				{title: 'Example 1', inline: 'span', classes: 'example1'},
				{title: 'Example 2', inline: 'span', classes: 'example2'},
				{title: 'Table styles'},
				{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
			]}); ",
		CClientScript::POS_END); ?>	  
	<td>
		<?php echo $form->labelEx($model,'isActive'); ?> 
		<?php echo $form->checkBox($model,'isActive'); ?>
		<?php echo $form->error($model,'isActive'); ?>
	</td> 

	<td class='padding10side'>	<?php echo CHtml::submitButton(Yii::t('general','Save'), array('class'=>'red')); ?>
	</td> 
</tr></table> 
<?php $this->endWidget(); ?>
</div><!-- form -->