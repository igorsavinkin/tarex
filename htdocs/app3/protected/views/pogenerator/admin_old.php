<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */

$this->breadcrumbs=array(
	Yii::t('general','Assortments')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Assortment'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Assortment'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#assortment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Assortments</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search_old',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assortment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'parent_id',
		'subgroup',
		'title',
		'model',
		'make',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
