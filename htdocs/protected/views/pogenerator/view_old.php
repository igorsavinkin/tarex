<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */

$this->breadcrumbs=array(
	'Assortments'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Assortment', 'url'=>array('index')),
	array('label'=>'Create Assortment', 'url'=>array('create')),
	array('label'=>'Update Assortment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Assortment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Assortment', 'url'=>array('admin')),
);
?>

<h1>View Assortment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_id',
		'subgroup',
		'title',
		'model',
		'make',
		'measure_unit',
		'price',
		'discount',
		'warehouseId',
		'imageUrl',
		'fileUrl',
		'isService',
		'depth',
		'article',
		'priceS',
		'oem',
		'organizationId',
		'manufacturer',
		'agroup',
		'availability',
		'country',
		'MinPart',
		'YearBegin',
		'YearEnd',
		'Currency',
		'Analogi',
		'Barcode',
		'Misc',
		'PartN',
		'COF',
		'Category',
	),
)); ?>
