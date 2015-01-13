<?php
/* @var $this ScrapeDataController */
/* @var $model ScrapeData */

$this->breadcrumbs=array(
	Yii::t('general','Scrape Datas')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('general','List ScrapeData'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create ScrapeData'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update ScrapeData'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete ScrapeData'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage ScrapeData'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View ScrapeData') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'scrape-data-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'marker',
		'date',
		'make',
		'model',
		'seria',
		'engine',
		'year',
		'owner',
		/*
		'phone',
		'isChecked',
		'isPaid' =>array( 
			'name'=>'isPaid',
			'value'=>'Ispa::model()->findByPk($data->isPaid)->name',
			'filter' => CHtml::listData(Ispa::model()->findall(), 'id', 'name'),		
		),
		'link',
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
		'marker',
		'date',
		'make',
		'model',
		'seria',
		'engine',
		'year',
		'owner',
		'phone',
		'isChecked',
		'isPaid',
		'link',
	),
)); ?>
