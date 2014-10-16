<?php
/* @var $this EventContentController */
/* @var $model EventContent */

$this->breadcrumbs=array(
	Yii::t('general','Event Contents')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('general','List EventContent'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create EventContent'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update EventContent'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete EventContent'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage EventContent'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View EventContent') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'event-content-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'eventId' =>array( 
			'name'=>'eventId',
			'value'=>'Event::model()->findByPk($data->eventId)->name',
			'filter' => CHtml::listData(Event::model()->findall(), 'id', 'name'),		
		),
		'assortmentId' =>array( 
			'name'=>'assortmentId',
			'value'=>'Assortment::model()->findByPk($data->assortmentId)->name',
			'filter' => CHtml::listData(Assortment::model()->findall(), 'id', 'name'),		
		),
		'assortmentTitle',
		'assortmentAmount',
		'discount',
		'price',
		'cost',
		'cost_w_discount',
		/*
		'RecommendedPrice',
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
		'eventId',
		'assortmentId',
		'assortmentTitle',
		'assortmentAmount',
		'discount',
		'price',
		'cost',
		'cost_w_discount',
		'RecommendedPrice',
	),
)); ?>
