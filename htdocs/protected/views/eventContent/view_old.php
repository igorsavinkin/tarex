<?php
/* @var $this EventContentController */
/* @var $model EventContent */

$this->breadcrumbs=array(
	'Event Contents'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EventContent', 'url'=>array('index')),
	array('label'=>'Create EventContent', 'url'=>array('create')),
	array('label'=>'Update EventContent', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EventContent', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EventContent', 'url'=>array('admin')),
);
?>

<h1>View EventContent #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'eventId',
		'assortmentId',
		'assortmentAmount',
		'discount',
		'price',
		'cost',
		'cost_w_discount',
	),
)); ?>
