<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */

$this->breadcrumbs=array(
	'Load Data Settings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LoadDataSettings', 'url'=>array('index')),
	array('label'=>'Create LoadDataSettings', 'url'=>array('create')),
	array('label'=>'Update LoadDataSettings', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LoadDataSettings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LoadDataSettings', 'url'=>array('admin')),
);
?>

<h1>View LoadDataSettings #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'TemplateName',
		'СolumnSearch',
		'СolumnNumber',
		'ListNumber',
	),
)); ?>
