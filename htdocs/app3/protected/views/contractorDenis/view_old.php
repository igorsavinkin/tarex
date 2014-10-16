<?php
/* @var $this ContractorDenisController */
/* @var $model ContractorDenis */

$this->breadcrumbs=array(
	'Contractor Denises'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ContractorDenis', 'url'=>array('index')),
	array('label'=>'Create ContractorDenis', 'url'=>array('create')),
	array('label'=>'Update ContractorDenis', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ContractorDenis', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContractorDenis', 'url'=>array('admin')),
);
?>

<h1>View ContractorDenis #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'address',
		'phone',
		'email',
		'organizationId',
		'userId',
		'note',
		'inn',
		'kpp',
	),
)); ?>
