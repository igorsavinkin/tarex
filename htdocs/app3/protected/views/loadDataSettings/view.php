<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */

$this->breadcrumbs=array(
	Yii::t('general','Load Data Settings')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('general','List LoadDataSettings'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create LoadDataSettings'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update LoadDataSettings'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete LoadDataSettings'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage LoadDataSettings'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View LoadDataSettings') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'load-data-settings-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'TemplateName',
		'ColumnSearch',
		'ColumnNumber',
		'AmountColumnNumber',
		'ListNumber',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'TemplateName',
		'ColumnSearch',
		'ColumnNumber',
		'AmountColumnNumber',
		'ListNumber',
	),
)); ?>
