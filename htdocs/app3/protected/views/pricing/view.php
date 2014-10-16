<?php
/* @var $this PricingController */
/* @var $model Pricing */

$this->breadcrumbs=array(
	Yii::t('general','Pricings')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('general','List Pricing'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Pricing'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update Pricing'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete Pricing'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage Pricing'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View Pricing') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pricing-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'Date',
		'Comment',
		'SubgroupFilter',
		'TitleFilter',
		'ModelFilter',
		'MakeFilter',
		'ArticleFilter',
		'OemFilter',
		/*
		'ManufacturerFilter',
		'CountryFilter',
		'FreeAssortmentFilter',
		'UsernameFilter',
		'GroupFilter',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'Date',
		'Comment',
		'SubgroupFilter',
		'TitleFilter',
		'ModelFilter',
		'MakeFilter',
		'ArticleFilter',
		'OemFilter',
		'ManufacturerFilter',
		'CountryFilter',
		'FreeAssortmentFilter',
		'UsernameFilter',
		'GroupFilter',
	),
)); ?>
