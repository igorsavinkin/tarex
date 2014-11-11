<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */
 
?>
<h1><?php echo Yii::t('general','Load Data Settings'); ?></h1>
 <br>

<?php echo CHtml::link(Yii::t('general', 'Create Load Data Template'), array('LoadDataSettings/create'), array('class'=>'btn-win')); 

$action = 'update';   
$url = $this->createUrl($action);
echo CHtml::form();
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'load-data-settings-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){  
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id);	 
	}',
	'htmlOptions'=>array('class'=>'grid-view grid-size-400'), 
	'columns'=>array(
		//'id',
		'TemplateName',
		array(
			 'class'=>'CButtonColumn',
			 'template'=>'{delete}',
		),
	),
));  
echo CHtml::endForm();
?>
