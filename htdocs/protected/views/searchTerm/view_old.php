<?php
/* @var $this SearchTermController */
/* @var $model SearchTerm */

$this->breadcrumbs=array(
	'Search Terms'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SearchTerm', 'url'=>array('index')),
	array('label'=>'Create SearchTerm', 'url'=>array('create')),
	array('label'=>'Update SearchTerm', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SearchTerm', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SearchTerm', 'url'=>array('admin')),
);
?>

<h1>View SearchTerm #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'frequency',
		'firstOccurance',
	),
)); ?>
