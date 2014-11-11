<?php
/* @var $this SubgroupController */
/* @var $model Subgroup */

$this->breadcrumbs=array(
	Yii::t('general','Subgroups')=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('general','List Subgroup'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Subgroup'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update Subgroup'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete Subgroup'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage Subgroup'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View Subgroup') . ' <em><u>'. $model->name . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'subgroup-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'name',
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
	),
)); ?>
