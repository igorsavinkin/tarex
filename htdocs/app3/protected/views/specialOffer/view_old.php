<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */

$this->breadcrumbs=array(
	'Special Offers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SpecialOffer', 'url'=>array('index')),
	array('label'=>'Create SpecialOffer', 'url'=>array('create')),
	array('label'=>'Update SpecialOffer', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SpecialOffer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SpecialOffer', 'url'=>array('admin')),
);
?>

<h1>View SpecialOffer #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'assortmentId',
		'price',
		'description',
		'photo',
	),
)); ?>
