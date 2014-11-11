<div class="form">
<p class="note"><?php echo Yii::t('general','Fields with'); ?><span class="required"> * </span><?php echo Yii::t('general','are required') .'.'; ?></p> 
<?php 
$Organizations = Organization::model()->findAll(array(
	'select'=>'t.name, t.id',
	'group'=>'t.name', 
	'distinct'=>true ));

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'load-data-setting-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		),	
));   ?> 	
<table><tr> 
	<td valign='top' width='250'>
		<?php echo $form->labelEx($model,'name'); 
				  echo $form->textField($model,'name'); 
				  echo $form->error($model,'name'); ?>
	</td>
	<td  width='250'><?php echo $form->label($model,'organizationId'); 
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,   
			'attribute'=> 'organizationId',
			'data' => CHtml::listData($Organizations, 'id','name'),
			'options'=> array('allowClear'=>true, 
			   'width' => '250', 
			   'placeholder' => '', 
				),
		));
		echo $form->error($model,'organizationId');
		echo CHtml::Link(Yii::t('general','Edit Organizations') , array('organization/admin'), array('target'=>'_blank')); ?>	
	</td>
	
	<td align='center' width='250'>	<?php 	
	echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red'));
	echo '&nbsp;&nbsp;&nbsp;&nbsp;', CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create & close') : Yii::t('general','Save & close'), array('name'=> 'save&close', 'class'=>'red')); 	?>
	</td>  	
	</tr><tr>
	<td><label><?php echo Yii::t('general','Load assortment template'),'</label>';
	    $this->widget('ext.select2.ESelect2',array(
			'model' => $loadDataSetting,
			'attribute' => 'id', 
			'options'=> array('allowClear'=>true,
					'width' => '200'),  
			'data'=>CHtml::listData(LoadDataSettings::model()->findAll(), 'id', 'TemplateName'),
		)); 
		echo '&nbsp;<br/>' ,CHtml::link(Yii::t('general','Edit loading settings'), array('LoadDataSettings/admin'), array('target'=>'_blank')); ?>
	
	</td>
	<td><label><?php echo Yii::t('general', 'First row is a column title'), '</label>';
		echo CHtml::checkBox('firstRow', $_POST['firstRow'], array('uncheckValue'=>0)  );		
// виджет загрузки файла
		$this->widget('CMultiFileUpload', array( 		
			'name'=>'FileUpload1',
		)); ?>
	</td>	 
	<td><?php 	
	echo CHtml::submitButton(Yii::t('general','Load assortment from file'), array('name'=>'load-btn', 'class'=>'red')); 	?>
	</td> 
</tr></table> 
<?php $this->endWidget(); ?>
</div><!-- form -->

