<?php
/* @var $this SubgroupController */
/* @var $model Subgroup */

$this->breadcrumbs=array(
	'Subgroups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Subgroup', 'url'=>array('index')),
	array('label'=>'Create Subgroup', 'url'=>array('create')),
	array('label'=>'Update Subgroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Subgroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Subgroup', 'url'=>array('admin')),
);
?>

<h1>View Subgroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
