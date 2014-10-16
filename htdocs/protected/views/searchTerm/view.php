<?php
/* @var $this SearchTermController */
/* @var $model SearchTerm */

$this->breadcrumbs=array(
	Yii::t('general','Search Terms')=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('general','List SearchTerm'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create SearchTerm'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update SearchTerm'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete SearchTerm'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage SearchTerm'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View SearchTerm') . ' <em><u>'. $model->name . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'search-term-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'name',
		'frequency',
		'firstOccurance',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'frequency',
		'firstOccurance',
	),
)); ?>
