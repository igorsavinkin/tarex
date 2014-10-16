<?php
/* @var $this AdvertisementController */
/* @var $model Advertisement */

$this->breadcrumbs=array(
	Yii::t('general','Advertisements')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('general','List Advertisement'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Advertisement'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update Advertisement'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete Advertisement'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage Advertisement'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View Advertisement') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'advertisement-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'blockId' =>array( 
			'name'=>'blockId',
			'value'=>'Block::model()->findByPk($data->blockId)->name',
			'filter' => CHtml::listData(Block::model()->findall(), 'id', 'name'),		
		),
		'content',
		'isActive',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'blockId',
		'content',
		'isActive',
	),
)); ?>
