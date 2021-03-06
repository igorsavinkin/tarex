<?php
/* @var $this SearchTermController */
/* @var $model SearchTerm */

$this->breadcrumbs=array(
	Yii::t('general','Search Terms')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List SearchTerm'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create SearchTerm'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#search-term-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Search Terms</h1>

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
	'id'=>'search-term-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'frequency',
		'firstOccurance',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
