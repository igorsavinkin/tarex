<?php
/* @var $this EventContentController */
/* @var $model EventContent */

$this->breadcrumbs=array(
	Yii::t('general','Event Contents')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List EventContent'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create EventContent'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#event-content-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Event Contents</h1>

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
	'id'=>'event-content-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'eventId',
		'assortmentId',
		'assortmentAmount',
		'discount',
		'price',
		/*
		'cost',
		'cost_w_discount',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
